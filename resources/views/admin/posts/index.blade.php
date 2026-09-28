@extends('layouts.admin')

@section('title', 'Blog')
@section('page_title', 'Blog')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Content</p>
                <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Blog posts</h2>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center rounded-lg bg-primary px-5 py-3 text-sm font-bold uppercase tracking-widest text-white shadow-sm transition hover:bg-opacity-90">
                + New Post
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50">
                        <tr class="text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Published</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                        @forelse ($posts as $post)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-zinc-900">{{ $post->title }}</p>
                                    <p class="text-xs text-zinc-500">/blog/{{ $post->slug }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $post->category_slug ?: '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-zinc-100 text-zinc-600' }}">{{ ucfirst($post->status) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-zinc-500">{{ optional($post->published_at)->format('d M Y') ?? '—' }}</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if ($post->status === 'published')
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" rel="noopener" class="mr-3 text-sm font-semibold text-zinc-600 hover:text-primary">View</a>
                                    @endif
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="mr-3 text-sm font-semibold text-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" class="inline" onsubmit="return confirm('Delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-10 text-center text-zinc-500">No posts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $posts->links() }}
    </div>
@endsection
