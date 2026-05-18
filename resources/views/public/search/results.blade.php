@extends('layouts.app')

@section('title', $query ? "Search Results for {$query} | Cosmex Pvt Ltd" : 'Search | Cosmex Pvt Ltd')
@section('meta_description', $query ? "Browse products matching '{$query}' at Cosmex Pakistan." : 'Browse our complete collection of authentic clinic quality products. Shop by category or price. Inquire via WhatsApp.')
@section('canonical', url('/search'))

@section('content')
    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-zinc-100">
        <div class="mx-auto max-w-[1280px] px-4 py-4 sm:px-6 lg:px-8">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Search Results'],
            ]" />
        </div>
    </div>

    {{-- Add noindex for search pages --}}
    @push('head')
        <meta name="robots" content="noindex, follow">
    @endpush

    <section class="bg-bg-light py-10 lg:py-16">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">

            {{-- Search Header --}}
            <div class="mb-10 text-center">
                @if ($query)
                    <h1 class="font-heading text-3xl text-zinc-900 sm:text-4xl">
                        Search results for <span class="text-primary">"{{ $query }}"</span>
                    </h1>
                    @if ($products instanceof \Illuminate\Pagination\AbstractPaginator)
                        <p class="mt-3 text-sm text-zinc-500">Showing {{ $products->total() }} {{ Str::plural('result', $products->total()) }}</p>
                    @endif
                @else
                    <h1 class="font-heading text-3xl text-zinc-900 sm:text-4xl">Search Products</h1>
                    <p class="mt-3 text-sm text-zinc-500">Enter a keyword to search our beauty catalog.</p>
                @endif
            </div>

            {{-- Search Bar --}}
            <div class="mx-auto mb-10 max-w-xl">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-primary">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </span>
                    <input type="search" name="q" value="{{ $query }}" placeholder="Search aesthetic products, machines..."
                        class="h-14 w-full rounded-full border border-border bg-white pl-12 pr-6 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/15">
                </form>
            </div>

            @if ($query !== '')
                @if ($products instanceof \Illuminate\Pagination\AbstractPaginator && $products->count())
                    {{-- Product Grid --}}
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 lg:gap-5">
                        @foreach ($products as $product)
                            <x-product.card :product="$product" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @else
                    {{-- No Results --}}
                    <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-20 text-center">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-zinc-100 text-zinc-300">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        </div>
                        <h3 class="mt-6 font-heading text-2xl text-zinc-900">No products found for "{{ $query }}"</h3>
                        <p class="mt-2 max-w-sm text-sm text-zinc-500">Try a different search term or browse our popular categories.</p>

                        {{-- Suggestions --}}
                        <div class="mt-6">
                            <p class="text-xs font-medium uppercase tracking-[0.2em] text-zinc-400">Try searching for:</p>
                            <div class="mt-3 flex flex-wrap justify-center gap-2">
                                @foreach (['Lipstick', 'Foundation', 'Serum', 'Mascara', 'Eyeliner', 'Moisturizer'] as $suggestion)
                                    <a href="{{ route('search', ['q' => $suggestion]) }}"
                                        class="rounded-full border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition hover:border-primary hover:text-primary">
                                        {{ $suggestion }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('products.index') }}" class="btn-primary mt-8 inline-flex items-center text-sm">Browse All Products</a>
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
