@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    @php
        $cards = [
            ['label' => 'Total Products', 'value' => $stats['products'], 'icon' => 'fa-solid fa-box', 'iconBg' => 'bg-primary', 'iconText' => 'text-white'],
            ['label' => 'Active Products', 'value' => $stats['active_products'], 'icon' => 'fa-solid fa-check', 'iconBg' => 'bg-emerald-500', 'iconText' => 'text-white'],
            ['label' => 'Inactive Products', 'value' => $stats['inactive_products'], 'icon' => 'fa-solid fa-power-off', 'iconBg' => 'bg-zinc-400', 'iconText' => 'text-white'],
            ['label' => 'Low Stock', 'value' => $stats['low_stock_products'], 'icon' => 'fa-solid fa-triangle-exclamation', 'iconBg' => 'bg-red-500', 'iconText' => 'text-white'],
            ['label' => 'Categories', 'value' => $stats['categories'], 'icon' => 'fa-solid fa-layer-group', 'iconBg' => 'bg-primary', 'iconText' => 'text-white'],
        ];
    @endphp

    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Overview</p>
            <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Catalog performance at a glance</h2>
            <p class="mt-2 text-sm text-zinc-500">Track stock, activity, and fresh additions from one place.</p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center rounded-lg bg-primary px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-opacity-90 uppercase tracking-widest">
                + Add Product
            </a>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-lg border border-zinc-200 bg-white px-5 py-3 text-sm font-bold text-primary shadow-sm transition hover:border-primary hover:bg-zinc-50 uppercase tracking-widest">
                + Add Category
            </a>
            <a href="{{ route('admin.products.import') }}" class="inline-flex items-center rounded-lg border border-zinc-200 bg-white px-5 py-3 text-sm font-bold text-primary shadow-sm transition hover:border-primary hover:bg-zinc-50 uppercase tracking-widest">
                Import CSV
            </a>
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        @foreach ($cards as $card)
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-zinc-500">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($card['value']) }}</p>
                    </div>
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $card['iconBg'] }}">
                        <i class="{{ $card['icon'] }} {{ $card['iconText'] }} text-lg"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(320px,1fr)]">
        <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-5">
                <div>
                    <h3 class="text-lg font-bold text-zinc-900">Recent Products</h3>
                    <p class="text-sm text-zinc-500">Latest five catalog additions.</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-primary hover:underline">View all</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50">
                        <tr class="text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                            <th class="px-6 py-4">Image</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                        @forelse ($recentProducts as $product)
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="{{ $product['main_image_url'] }}" alt="{{ $product['name'] }}" class="h-14 w-14 rounded-2xl border border-zinc-200 object-cover">
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-zinc-900">{{ $product['name'] }}</p>
                                    <p class="text-xs text-zinc-500">{{ $product['slug'] }}</p>
                                </td>
                                <td class="px-6 py-4 font-medium text-zinc-900">Rs. {{ number_format($product['price'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $product['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-zinc-50 text-zinc-600 ring-1 ring-inset ring-zinc-500/10' }}">
                                        {{ ucfirst($product['status']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-zinc-500">{{ $product['created_at'] ? \Illuminate\Support\Carbon::parse($product['created_at'])->format('d M, Y') : '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product['id']) }}" class="rounded-lg border border-zinc-200 px-3 py-2 text-xs font-bold text-primary transition hover:bg-primary hover:border-primary">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product['id']) }}" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-zinc-500">No recent products yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-100 px-6 py-5">
                <h3 class="text-lg font-bold text-zinc-900">Recent Categories</h3>
                <p class="text-sm text-zinc-500">Newest category updates.</p>
            </div>
            <div class="space-y-4 px-6 py-5">
                @forelse ($recentCategories as $category)
                    <div class="rounded-lg border border-zinc-100 bg-zinc-50 px-4 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-bold text-zinc-900">{{ $category['name'] }}</p>
                                <p class="mt-1 text-xs text-zinc-500">{{ $category['slug'] }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $category['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-zinc-50 text-zinc-600 ring-1 ring-inset ring-zinc-500/10' }}">
                                {{ ucfirst($category['status']) }}
                            </span>
                        </div>
                        <p class="mt-3 text-xs text-zinc-500">{{ $category['created_at'] ? \Illuminate\Support\Carbon::parse($category['created_at'])->format('d M, Y') : '—' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-zinc-500">No recent categories yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
