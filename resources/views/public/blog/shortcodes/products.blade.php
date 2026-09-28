@if ($products->isNotEmpty())
    <div class="not-prose my-8 overflow-hidden rounded-2xl border border-border bg-white shadow-card">
        <div class="relative overflow-x-auto">
            <table class="w-full min-w-[480px] text-left text-sm">
                <thead class="bg-bg-light text-[11px] font-bold uppercase tracking-wider text-text-secondary">
                    <tr>
                        <th scope="col" class="px-4 py-3">Model</th>
                        <th scope="col" class="px-4 py-3 text-right">Price</th>
                        <th scope="col" class="px-4 py-3">Availability</th>
                        <th scope="col" class="px-4 py-3"><span class="sr-only">Link</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <a href="{{ route('products.show', $product->slug) }}" class="font-semibold text-text-primary hover:text-primary">{{ $product->name }}</a>
                            </td>
                            <td class="px-4 py-3 text-right font-semibold tabular-nums text-text-primary whitespace-nowrap">PKR {{ number_format($product->display_price) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap {{ $product->stock > 0 ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $product->stock > 0 ? 'In stock' : 'Ask for next shipment' }}
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold uppercase text-primary hover:underline">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="border-t border-border bg-bg-light px-4 py-2 text-xs text-text-secondary">Prices update automatically from our catalogue. Confirm the final price and stock on WhatsApp.</p>
    </div>
@endif
