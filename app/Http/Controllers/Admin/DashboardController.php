<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = Cache::remember('admin.dashboard.stats', now()->addMinutes(5), function (): array {
            return [
                'products' => Product::count(),
                'active_products' => Product::where('status', 'active')->count(),
                'inactive_products' => Product::where('status', 'inactive')->count(),
                'low_stock_products' => Product::where('stock', '<=', 5)->count(),
                'categories' => Category::count(),
            ];
        });

        $recentProducts = Cache::remember('admin.dashboard.recent_products', now()->addMinutes(5), function () {
            return Product::query()
                ->select(['id', 'name', 'slug', 'price', 'status', 'created_at', 'main_image'])
                ->latest()
                ->take(5)
                ->get()
                ->map(fn (Product $product): array => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => (float) $product->price,
                    'status' => $product->status,
                    'created_at' => optional($product->created_at)?->toIso8601String(),
                    'main_image_url' => $product->main_image_url,
                ])
                ->all();
        });

        $recentCategories = Cache::remember('admin.dashboard.recent_categories', now()->addMinutes(5), function () {
            return Category::query()
                ->select(['id', 'name', 'slug', 'status', 'created_at'])
                ->latest()
                ->take(5)
                ->get()
                ->map(fn (Category $category): array => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'status' => $category->status,
                    'created_at' => optional($category->created_at)?->toIso8601String(),
                ])
                ->all();
        });

        return view('admin.dashboard.index', compact('stats', 'recentProducts', 'recentCategories'));
    }
}
