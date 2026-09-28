<?php

namespace App\Http\Controllers\Public;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\Concerns\ListingFilters;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ListingFilters;

    public function index(Request $request)
    {
        $filters = $this->listingFilters($request);

        $query = Product::with('category')->active();
        $stats = $this->listingStats($query);

        // Filter by category slug
        $currentCategoryModel = null;
        if ($filters['category']) {
            $currentCategoryModel = Category::with('children:id,parent_id')
                ->where('slug', $filters['category'])
                ->first();
            if ($currentCategoryModel) {
                $categoryIds = $currentCategoryModel->children->pluck('id')
                    ->push($currentCategoryModel->id)
                    ->all();

                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Search by name
        if ($filters['q']) {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $this->applyListingFilters($query, $filters)
            ->paginate(24)
            ->withQueryString();

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

        // Sidebar data: only categories that actually contain products
        $categories = Category::where('status', 'active')
            ->withActiveProducts()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        $priceRange = ['min' => $stats['min'] ?? 0, 'max' => $stats['max'] ?? 0];
        $currentCategory = $currentCategoryModel;
        $sort = $filters['sort'];
        $noindex = $this->isFilteredListing($request);

        return view('public.products.index', compact(
            'products', 'categories', 'currentCategory', 'filters', 'sort', 'priceRange', 'stats', 'noindex'
        ));
    }

    public function show(string $slug): View
    {
        $product = Product::with('category.parent')
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Same category, closest in price: stable between crawls, unlike random order.
        $relatedProducts = Product::with('category')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderByRaw('ABS(price - ?)', [(float) $product->price])
            ->orderBy('id')
            ->take(5)
            ->get();

        $reviews = $product->reviews()->approved()->latest()->get();
        $avgRating = round($reviews->avg('rating') ?? 0);

        $canonical = url('/products/' . $product->slug);
        $allImages = [$product->main_image_url];
        foreach ($product->gallery_images ?? [] as $galleryImage) {
            $allImages[] = asset('storage/' . $galleryImage);
        }

        $price = number_format((float) $product->display_price);
        $seo = [
            'title' => $product->seo_title ?: "{$product->name} Price in Pakistan",
            'description' => $product->seo_description
                ?: SeoHelper::clean($product->name) . ' for clinics and aesthetic professionals in Pakistan. PKR '
                    . $price . ', delivered nationwide. Ask for wholesale rates on WhatsApp.',
        ];

        $schema = $this->productSchema($product, $canonical, $allImages, $reviews);

        // A buying guide for this product's category (or its parent), if one exists.
        $guide = Post::published()
            ->whereIn('category_slug', array_filter([$product->category?->slug, $product->category?->parent?->slug]))
            ->orderByRaw('CASE WHEN category_slug = ? THEN 0 ELSE 1 END', [$product->category?->slug])
            ->latest('published_at')
            ->first();

        return view('public.products.show', compact('product', 'relatedProducts', 'reviews', 'avgRating', 'canonical', 'allImages', 'seo', 'schema', 'guide'));
    }

    private function productSchema(Product $product, string $canonical, array $images, $reviews): array
    {
        $description = SeoHelper::clean(strip_tags((string) ($product->description ?: $product->short_description)));

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => SeoHelper::clean($product->name),
            'description' => Str::limit($description, 1000),
            'image' => array_values(array_unique($images)),
            'sku' => 'COSMEX-' . str_pad((string) $product->id, 4, '0', STR_PAD_LEFT),
            // The manufacturer's brand when known; the seller is never used as brand.
            'brand' => $product->brand ? ['@type' => 'Brand', 'name' => $product->brand] : null,
            'category' => $product->category?->name,
            'offers' => [
                '@type' => 'Offer',
                'url' => $canonical,
                'priceCurrency' => 'PKR',
                'price' => SeoHelper::schemaPrice($product->display_price),
                'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'seller' => ['@id' => SeoHelper::organizationId()],
            ],
        ];

        // Only real, approved reviews shown on the page are marked up.
        if ($reviews->count() > 0) {
            $data['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => round($reviews->avg('rating'), 1),
                'reviewCount' => $reviews->count(),
                'bestRating' => 5,
                'worstRating' => 1,
            ];
            $data['review'] = $reviews->take(5)->map(fn ($review) => [
                '@type' => 'Review',
                'author' => ['@type' => 'Person', 'name' => $review->reviewer_name],
                'datePublished' => $review->created_at->toDateString(),
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (int) $review->rating, 'bestRating' => 5],
                'reviewBody' => $review->body,
            ])->values()->all();
        }

        return array_filter($data, fn ($value) => $value !== null);
    }
}
