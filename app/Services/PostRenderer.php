<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Turns a post body into page HTML.
 *
 * Shortcodes keep prices and stock current instead of freezing them in text:
 *   [[products:slug-a,slug-b]]  live price table
 *   [[price:slug]]              "PKR 75,000"
 *   [[range:category-slug]]     "PKR 70,000 to PKR 500,000" (category + children)
 *   [[total:slug-a,slug-b]]     sum of the listed products' prices
 *   [[video:file]]              one of config('site.videos')
 *   [[cta]]                     WhatsApp / category call to action
 * Every <h2> gets an id, and the list of them becomes the table of contents.
 */
class PostRenderer
{
    private array $products = [];

    public function render(Post $post): array
    {
        $html = (string) $post->body;

        // Block shortcodes that sit alone in a paragraph replace the whole <p>.
        $html = preg_replace_callback(
            '/<p[^>]*>\s*\[\[(products|video|cta)(?::([^\]]*))?\]\]\s*<\/p>/i',
            fn ($m) => $this->shortcode(strtolower($m[1]), $m[2] ?? '', $post),
            $html
        );
        $html = preg_replace_callback(
            '/\[\[(products|video|cta|price|range|total)(?::([^\]]*))?\]\]/i',
            fn ($m) => $this->shortcode(strtolower($m[1]), $m[2] ?? '', $post),
            $html
        );

        $toc = [];
        $used = [];
        $html = preg_replace_callback('/<h2([^>]*)>(.*?)<\/h2>/is', function ($m) use (&$toc, &$used) {
            $text = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if (preg_match('/\bid="([^"]+)"/', $m[1], $existing)) {
                $id = $existing[1];
                $attributes = $m[1];
            } else {
                $base = Str::slug($text) ?: 'section';
                $id = $base;
                for ($i = 2; in_array($id, $used, true); $i++) {
                    $id = "{$base}-{$i}";
                }
                $attributes = $m[1] . ' id="' . $id . '"';
            }
            $used[] = $id;
            $toc[] = ['id' => $id, 'text' => $text];

            return "<h2{$attributes}>{$m[2]}</h2>";
        }, $html);

        return ['html' => $html, 'toc' => $toc];
    }

    private function shortcode(string $name, string $argument, Post $post): string
    {
        $slugs = collect(explode(',', $argument))->map(fn ($slug) => trim(strip_tags($slug)))->filter()->values();

        return match ($name) {
            'products' => view('public.blog.shortcodes.products', ['products' => $this->products($slugs)])->render(),
            'price' => $this->formatPrice(optional($this->products($slugs)->first())->display_price),
            'range' => $this->range($slugs->first()),
            'total' => $this->formatPrice($this->products($slugs)->sum(fn ($product) => (float) $product->display_price) ?: null),
            'video' => $this->video($slugs->first()),
            'cta' => view('public.blog.shortcodes.cta', ['post' => $post, 'category' => $post->category])->render(),
            default => '',
        };
    }

    /** Active products for the given slugs, in the order they were listed. */
    private function products(Collection $slugs): Collection
    {
        $missing = $slugs->reject(fn ($slug) => array_key_exists($slug, $this->products))->all();

        if ($missing) {
            $found = Product::active()->whereIn('slug', $missing)->get()->keyBy('slug');
            foreach ($missing as $slug) {
                $this->products[$slug] = $found->get($slug);
            }
        }

        return $slugs->map(fn ($slug) => $this->products[$slug] ?? null)->filter()->values();
    }

    private function range(?string $categorySlug): string
    {
        $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
        if (! $category) {
            return 'on request';
        }

        $ids = $category->children()->pluck('id')->push($category->id);
        $prices = Product::active()->whereIn('category_id', $ids)->get()->map(fn ($product) => (float) $product->display_price);

        if ($prices->isEmpty()) {
            return 'on request';
        }

        return $this->formatPrice($prices->min()) . ' to ' . $this->formatPrice($prices->max());
    }

    private function video(?string $file): string
    {
        $video = collect(config('site.videos', []))->firstWhere('file', $file);

        if (! $video || ! is_file(public_path('videos/' . $video['file'] . '.mp4'))) {
            return '';
        }

        return view('public.blog.shortcodes.video', ['video' => $video])->render();
    }

    private function formatPrice(float|int|string|null $price): string
    {
        return $price ? 'PKR ' . number_format((float) $price) : 'price on request';
    }
}
