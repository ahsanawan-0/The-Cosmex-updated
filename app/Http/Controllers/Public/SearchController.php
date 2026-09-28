<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(is_array($request->query('q')) || is_array($request->query('page')), 404);

        $query = strip_tags(mb_substr(trim((string) $request->query('q', '')), 0, 100));

        $products = collect();

        if ($query !== '') {
            $products = Product::with('category')
                ->active()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('short_description', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhereHas('category', function ($categoryQuery) use ($query) {
                          $categoryQuery->where('name', 'like', "%{$query}%");
                      });
                })
                ->latest()
                ->paginate(24)
                ->withQueryString();
        }

        // Suggestions for empty results: real categories, not search URLs.
        $suggestions = Category::where('status', 'active')
            ->withActiveProducts()
            ->whereNotNull('parent_id')
            ->orderBy('sort_order')
            ->take(8)
            ->get(['name', 'slug']);

        return view('public.search.results', compact('products', 'query', 'suggestions'));
    }
}
