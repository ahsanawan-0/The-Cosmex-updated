"""
makeupshakeup.shop — Complete Product Scraper
=============================================
Strategy 1 (RECOMMENDED): Shopify JSON API — fast, no browser needed
Strategy 2 (FALLBACK):     HTML scraping with cloudscraper (Cloudflare bypass)

Install requirements:
    pip install requests beautifulsoup4 lxml cloudscraper

Run:
    python scraper.py

Output:
    products.csv  (same folder)
"""

import requests
import cloudscraper
from bs4 import BeautifulSoup
import json, csv, time, re, sys
from urllib.parse import urljoin

# ─── Config ───────────────────────────────────────────────────────────────────
BASE_URL       = "https://makeupshakeup.shop"
COLLECTION     = "all-collection"
OUTPUT_FILE    = "products.csv"
DELAY_BETWEEN  = 0.8   # seconds between requests (be polite)
FETCH_DETAIL   = True  # set False to skip detail-page calls (much faster)
# ──────────────────────────────────────────────────────────────────────────────

CSV_FIELDS = [
    "product_id", "variant_id", "name", "slug", "product_url",
    "price", "price_raw", "compare_at_price",
    "main_image", "hover_image",
    "short_description", "available", "max_quantity",
    "categories", "tags", "vendor",
]

HEADERS = {
    "User-Agent": (
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/124.0.0.0 Safari/537.36"
    ),
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "en-US,en;q=0.9",
}


# ═══════════════════════════════════════════════════════════════════════════════
# STRATEGY 1: Shopify JSON API
# Fast, structured, handles pagination automatically.
# URL: /collections/{handle}/products.json?limit=250&page=N
# ═══════════════════════════════════════════════════════════════════════════════

def fmt_price(raw):
    """Shopify JSON API prices are strings like '1200.00'."""
    try:
        return f"Rs.{float(raw):,.2f}" if raw else ""
    except:
        return str(raw)


def scrape_via_json_api(session):
    """
    Use Shopify's built-in /products.json endpoint.
    Returns list of product dicts in our CSV format.
    """
    all_products = []
    page = 1

    while True:
        url = f"{BASE_URL}/collections/{COLLECTION}/products.json?limit=250&page={page}"
        print(f"  [API] Page {page}: {url}")
        try:
            resp = session.get(url, headers=HEADERS, timeout=20)
            resp.raise_for_status()
            data = resp.json()
        except Exception as e:
            print(f"  [ERROR] {e}")
            break

        products = data.get("products", [])
        if not products:
            break

        for p in products:
            first_variant = p["variants"][0] if p.get("variants") else {}
            images        = p.get("images", [])
            main_img      = images[0]["src"] if images else ""
            hover_img     = images[1]["src"] if len(images) > 1 else ""

            # Short description: strip HTML from body_html
            body_html = p.get("body_html", "")
            soup      = BeautifulSoup(body_html, "lxml")
            short_desc = soup.get_text(" ", strip=True)[:300]

            all_products.append({
                "product_id":        p.get("id", ""),
                "variant_id":        first_variant.get("id", ""),
                "name":              p.get("title", ""),
                "slug":              p.get("handle", ""),
                "product_url":       f"{BASE_URL}/products/{p.get('handle','')}",
                "price":             fmt_price(first_variant.get("price")),
                "price_raw":         first_variant.get("price", ""),
                "compare_at_price":  fmt_price(first_variant.get("compare_at_price")),
                "main_image":        main_img,
                "hover_image":       hover_img,
                "short_description": short_desc,
                "available":         first_variant.get("available", ""),
                "max_quantity":      "",   # not in JSON API
                "categories":        "",
                "tags":              ", ".join(p.get("tags", [])),
                "vendor":            p.get("vendor", ""),
            })

        print(f"    Got {len(products)} products (total so far: {len(all_products)})")

        if len(products) < 250:
            break   # last page
        page += 1
        time.sleep(DELAY_BETWEEN)

    return all_products


# ═══════════════════════════════════════════════════════════════════════════════
# STRATEGY 2: HTML Scraping (fallback)
# Parses data-product-options JSON embedded in each product card.
# Uses cloudscraper to bypass Cloudflare.
# ═══════════════════════════════════════════════════════════════════════════════

def get_img_url(srcset_str, width=600):
    if not srcset_str:
        return ""
    first = srcset_str.strip().split(",")[0].strip().split(" ")[0]
    first = re.sub(r"&width=\d+", f"&width={width}", first)
    if first.startswith("//"):
        first = "https:" + first
    return first


def scrape_detail_page(session, product_url):
    try:
        resp = session.get(product_url, headers=HEADERS, timeout=15)
        soup = BeautifulSoup(resp.text, "lxml")
        cats = [a.get_text(strip=True) for a in soup.select(".t4s-collections-wrapper a")]
        return {"categories": ", ".join(cats)}
    except Exception as e:
        print(f"    [WARN] Detail fetch failed for {product_url}: {e}")
        return {"categories": ""}


