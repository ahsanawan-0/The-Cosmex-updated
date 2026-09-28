<?php

namespace App\Http\Controllers\Public;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Services\PostRenderer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(is_array($request->query('page')), 404);

        $posts = Post::published()->latest('published_at')->paginate(9);
        abort_if($posts->currentPage() > max(1, $posts->lastPage()), 404);

        return view('public.blog.index', compact('posts'));
    }

    public function show(string $slug, PostRenderer $renderer): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $rendered = $renderer->render($post);

        $category = $post->category;

        // Other guides: same category first, then the newest.
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw('CASE WHEN category_slug = ? THEN 0 ELSE 1 END', [$post->category_slug])
            ->latest('published_at')
            ->take(3)
            ->get();

        $relatedProducts = collect();
        if ($category) {
            $ids = $category->children()->pluck('id')->push($category->id);
            $relatedProducts = Product::with('category')->active()
                ->whereIn('category_id', $ids)
                ->orderByDesc('price')
                ->take(4)
                ->get();
        }

        $url = route('blog.show', $post->slug);
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            '@id' => $url . '#article',
            'headline' => SeoHelper::clean($post->title),
            'description' => SeoHelper::description($post->seo_description ?: $post->excerpt),
            'image' => [$post->cover_url],
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => ['@type' => 'Organization', 'name' => $post->author, 'url' => route('about')],
            'publisher' => ['@id' => SeoHelper::organizationId()],
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url],
            'isPartOf' => ['@id' => url('/') . '/#website'],
            'inLanguage' => 'en',
            'articleSection' => $category?->name,
            'wordCount' => str_word_count(strip_tags($rendered['html'])),
        ];

        return view('public.blog.show', [
            'post' => $post,
            'html' => $rendered['html'],
            'toc' => $rendered['toc'],
            'category' => $category,
            'relatedPosts' => $relatedPosts,
            'relatedProducts' => $relatedProducts,
            'schema' => array_filter($schema, fn ($value) => $value !== null),
        ]);
    }
}
