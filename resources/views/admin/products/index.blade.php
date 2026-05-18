@extends('layouts.admin')

@section('title', 'Products')
@section('page_title', 'Products')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Catalog</p>
                <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Manage products</h2>
                <p class="mt-2 text-sm text-zinc-500">{{ number_format($products->total()) }} products found.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.products.import') }}" class="inline-flex items-center rounded-lg border border-zinc-200 bg-white px-5 py-3 text-sm font-bold text-primary shadow-sm transition hover:border-primary hover:bg-zinc-50 uppercase tracking-widest">
                    Import CSV
                </a>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center rounded-lg bg-primary px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-opacity-90 uppercase tracking-widest">
                    + Add Product
                </a>
            </div>
        </div>

        @if (session('import_summary'))
            <div class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                <h3 class="text-base font-semibold text-zinc-900">Last Import Summary</h3>
                <p class="mt-2 text-sm text-zinc-600">
                    Imported: {{ session('import_summary.imported') }} &middot;
                    Skipped: {{ session('import_summary.skipped') }}
                </p>
                @if (! empty(session('import_summary.errors')))
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-zinc-500">
                        @foreach (array_slice(session('import_summary.errors'), 0, 5) as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <form method="GET" action="{{ route('admin.products.index') }}" class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                <div class="xl:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-medium text-zinc-700">Search</label>
                    <input id="search" name="search" type="text" value="{{ $search }}" placeholder="Search by product name" class="block w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-4 focus:ring-zinc-100">
                </div>

                <div>
                    <label for="category" class="mb-2 block text-sm font-medium text-zinc-700">Category</label>
                    <select id="category" name="category" class="block w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-4 focus:ring-zinc-100">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}" @selected((string) $categoryId === (string) $category['id'])>{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-zinc-700">Status</label>
                    <select id="status" name="status" class="block w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-4 focus:ring-zinc-100">
                        <option value="">All Statuses</option>
                        <option value="active" @selected($status === 'active')>Active</option>
                        <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center rounded-lg bg-primary px-5 py-3 text-xs font-bold text-white shadow-sm transition hover:bg-opacity-90 uppercase tracking-widest">
                    Apply Filters
                </button>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-lg border border-zinc-200 bg-white px-5 py-3 text-xs font-bold text-zinc-700 transition hover:bg-zinc-50 uppercase tracking-widest">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50">
                        <tr class="text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                            <th class="px-6 py-4">Thumbnail</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Stock</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="{{ $product['main_image_url'] }}" alt="{{ $product['name'] }}" class="h-[50px] w-[50px] rounded-2xl border border-zinc-200 object-cover">
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-zinc-900">{{ $product['name'] }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">{{ $product['slug'] }}</p>
                                </td>
                                <td class="px-6 py-4 text-zinc-600">{{ $product['category_name'] ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @if ($product['sale_price'])
                                            <span class="font-medium text-zinc-900">Rs. {{ number_format($product['sale_price'], 2) }}</span>
                                            <span class="text-xs text-zinc-500 line-through">Rs. {{ number_format($product['price'], 2) }}</span>
                                        @else
                                            <span class="font-medium text-zinc-900">Rs. {{ number_format($product['price'], 2) }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($product['stock'] <= 0)
                                        <span class="text-sm font-medium text-red-600">Out of stock</span>
                                    @elseif ($product['stock'] <= 5)
                                        <span class="text-sm font-medium text-orange-600">{{ $product['stock'] }} left</span>
                                    @else
                                        <span class="text-sm text-zinc-900">{{ $product['stock'] }} in stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $product['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-zinc-50 text-zinc-600 ring-1 ring-inset ring-zinc-500/10' }}">
                                        {{ ucfirst($product['status']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="flex gap-2">
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-zinc-500">No products match the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="border-t border-zinc-100 px-6 py-5">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
