<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['loc'] }}</loc>
        <lastmod>{{ $page['lastmod'] }}</lastmod>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach

    @foreach($categories as $category)
    <url>
        <loc>{{ url('/category/' . $category->slug) }}</loc>
        <lastmod>{{ $category->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    @foreach($products as $product)
    <url>
        <loc>{{ url('/products/' . $product->slug) }}</loc>
        <lastmod>{{ $product->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
