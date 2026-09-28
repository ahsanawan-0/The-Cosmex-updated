<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::active()
            ->select(['slug', 'name', 'main_image', 'updated_at'])
            ->orderBy('id')
            ->get();

        // Empty categories are noindex, so they are left out of the sitemap too.
        $categories = Category::query()
            ->where('status', 'active')
            ->withActiveProducts()
            ->orderBy('sort_order')
            ->select(['id', 'slug', 'updated_at'])
            ->get();

        $latestProductUpdate = optional($products->max('updated_at'))->toDateString();

        $pages = [
            [
                'loc' => route('home'),
                'lastmod' => $latestProductUpdate ?? $this->viewDate('public/home/index'),
                'videos' => array_values(array_filter(
                    config('site.videos', []),
                    fn ($video) => is_file(public_path('videos/' . $video['file'] . '.mp4')),
                )),
            ],
            ['loc' => route('products.index'), 'lastmod' => $latestProductUpdate ?? $this->viewDate('public/products/index')],
            ['loc' => route('about'), 'lastmod' => $this->viewDate('public/pages/about')],
            ['loc' => route('contact'), 'lastmod' => $this->viewDate('public/pages/contact')],
            ['loc' => route('privacy'), 'lastmod' => $this->viewDate('public/pages/privacy')],
            ['loc' => route('terms'), 'lastmod' => $this->viewDate('public/pages/terms')],
        ];

        return response()
            ->view('sitemap', compact('pages', 'products', 'categories'))
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /** Last time a static page's template changed, as a sitemap date. */
    private function viewDate(string $view): string
    {
        $path = resource_path("views/{$view}.blade.php");

        return date('Y-m-d', is_file($path) ? filemtime($path) : time());
    }
}
