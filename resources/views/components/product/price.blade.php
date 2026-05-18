@props(['product'])

@if ($product->is_on_sale)
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm text-zinc-400 line-through">PKR {{ number_format($product->price) }}</span>
        <span class="text-lg font-semibold text-primary">PKR {{ number_format($product->sale_price) }}</span>
    </div>
@else
    <span class="text-lg font-semibold text-zinc-900">PKR {{ number_format($product->price) }}</span>
@endif
