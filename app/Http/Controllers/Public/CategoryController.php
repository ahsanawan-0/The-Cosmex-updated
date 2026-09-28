<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\ListingFilters;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ListingFilters;

    public function show(Request $request, string $slug)
    {
        $filters = $this->listingFilters($request);

        $category = Category::where('status', 'active')
            ->where('slug', $slug)
            ->firstOrFail();

        $category->load('children:id,parent_id');
        $categoryIds = $category->children->pluck('id')
            ->push($category->id)
            ->all();

        $baseQuery = Product::with('category')
            ->active()
            ->whereIn('category_id', $categoryIds);

        $stats = $this->listingStats($baseQuery);

        $products = $this->applyListingFilters(clone $baseQuery, $filters)
            ->paginate(24)
            ->withQueryString();

        // A page number past the end is not a real page.
        abort_if($products->currentPage() > max(1, $products->lastPage()), 404);

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

        $priceRange = ['min' => $stats['min'] ?? 0, 'max' => $stats['max'] ?? 0];
        $sort = $filters['sort'];
        $seo = $category->seoCopy($stats);
        $guides = Post::published()->forCategory($category)->latest('published_at')->take(3)->get();

        // Filtered/sorted variants and empty categories are kept out of the index.
        $noindex = $stats['count'] === 0 || $this->isFilteredListing($request);

        return view('public.categories.show', compact('category', 'products', 'sort', 'priceRange', 'filters', 'stats', 'seo', 'noindex', 'guides'));
    }
}
