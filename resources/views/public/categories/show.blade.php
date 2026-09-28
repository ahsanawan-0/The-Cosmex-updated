@extends('layouts.app')

@php
    $categoryUrl = url("/category/{$category->slug}");
    $pageCanonical = $products->currentPage() > 1 ? $categoryUrl . '?page=' . $products->currentPage() : $categoryUrl;
    $crumbs = [['label' => 'Home', 'url' => route('home')]];
    if ($category->parent_id && $category->parent) {
        $crumbs[] = ['label' => $category->parent->name, 'url' => route('category.show', $category->parent->slug)];
    }
    $crumbs[] = ['label' => $category->name, 'url' => $categoryUrl];

    $collectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        '@id' => $categoryUrl . '#collection',
        'name' => \App\Helpers\SeoHelper::clean($seo['title']),
        'description' => $seo['description'],
        'url' => $categoryUrl,
        'isPartOf' => ['@id' => url('/') . '/#website'],
        'mainEntity' => [
            '@type' => 'ItemList',
            'numberOfItems' => $products->total(),
            'itemListElement' => $products->getCollection()->values()->map(fn ($item, $i) => [
                '@type' => 'ListItem',
                'position' => $products->firstItem() + $i,
                'url' => url('/products/' . $item->slug),
                'name' => \App\Helpers\SeoHelper::clean($item->name),
            ])->all(),
        ],
    ];
@endphp

@section('title', $seo['title'] . ($products->currentPage() > 1 ? ' – Page ' . $products->currentPage() : ''))
@section('meta_description', $seo['description'])
@section('canonical', $pageCanonical)
@if ($noindex)
    @section('robots', 'noindex, follow')
@endif

@section('schema')
{!! \App\Helpers\SeoHelper::json($collectionSchema) !!}
@endsection

