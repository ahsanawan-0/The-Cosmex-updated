@props(['product'])

<article class="product-card group relative flex flex-col overflow-hidden rounded-2xl bg-white transition-all duration-300 hover:-translate-y-1">
    {{-- Image Container --}}
    <div class="relative overflow-hidden bg-bg-light" style="aspect-ratio: 1 / 1;">
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full" aria-label="{{ $product->name }}">
            <img
                src="{{ $product->main_image_url }}"
                alt="{{ $product->name }}"
                width="500"
                height="500"
                loading="lazy"
                class="h-full w-full object-contain p-4 transition-transform duration-700 group-hover:scale-105"
            >
        </a>

        {{-- Sale Badge --}}
        @if($product->is_on_sale)
            <span class="absolute left-3 top-3 z-10 rounded-full bg-accent px-2.5 py-1 text-[10px] font-bold text-white">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- View Detail Overlay --}}
        <div class="absolute inset-x-0 bottom-0 z-20 p-3 opacity-0 transition-all duration-300 group-hover:opacity-100">
            <a href="{{ route('products.show', $product->slug) }}" class="flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-primary text-sm font-bold text-white shadow-md transition active:scale-95">
                <i class="fa-solid fa-eye text-sm"></i>
                View Details
            </a>
        </div>
    </div>

    {{-- Product Info --}}
    <div class="flex flex-1 flex-col gap-2 p-4">
        {{-- Category --}}
        @if($product->category)
        <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block w-fit text-[10px] font-bold uppercase text-accent transition-colors hover:text-primary">
            {{ $product->category->name }}
        </a>
        @endif

        {{-- Name --}}
        <a href="{{ route('products.show', $product->slug) }}">
            <h3 class="line-clamp-2 text-sm font-semibold leading-snug text-text-primary transition-colors duration-300 hover:text-primary">
                {{ $product->name }}
            </h3>
        </a>

        {{-- Subtitle --}}
        @if(!empty($product->subtitle))
            <p class="text-[11px] font-medium text-text-secondary leading-tight -mt-1">{{ $product->subtitle }}</p>
        @endif

        {{-- Price --}}
        <div class="mt-auto flex items-center justify-between gap-2.5 pt-2">
            <div>
            @if($product->is_on_sale)
                <span class="text-base font-bold text-text-primary">Rs.{{ number_format($product->sale_price, 0) }}</span>
                <span class="text-xs text-text-secondary line-through">Rs.{{ number_format($product->price, 0) }}</span>
            @else
                <span class="text-base font-bold text-text-primary">Rs.{{ number_format($product->price, 0) }}</span>
            @endif
            </div>
            <a href="{{ route('products.show', $product->slug) }}" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-bg-light text-primary transition group-hover:bg-primary group-hover:text-white" aria-label="View {{ $product->name }}">
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</article>
