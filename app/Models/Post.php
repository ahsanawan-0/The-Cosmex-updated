<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'cover_image', 'seo_title', 'seo_description',
        'category_slug', 'author_name', 'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /** Guides related to a category, its parent or its children. */
    public function scopeForCategory(Builder $query, Category $category): Builder
    {
        $slugs = collect([$category->slug])
            ->merge($category->children()->pluck('slug'))
            ->when($category->parent_id, fn ($c) => $c->push(optional($category->parent)->slug))
            ->filter()
            ->unique()
            ->all();

        return $query->whereIn('category_slug', $slugs);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_slug', 'slug');
    }

    public function getUrlAttribute(): string
    {
        return route('blog.show', $this->slug);
    }

    public function getCoverUrlAttribute(): string
    {
        return ImageHelper::getUrl($this->cover_image, config('site.og_image'));
    }

    public function getReadingMinutesAttribute(): int
    {
        $words = str_word_count(strip_tags(preg_replace('/\[\[[^\]]*\]\]/', '', (string) $this->body)));

        return max(1, (int) ceil($words / 200));
    }

    public function getAuthorAttribute(): string
    {
        return $this->author_name ?: config('site.name') . ' Team';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
