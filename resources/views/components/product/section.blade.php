@props(['products', 'title', 'subtitle', 'categorySlug', 'categoryLabel' => 'View All'])

<section class="bg-bg-light py-10 lg:py-16">
    <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-[11px] font-semibold uppercase text-primary">Featured Collection</p>
                <h2 class="font-heading text-2xl font-bold tracking-normal text-text-primary lg:text-3xl">{{ $title }}</h2>
                @if($subtitle)
                    <p class="mt-2 text-sm text-text-secondary">{{ $subtitle }}</p>
                @endif
            </div>
            <a href="{{ route('products.index', ['category' => $categorySlug]) }}"
               class="inline-flex min-h-12 items-center gap-2 rounded-2xl bg-white px-4 text-sm font-semibold text-primary shadow-sm transition active:scale-95">
                {{ $categoryLabel }}
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- Products Grid --}}
        @if($products->isNotEmpty())
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 lg:grid-cols-4 lg:gap-5">
                @foreach($products as $product)
                    <x-product.card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-zinc-400">
                <i class="fa-solid fa-box-open text-4xl mb-4"></i>
                <p class="text-sm">No products found in this category yet.</p>
            </div>
        @endif
    </div>
</section>