@section('content')
    {{-- Category Hero --}}
    <div class="relative min-h-[200px] overflow-hidden bg-gradient-to-br from-primary via-[#0A6DCC] to-[#EEF7FF] sm:min-h-[260px]">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,122,26,0.22),_transparent_50%)]"></div>
        <div class="relative z-10 mx-auto flex min-h-[200px] max-w-[1180px] flex-col items-start justify-end px-4 pb-8 pt-10 sm:min-h-[260px] sm:px-6 lg:px-8">
            <x-breadcrumb :items="$crumbs" />
            <h1 class="mt-3 font-heading text-4xl text-white sm:text-5xl">{{ $category->name }}</h1>
            @if ($seo['lead'])
                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/90 sm:text-base">{{ $seo['lead'] }}</p>
            @endif
        </div>
    </div>

    <section class="bg-bg-light py-8 lg:py-12">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 lg:flex-row">

                {{-- SIDEBAR --}}
                <aside id="category-filters" class="hidden w-full shrink-0 lg:block lg:w-[280px]">
                    <div class="sticky top-52 space-y-6">
                        <form action="{{ route('category.show', $category->slug) }}" method="GET" id="catFilterForm">
                            @if ($sort !== 'newest')
                                <input type="hidden" name="sort" value="{{ $sort }}">
                            @endif

                            {{-- Price Range --}}
                            <div class="rounded-2xl border border-border bg-white p-5 shadow-card">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Price Range</p>
                                @if ($priceRange['max'] > 0)
                                    <p class="mt-1 text-xs text-zinc-500">PKR {{ number_format($priceRange['min']) }} – {{ number_format($priceRange['max']) }}</p>
                                @endif
                                <div class="mt-4 flex items-center gap-2">
                                    <input type="number" name="min_price" value="{{ $filters['min_price'] }}" placeholder="Min" aria-label="Minimum price"
                                        class="h-10 w-full rounded-lg border border-border px-3 text-sm text-zinc-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                    <span class="text-zinc-300">–</span>
                                    <input type="number" name="max_price" value="{{ $filters['max_price'] }}" placeholder="Max" aria-label="Maximum price"
                                        class="h-10 w-full rounded-lg border border-border px-3 text-sm text-zinc-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                </div>
                                <button type="submit" class="btn-primary mt-3 w-full text-center text-sm">Apply Price</button>
                            </div>

                            {{-- Toggle Filters --}}
                            <div class="mt-6 rounded-2xl border border-border bg-white p-5 shadow-card">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Show Only</p>
                                <div class="mt-4 space-y-3">

                                    <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                        <input type="checkbox" name="on_sale" value="1" {{ $filters['on_sale'] ? 'checked' : '' }}
                                            onchange="document.getElementById('catFilterForm').submit()"
                                            class="h-4 w-4 rounded border-zinc-300 text-primary focus:ring-primary">
                                        On Sale
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                        <input type="checkbox" name="in_stock" value="1" {{ $filters['in_stock'] ? 'checked' : '' }}
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
                            <button type="button" aria-label="Show filters" aria-controls="category-filters"
                                onclick="var f=document.getElementById('category-filters');f.classList.toggle('hidden');this.setAttribute('aria-expanded', !f.classList.contains('hidden'));"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-700 transition hover:border-primary lg:hidden sm:h-10 sm:w-auto sm:px-4 sm:rounded-lg sm:gap-2">
                                <i class="fa-solid fa-sliders text-sm" aria-hidden="true"></i>
                                <span class="hidden sm:inline text-sm font-medium">Filters</span>
                            </button>

                            {{-- Sort Dropdown --}}
                            <div class="relative">
                                {{-- Mobile Icon underneath --}}
                                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-700 sm:hidden">
                                    <i class="fa-solid fa-arrow-down-wide-short text-sm" aria-hidden="true"></i>
                                </div>
                                {{-- The actual select --}}
                                <select aria-label="Sort products" onchange="window.location.href=this.value" class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0 sm:static sm:h-10 sm:w-auto sm:rounded-lg sm:border sm:border-border sm:bg-white sm:px-3 sm:pr-8 sm:text-sm sm:text-zinc-700 sm:opacity-100 sm:outline-none sm:focus:border-primary sm:focus:ring-1 sm:focus:ring-primary sm:appearance-none">
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => null, 'page' => null]) }}" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low', 'page' => null]) }}" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high', 'page' => null]) }}" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
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
                                <x-product.card :product="$product" :eager="$loop->index < 4" />
                            @endforeach
                        </div>

                        @if ($products->hasPages())
                            {{-- Infinite Scroll & Progress (the links also work without JavaScript) --}}
                            <nav class="mt-16 mb-8 text-center" id="pagination-container" aria-label="Pagination">
                                <p class="text-[13px] text-zinc-500 mb-4 font-medium">
                                    You've viewed <span id="current-count">{{ $products->count() }}</span> of {{ $products->total() }} products
                                </p>
                                <div class="w-64 h-1 bg-zinc-200 mx-auto rounded-full overflow-hidden mb-8">
                                    <div id="progress-bar" class="h-full bg-primary transition-all duration-500 ease-out" style="width: {{ ($products->count() / $products->total()) * 100 }}%"></div>
                                </div>

                                @if ($products->onFirstPage() === false)
                                    <a href="{{ $products->currentPage() === 2 ? request()->fullUrlWithQuery(['page' => null]) : $products->previousPageUrl() }}" rel="prev" class="mr-3 inline-flex min-h-12 items-center justify-center rounded-full border border-border px-6 text-xs font-bold uppercase text-text-secondary transition hover:border-primary hover:text-primary">
                                        Previous Page
                                    </a>
                                @endif
                                @if($products->hasMorePages())
                                    <a id="load-more-btn" href="{{ $products->nextPageUrl() }}" rel="next" data-url="{{ $products->nextPageUrl() }}" class="inline-flex min-h-12 min-w-[200px] items-center justify-center rounded-full border border-primary px-8 text-xs font-bold uppercase text-primary transition-colors duration-300 hover:bg-primary hover:text-white">
                                        Load More
                                    </a>
                                @endif
                            </nav>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-20 text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-zinc-100 text-zinc-300">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            @if ($stats['count'] > 0)
                                <h2 class="mt-6 font-heading text-2xl text-zinc-900">No products match these filters</h2>
                                <a href="{{ $categoryUrl }}" class="btn-primary mt-6 inline-flex items-center text-sm">Show all {{ $category->name }}</a>
                            @else
                                <h2 class="mt-6 font-heading text-2xl text-zinc-900">No products in this category yet</h2>
                                <p class="mt-2 max-w-sm text-sm text-zinc-500">We're adding new products regularly. Ask on WhatsApp for current stock.</p>
                                <a href="{{ route('products.index') }}" class="btn-primary mt-6 inline-flex items-center text-sm">Browse All Products</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Related blog guides --}}
    @if ($guides->isNotEmpty() && $products->onFirstPage())
        <section class="bg-bg-light pb-4 pt-2">
            <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl border border-border bg-white p-5 shadow-card">
                    <p class="text-sm font-bold uppercase tracking-wide text-text-primary">Buying guides for {{ $category->name }}</p>
                    <ul class="mt-3 grid gap-2 sm:grid-cols-2">
                        @foreach ($guides as $guide)
                            <li><a href="{{ route('blog.show', $guide->slug) }}" class="inline-flex items-start gap-2 text-sm font-semibold text-primary hover:underline"><i class="fa-solid fa-book-open mt-1 text-xs" aria-hidden="true"></i>{{ $guide->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif

    {{-- Buying guide: only on page 1, so paginated pages do not repeat it --}}
    @if ($seo['content'] && $products->onFirstPage() && $stats['count'] > 0)
        <section class="bg-white py-12 lg:py-16">
            <div class="mx-auto max-w-[860px] px-4 sm:px-6 lg:px-8">
                <div id="category-guide" class="rich-content prose prose-zinc max-w-none prose-headings:font-heading prose-a:text-primary">
                    {!! $seo['content'] !!}
                </div>
            </div>
        </section>
    @endif

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
