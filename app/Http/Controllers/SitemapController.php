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
            ->select(['slug', 'updated_at'])
            ->get();

        $categories = Category::query()
            ->where('status', 'active')
            ->select(['slug', 'updated_at'])
            ->get();

        $pages = [
            ['loc' => route('home'),           'lastmod' => now()->toDateString(), 'changefreq' => 'daily',   'priority' => '1.0'],
            ['loc' => route('products.index'),  'lastmod' => now()->toDateString(), 'changefreq' => 'daily',   'priority' => '0.9'],
            ['loc' => route('about'),           'lastmod' => now()->toDateString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('contact'),         'lastmod' => now()->toDateString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('privacy'),         'lastmod' => now()->toDateString(), 'changefreq' => 'yearly',  'priority' => '0.3'],
            ['loc' => route('terms'),           'lastmod' => now()->toDateString(), 'changefreq' => 'yearly',  'priority' => '0.3'],
        ];

        return response()
            ->view('sitemap', compact('pages', 'products', 'categories'))
            ->header('Content-Type', 'application/xml');
    }
}
