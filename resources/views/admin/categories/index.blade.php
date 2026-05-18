@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Categories')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Structure</p>
                <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Manage categories</h2>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-lg bg-primary px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-opacity-90 uppercase tracking-widest">
                + Add Category
            </a>
        </div>

        <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50">
                        <tr class="text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                            <th class="px-6 py-4">Image</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Parent</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Products</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Sort Order</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ $category['image_url'] }}" alt="{{ $category['name'] }}" class="h-[50px] w-[50px] rounded-lg border border-zinc-200 object-cover">
                                </td>
                                <td class="px-6 py-4 font-semibold text-zinc-900 whitespace-nowrap">{{ $category['name'] }}</td>
                                <td class="px-6 py-4 text-zinc-500 whitespace-nowrap">
                                    @if($category['parent_name'])
                                        <span class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-1 text-[10px] font-medium text-zinc-600">{{ $category['parent_name'] }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-zinc-500 whitespace-nowrap">{{ $category['slug'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category['products_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $category['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-zinc-50 text-zinc-600 ring-1 ring-inset ring-zinc-500/10' }}">
                                        {{ ucfirst($category['status']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $category['sort_order'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category['id']) }}" class="rounded-lg border border-zinc-200 px-3 py-2 text-xs font-bold text-primary transition hover:bg-primary hover:border-primary">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category['id']) }}" onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-zinc-500">No categories available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="border-t border-zinc-100 px-6 py-5">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
