<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = strip_tags(mb_substr(trim((string) $request->string('q')), 0, 100));

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

        return view('public.search.results', compact('products', 'query'));
    }
}
