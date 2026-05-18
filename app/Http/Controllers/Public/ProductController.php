<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Filter by category slug
        if ($request->filled('category')) {
            $category = Category::with('children:id,parent_id')
                ->where('slug', $request->category)
                ->first();
            if ($category) {
                $categoryIds = $category->children->pluck('id')
                    ->push($category->id)
                    ->all();

                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(function ($q2) use ($request) {
                      $q2->whereNull('sale_price')->where('price', '>=', $request->min_price);
                  });
            });
        }
        if ($request->filled('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(function ($q2) use ($request) {
                      $q2->whereNull('sale_price')->where('price', '<=', $request->max_price);
                  });
            });
        }

        // Search by name
        if ($request->filled('q')) {
            $search = strip_tags(mb_substr(trim($request->q), 0, 100));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter toggles

        if ($request->boolean('on_sale')) {
            $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price');
        }
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'price_low'   => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'price_high'  => $query->orderByRaw('COALESCE(sale_price, price) DESC'),

            default       => $query->latest(),
        };

        $products = $query->paginate(24)->withQueryString();

        // Sidebar data (no cache to avoid serialization issues with file driver)
        $categories = Category::where('status', 'active')
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        $priceRange = [
            'min' => (int) Product::active()->min('price'),
            'max' => (int) Product::active()->max('price'),
        ];

        $currentCategory = $request->filled('category')
            ? $categories->firstWhere('slug', $request->category)
            : null;

        $filters = $request->only(['category', 'min_price', 'max_price', 'q', 'on_sale', 'in_stock']);

        if ($request->ajax()) {
            $view = view('public.products._grid', compact('products'))->render();
            return response()->json([
                'html' => $view,
                'next_page_url' => $products->nextPageUrl(),
                'total' => $products->total(),
                'count' => $products->count(),
                'has_more' => $products->hasMorePages()
            ]);
        }

        return view('public.products.index', compact(
            'products', 'categories', 'currentCategory', 'filters', 'sort', 'priceRange'
        ));
    }

    public function show(string $slug): View
    {
        $product = Product::with('category')
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::with('category')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $reviews = $product->reviews()->approved()->latest()->get();
        $avgRating = round($reviews->avg('rating') ?? 0);

        return view('public.products.show', compact('product', 'relatedProducts', 'reviews', 'avgRating'));
    }
}