def parse_collection_page(html):
    soup = BeautifulSoup(html, "lxml")
    products = []

    for card in soup.select("[data-product-options]"):
        try:
            opts = json.loads(card.get("data-product-options", "{}"))

            product_id  = opts.get("id", "")
            variant_id  = opts.get("VariantFirstID", "")
            handle      = opts.get("handle", "")
            available   = opts.get("available", False)
            max_qty     = opts.get("maxQuantity", "")
            price_raw   = opts.get("price", 0)
            cap_raw     = opts.get("compare_at_price")
            image2_raw  = opts.get("image2", "")

            title_el = card.select_one(".t4s-product-title a")
            name = title_el.get_text(strip=True) if title_el else handle

            main_img_el = card.select_one("[data-pr-img]")
            main_image = ""
            if main_img_el:
                srcset = main_img_el.get("data-srcset") or main_img_el.get("srcset", "")
                main_image = get_img_url(srcset)

            hover_image = ""
            hover_img_el = card.select_one("[data-pr-img2]")
            if hover_img_el:
                srcset2 = hover_img_el.get("data-srcset") or hover_img_el.get("srcset", "")
                hover_image = get_img_url(srcset2)
            elif image2_raw and image2_raw is not False:
                hover_image = "https:" + re.sub(r"&width=\d+", "&width=600", str(image2_raw))

            desc_el = card.select_one(".t4s-rte")
            short_desc = desc_el.get_text(strip=True) if desc_el else ""

            def to_display(p):
                return f"Rs.{p/100:,.2f}" if p else ""

            products.append({
                "product_id":        product_id,
                "variant_id":        variant_id,
                "name":              name,
                "slug":              handle,
                "product_url":       f"{BASE_URL}/products/{handle}",
                "price":             to_display(price_raw),
                "price_raw":         price_raw,
                "compare_at_price":  to_display(cap_raw) if cap_raw else "",
                "main_image":        main_image,
                "hover_image":       hover_image,
                "short_description": short_desc,
                "available":         available,
                "max_quantity":      max_qty,
                "categories":        "",
                "tags":              "",
                "vendor":            "",
            })
        except Exception as e:
            print(f"  [WARN] Card parse error: {e}")

    # Next page
    next_url = None
    load_more = soup.select_one("[data-load-more]")
    if load_more:
        href = load_more.get("href", "")
        if href:
            next_url = urljoin(BASE_URL, href)

    return products, next_url


def scrape_via_html(scraper_session):
    all_products = []
    url = f"{BASE_URL}/collections/{COLLECTION}"
    page = 1

    while url:
        print(f"  [HTML] Page {page}: {url}")
        try:
            resp = scraper_session.get(url, headers=HEADERS, timeout=20)
            resp.raise_for_status()
        except Exception as e:
            print(f"  [ERROR] {e}")
            break

        products, next_url = parse_collection_page(resp.text)
        print(f"    Got {len(products)} products")

        if FETCH_DETAIL:
            for p in products:
                detail = scrape_detail_page(scraper_session, p["product_url"])
                p.update(detail)
                time.sleep(0.4)

        all_products.extend(products)

        if next_url and next_url != url:
            url = next_url
            page += 1
            time.sleep(DELAY_BETWEEN)
        else:
            break

    return all_products


# ═══════════════════════════════════════════════════════════════════════════════
# MAIN
# ═══════════════════════════════════════════════════════════════════════════════

def write_csv(products, path):
    with open(path, "w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=CSV_FIELDS, extrasaction="ignore")
        writer.writeheader()
        writer.writerows(products)
    print(f"\n✅  {len(products)} products → {path}")


def main():
    print("=" * 60)
    print("  makeupshakeup.shop Product Scraper")
    print("=" * 60)

    # ── Try Strategy 1: JSON API ──────────────────────────────────
    print("\n[Strategy 1] Trying Shopify JSON API…")
    session = requests.Session()
    try:
        test = session.get(
            f"{BASE_URL}/collections/{COLLECTION}/products.json?limit=1",
            headers=HEADERS, timeout=10
        )
        if test.status_code == 200 and test.json().get("products"):
            print("  ✅ JSON API accessible — using fast API mode.")
            products = scrape_via_json_api(session)
            write_csv(products, OUTPUT_FILE)
            return
        else:
            print(f"  ⚠️  JSON API returned {test.status_code}, falling back to HTML.")
    except Exception as e:
        print(f"  ⚠️  JSON API failed: {e}")

    # ── Try Strategy 2: HTML scraping with cloudscraper ───────────
    print("\n[Strategy 2] Trying HTML scraping with Cloudflare bypass…")
    try:
        cf_scraper = cloudscraper.create_scraper(
            browser={"browser": "chrome", "platform": "windows", "desktop": True}
        )
        products = scrape_via_html(cf_scraper)
        if products:
            write_csv(products, OUTPUT_FILE)
        else:
            print("\n❌  No products found. The site may require a logged-in session")
            print("    or more advanced bypass. Try running from a residential IP.")
            sys.exit(1)
    except Exception as e:
        print(f"\n❌  HTML scraping also failed: {e}")
        sys.exit(1)


if __name__ == "__main__":
    main()