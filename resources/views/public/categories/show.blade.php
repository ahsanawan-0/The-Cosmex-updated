@extends('layouts.app')

@section('title', $category->seo_title ?? "{$category->name} Products - Buy {$category->name} Online in Pakistan | Cosmex Pvt Ltd")
@section('meta_description', $category->seo_description ?? "Shop authentic {$category->name} products online in Pakistan. Best prices & fast delivery. Order on WhatsApp.")
@section('canonical', url("/category/{$category->slug}"))

@section('schema')
{
  "@@context": "https://schema.org",
  "@@type": "CollectionPage",
  "name": "{{ $category->name }} Products",
  "description": "Shop authentic {{ $category->name }} products online in Pakistan. Best prices & fast delivery.",
  "url": "{{ url("/category/{$category->slug}") }}"
}
@endsection

@section('content')
    {{-- Category Hero --}}
    <div class="relative h-[200px] overflow-hidden bg-gradient-to-br from-primary via-[#0A6DCC] to-[#EEF7FF] sm:h-[260px]">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,122,26,0.22),_transparent_50%)]"></div>
        <div class="relative z-10 mx-auto flex h-full max-w-[1180px] flex-col items-start justify-end px-4 pb-8 sm:px-6 lg:px-8">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => $category->name],
            ]" />
            <h1 class="mt-3 font-heading text-4xl text-white sm:text-5xl">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="mt-2 max-w-2xl text-sm text-white/70">{{ $category->description }}</p>
            @endif
        </div>
    </div>

    <section class="bg-bg-light py-8 lg:py-12">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 lg:flex-row">

                {{-- SIDEBAR --}}
                <aside class="hidden w-full shrink-0 lg:block lg:w-[280px]">
                    <div class="sticky top-52 space-y-6">
                        <form action="{{ route('category.show', $category->slug) }}" method="GET" id="catFilterForm">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            {{-- Price Range --}}
                            <div class="rounded-2xl border border-border bg-white p-5 shadow-card">
                                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Price Range</h3>
                                @if ($priceRange['max'] > 0)
                                    <p class="mt-1 text-xs text-zinc-400">PKR {{ number_format($priceRange['min']) }} – {{ number_format($priceRange['max']) }}</p>
                                @endif
                                <div class="mt-4 flex items-center gap-2">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                        class="h-10 w-full rounded-lg border border-border px-3 text-sm text-zinc-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                    <span class="text-zinc-300">–</span>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                        class="h-10 w-full rounded-lg border border-border px-3 text-sm text-zinc-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                </div>
                                <button type="submit" class="btn-primary mt-3 w-full text-center text-sm">Apply Price</button>
                            </div>

                            {{-- Toggle Filters --}}
                            <div class="mt-6 rounded-2xl border border-border bg-white p-5 shadow-card">
                                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Show Only</h3>
                                <div class="mt-4 space-y-3">

                                    <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                        <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}
                                            onchange="document.getElementById('catFilterForm').submit()"
                                            class="h-4 w-4 rounded border-zinc-300 text-primary focus:ring-primary">
                                        On Sale
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                        <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                            onchange="document.getElementById('catFilterForm').submit()"
                                            class="h-4 w-4 rounded border-zinc-300 text-primary focus:ring-primary">
                                        In Stock
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>

                {{-- MAIN CONTENT --}}
                <div class="min-w-0 flex-1">
                    {{-- Sort Bar --}}
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-border bg-white px-5 py-4 shadow-card">
                        <p class="text-sm text-zinc-500">
                            Showing
                            <span class="font-semibold text-zinc-900">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span>
                            of <span class="font-semibold text-zinc-900">{{ $products->total() }}</span> products
                        </p>
                        <div class="flex items-center gap-2 sm:gap-3">
                            {{-- Mobile filter toggle (for category page) --}}
                            <button type="button" data-mobile-filter-toggle class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-700 transition hover:border-primary lg:hidden sm:h-10 sm:w-auto sm:px-4 sm:rounded-lg sm:gap-2">
                                <i class="fa-solid fa-sliders text-sm"></i>
                                <span class="hidden sm:inline text-sm font-medium">Filters</span>
                            </button>

                            {{-- Sort Dropdown --}}
                            <div class="relative">
                                {{-- Mobile Icon underneath --}}
                                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-700 sm:hidden">
                                    <i class="fa-solid fa-arrow-down-wide-short text-sm"></i>
                                </div>
                                {{-- The actual select --}}
                                <select onchange="window.location.href=this.value" class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0 sm:static sm:h-10 sm:w-auto sm:rounded-lg sm:border sm:border-border sm:bg-white sm:px-3 sm:pr-8 sm:text-sm sm:text-zinc-700 sm:opacity-100 sm:outline-none sm:focus:border-primary sm:focus:ring-1 sm:focus:ring-primary sm:appearance-none">
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'bestseller']) }}" {{ $sort === 'bestseller' ? 'selected' : '' }}>Best Sellers</option>
                                </select>
                                {{-- Desktop Select Arrow --}}
                                <div class="pointer-events-none absolute inset-y-0 right-0 hidden sm:flex items-center px-2 text-zinc-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Product Grid --}}
                    @if ($products->count())
                        <div id="product-grid" class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 lg:gap-6">
                            @foreach ($products as $product)
                                <x-product.card :product="$product" />
                            @endforeach
                        </div>

                        @if ($products->hasPages())
                            {{-- Infinite Scroll & Progress --}}
                            <div class="mt-16 mb-8 text-center" id="pagination-container">
                                <p class="text-[13px] text-zinc-500 mb-4 font-medium">
                                    You've viewed <span id="current-count">{{ $products->count() }}</span> of {{ $products->total() }} products
                                </p>
                                <div class="w-64 h-1 bg-zinc-200 mx-auto rounded-full overflow-hidden mb-8">
                                    <div id="progress-bar" class="h-full bg-primary transition-all duration-500 ease-out" style="width: {{ ($products->count() / $products->total()) * 100 }}%"></div>
                                </div>
                                
                                @if($products->hasMorePages())
                                    <button id="load-more-btn" data-url="{{ $products->nextPageUrl() }}" class="inline-flex min-h-12 min-w-[200px] items-center justify-center rounded-full border border-primary px-8 text-xs font-bold uppercase text-primary transition-colors duration-300 hover:bg-primary hover:text-white">
                                        Load More
                                    </button>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-20 text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-zinc-100 text-zinc-300">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <h3 class="mt-6 font-heading text-2xl text-zinc-900">No products in this category yet</h3>
                            <p class="mt-2 max-w-sm text-sm text-zinc-500">We're adding new products daily. Check back soon!</p>
                            <a href="{{ route('products.index') }}" class="btn-primary mt-6 inline-flex items-center text-sm">Browse All Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreBtn = document.getElementById('load-more-btn');
        const productGrid = document.getElementById('product-grid');
        const currentCountSpan = document.getElementById('current-count');
        const progressBar = document.getElementById('progress-bar');
        
        let currentCount = parseInt('{{ $products->count() }}');
        const totalCount = parseInt('{{ $products->total() }}');
        let isLoading = false;

        if (loadMoreBtn && productGrid) {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting && !isLoading) {
                    loadMoreProducts();
                }
            }, { rootMargin: '400px' });
            
            observer.observe(loadMoreBtn);

            loadMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!isLoading) loadMoreProducts();
            });

            function loadMoreProducts() {
                const url = loadMoreBtn.getAttribute('data-url');
                if (!url) return;

                isLoading = true;
                
                const originalText = loadMoreBtn.innerHTML;
                loadMoreBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Loading...';
                loadMoreBtn.classList.add('opacity-75', 'cursor-not-allowed');

                const skeletonHtml = `
                    <div class="skeleton-card flex flex-col bg-white">
                        <div class="relative aspect-square bg-zinc-200 animate-pulse mb-3"></div>
                        <div class="px-1 space-y-2">
                            <div class="h-2 bg-zinc-200 animate-pulse w-1/4"></div>
                            <div class="h-3 bg-zinc-200 animate-pulse w-3/4"></div>
                            <div class="h-3 bg-zinc-200 animate-pulse w-1/2"></div>
                            <div class="h-4 bg-zinc-200 animate-pulse w-1/3 mt-2"></div>
                        </div>
                    </div>
                `.repeat(8); 
                
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = skeletonHtml;
                const skeletons = Array.from(tempDiv.children);
                skeletons.forEach(sk => productGrid.appendChild(sk));

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    skeletons.forEach(sk => sk.remove());
                    productGrid.insertAdjacentHTML('beforeend', data.html);

                    currentCount += data.count;
                    if(currentCountSpan) currentCountSpan.textContent = currentCount;
                    if(progressBar) progressBar.style.width = (currentCount / totalCount * 100) + '%';

                    if (data.has_more) {
                        loadMoreBtn.setAttribute('data-url', data.next_page_url);
                        loadMoreBtn.innerHTML = 'Load More';
                        loadMoreBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    } else {
                        loadMoreBtn.remove();
                        observer.disconnect();
                    }
                    
                    isLoading = false;
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    skeletons.forEach(sk => sk.remove());
                    loadMoreBtn.innerHTML = 'Try Again';
                    loadMoreBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    isLoading = false;
                });
            }
        }
    });
    </script>
@endsection
