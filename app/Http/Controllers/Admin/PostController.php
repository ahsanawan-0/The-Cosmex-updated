<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest('updated_at')->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'post' => null,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        Post::create($this->payload($request));

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function edit(int $id): View
    {
        return view('admin.posts.edit', [
            'post' => Post::findOrFail($id),
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function update(StorePostRequest $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->update($this->payload($request, $post));

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        if ($post->cover_image && ! Str::startsWith($post->cover_image, '/')) {
            ImageHelper::delete($post->cover_image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    private function payload(StorePostRequest $request, ?Post $post = null): array
    {
        $data = $request->safe()->except(['cover']);
        $data['slug'] = $this->uniqueSlug($request->input('slug') ?: $data['title'], $post?->id);

        if ($request->hasFile('cover')) {
            if ($post?->cover_image && ! Str::startsWith($post->cover_image, '/')) {
                ImageHelper::delete($post->cover_image);
            }
            $data['cover_image'] = ImageHelper::upload($request->file('cover'), 'blog');
        }

        // Publishing without a date means "now"; keep the original date on later edits.
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = $post?->published_at ?? now();
        }

        return $data;
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'post';
        $slug = $base;
        for ($i = 2; Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists(); $i++) {
            $slug = "{$base}-{$i}";
        }

        return $slug;
    }

    private function categoryOptions()
    {
        return Category::where('status', 'active')->orderBy('sort_order')->get(['name', 'slug']);
    }
}
