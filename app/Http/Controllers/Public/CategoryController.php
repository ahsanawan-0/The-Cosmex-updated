<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $category = Category::where('status', 'active')
            ->where('slug', $slug)
            ->firstOrFail();

        $category->load('children:id,parent_id');
        $categoryIds = $category->children->pluck('id')
            ->push($category->id)
            ->all();

        $query = \App\Models\Product::with('category')
            ->active()
            ->whereIn('category_id', $categoryIds);

        // Price range filter
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

        $priceRange = [
            'min' => (int) \App\Models\Product::active()->whereIn('category_id', $categoryIds)->min('price'),
            'max' => (int) \App\Models\Product::active()->whereIn('category_id', $categoryIds)->max('price'),
        ];

        $filters = $request->only(['min_price', 'max_price', 'on_sale', 'in_stock']);

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

        return view('public.categories.show', compact('category', 'products', 'sort', 'priceRange', 'filters'));
    }
}
