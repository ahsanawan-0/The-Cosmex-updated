@extends('layouts.app')

@section('title', 'Shop All Aesthetic Products & Machines | Cosmex Pvt Ltd Pakistan')
@section('meta_description', 'Browse our complete collection of authentic clinic quality products. Shop by category or price. Inquire via WhatsApp.')
@section('canonical', url('/products'))

@section('content')
    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-zinc-100">
        <div class="mx-auto max-w-[1280px] px-4 py-4 sm:px-6 lg:px-8">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => $currentCategory ? $currentCategory->name : 'All Products'],
            ]" />
        </div>
    </div>

    <section class="bg-bg-light py-8 lg:py-12">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">

            {{-- Active Filter Badges --}}
            @if (array_filter($filters))
                <div class="mb-6 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-zinc-500">Active Filters:</span>
                    @if (!empty($filters['category']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                            Category: {{ $currentCategory?->name ?? $filters['category'] }}
                            <a href="{{ request()->fullUrlWithoutQuery('category') }}" class="ml-1 hover:text-red-500">&times;</a>
                        </span>
                    @endif
                    @if (!empty($filters['min_price']) || !empty($filters['max_price']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                            Price: PKR {{ $filters['min_price'] ?? '0' }} – {{ $filters['max_price'] ?? '∞' }}
                            <a href="{{ request()->fullUrlWithoutQuery(['min_price', 'max_price']) }}" class="ml-1 hover:text-red-500">&times;</a>
                        </span>
                    @endif
                    @if (!empty($filters['q']))
                        <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                            Search: {{ $filters['q'] }}
                            <a href="{{ request()->fullUrlWithoutQuery('q') }}" class="ml-1 hover:text-red-500">&times;</a>
                        </span>
                    @endif
                    <a href="{{ route('products.index') }}" class="text-xs font-medium text-red-500 hover:underline">Clear All</a>
                </div>
            @endif

            <div class="flex flex-col gap-8 lg:flex-row">

                {{-- SIDEBAR --}}
                <aside class="hidden w-full shrink-0 lg:block lg:w-[280px]">
                    <div class="sticky top-52 space-y-8">
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            {{-- Categories --}}
                            <div class="rounded-2xl border border-border bg-white p-5 shadow-card">
                                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Categories</h3>
                                <ul class="mt-4 max-h-[320px] space-y-2 overflow-y-auto pr-1">
                                    @foreach ($categories as $cat)
                                        <li>
                                            <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-1.5 text-sm transition hover:bg-zinc-50">
                                                <input type="radio" name="category" value="{{ $cat->slug }}"
                                                    {{ request('category') === $cat->slug ? 'checked' : '' }}
                                                    onchange="document.getElementById('filterForm').submit()"
                                                    class="h-4 w-4 rounded border-zinc-300 text-primary focus:ring-primary">
                                                <span class="flex-1 text-zinc-700">{{ $cat->name }}</span>
                                                <span class="text-xs text-zinc-400">({{ $cat->products_count }})</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                @if (request('category'))
                                    <a href="{{ route('products.index', request()->except('category')) }}" class="mt-3 block text-xs text-red-500 hover:underline">Clear category</a>
                                @endif
                            </div>

                            {{-- Price Range --}}
                            <div class="mt-6 rounded-2xl border border-border bg-white p-5 shadow-card">
                                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Price Range</h3>
                                <p class="mt-1 text-xs text-zinc-400">PKR {{ number_format($priceRange['min']) }} – {{ number_format($priceRange['max']) }}</p>
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
                                            onchange="document.getElementById('filterForm').submit()"
                                            class="h-4 w-4 rounded border-zinc-300 text-primary focus:ring-primary">
                                        On Sale
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                        <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()"
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
                            {{-- Mobile filter toggle --}}
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
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-20 text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-zinc-100 text-4xl text-zinc-300">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                            </div>
                            <h3 class="mt-6 font-heading text-2xl text-zinc-900">No products found</h3>
                            <p class="mt-2 max-w-sm text-sm text-zinc-500">Try adjusting your filters or search to find what you're looking for.</p>
                            <a href="{{ route('products.index') }}" class="btn-primary mt-6 inline-flex items-center text-sm">Clear All Filters</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Mobile Filter Drawer --}}
    <div class="fixed inset-0 z-[60] hidden" data-mobile-filter-drawer>
        <div class="absolute inset-0 bg-black/50" data-mobile-filter-overlay></div>
        <div class="absolute inset-y-0 right-0 w-full max-w-sm transform bg-white shadow-xl transition-transform" data-mobile-filter-panel>
            <div class="flex h-full flex-col">
                <div class="flex items-center justify-between border-b border-zinc-200 px-5 py-4">
                    <h2 class="text-lg font-semibold text-zinc-900">Filters</h2>
                    <button type="button" data-mobile-filter-close class="rounded-full p-2 text-zinc-400 hover:text-zinc-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto px-5 py-6">
                    <form action="{{ route('products.index') }}" method="GET" id="mobileFilterForm">
                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        {{-- Categories --}}
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Categories</h3>
                            <ul class="mt-3 space-y-2">
                                @foreach ($categories as $cat)
                                    <li>
                                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                            <input type="radio" name="category" value="{{ $cat->slug }}"
                                                {{ request('category') === $cat->slug ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-zinc-300 text-primary focus:ring-primary">
                                            {{ $cat->name }} <span class="text-xs text-zinc-400">({{ $cat->products_count }})</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Price --}}
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Price Range</h3>
                            <div class="mt-3 flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                    class="h-10 w-full rounded-lg border border-zinc-200 px-3 text-sm">
                                <span class="text-zinc-300">–</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                    class="h-10 w-full rounded-lg border border-zinc-200 px-3 text-sm">
                            </div>
                        </div>

                        {{-- Toggles --}}
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-900">Show Only</h3>
                            <div class="mt-3 space-y-3">

                                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                    <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-zinc-300 text-primary">
                                    On Sale
                                </label>
                                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-zinc-700">
                                    <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-zinc-300 text-primary">
                                    In Stock
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary w-full text-center text-sm font-semibold">Apply Filters</button>
                        <a href="{{ route('products.index') }}" class="mt-3 block text-center text-sm text-red-500 hover:underline">Clear All</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile Drawer Logic
        const toggleBtn = document.querySelector('[data-mobile-filter-toggle]');
        const drawer = document.querySelector('[data-mobile-filter-drawer]');
        const overlay = document.querySelector('[data-mobile-filter-overlay]');
        const closeBtn = document.querySelector('[data-mobile-filter-close]');

        function openDrawer() { drawer && drawer.classList.remove('hidden'); }
        function closeDrawer() { drawer && drawer.classList.add('hidden'); }

        if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);

        // Infinite Scroll Logic
        const loadMoreBtn = document.getElementById('load-more-btn');
        const productGrid = document.getElementById('product-grid');
        const currentCountSpan = document.getElementById('current-count');
        const progressBar = document.getElementById('progress-bar');
        
        let currentCount = parseInt('{{ $products->count() }}');
        const totalCount = parseInt('{{ $products->total() }}');
        let isLoading = false;

        if (loadMoreBtn && productGrid) {
            // Intersection Observer for auto-loading when scrolling near bottom
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
                
                // Show loading state
                const originalText = loadMoreBtn.innerHTML;
                loadMoreBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Loading...';
                loadMoreBtn.classList.add('opacity-75', 'cursor-not-allowed');

                // Add skeleton cards
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
