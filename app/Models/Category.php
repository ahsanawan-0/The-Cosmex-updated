<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use App\Helpers\SeoHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'status', 'sort_order', 'parent_id',
        'seo_title', 'seo_description', 'content',
    ];

    /** Per-request cache of category ids that contain active products. */
    protected static ?array $nonEmptyIds = null;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Ids of categories with at least one active product, counting a parent as
     * non-empty when one of its children is. Empty categories stay out of the
     * menus, footer and sitemap, and are served with noindex.
     */
    public static function nonEmptyIds(): array
    {
        if (static::$nonEmptyIds === null) {
            $direct = Product::active()
                ->whereNotNull('category_id')
                ->distinct()
                ->pluck('category_id')
                ->all();

            $parents = static::query()
                ->whereIn('id', $direct)
                ->whereNotNull('parent_id')
                ->pluck('parent_id')
                ->all();

            static::$nonEmptyIds = array_values(array_unique(array_merge($direct, $parents)));
        }

        return static::$nonEmptyIds;
    }

    public function scopeWithActiveProducts(Builder $query): Builder
    {
        return $query->whereIn('id', static::nonEmptyIds());
    }

    public function hasActiveProducts(): bool
    {
        return in_array($this->id, static::nonEmptyIds(), true);
    }

    /**
     * Title, description, intro and body copy for the category page. Admin
     * fields win; config/seo.php supplies defaults; placeholders are filled
     * from live product data so counts and prices never go stale.
     *
     * @param  array{count:int,min:?int,max:?int}  $stats
     */
    public function seoCopy(array $stats): array
    {
        $defaults = config('seo.categories.' . $this->slug, []);

        $replace = [
            '{count}' => (string) $stats['count'],
            '{min}' => number_format((int) ($stats['min'] ?? 0)),
            '{max}' => number_format((int) ($stats['max'] ?? 0)),
            '{name}' => $this->name,
        ];
        $fill = fn (?string $text) => $text === null ? null : strtr($text, $replace);

        $fallbackDescription = $stats['count'] > 0
            ? "Browse {count} {name} products for clinics in Pakistan, priced from PKR {min} to PKR {max}. Ask for wholesale rates on WhatsApp."
            : "{name} for clinics and aesthetic professionals in Pakistan.";

        return [
            'title' => $fill($this->seo_title ?: ($defaults['title'] ?? "{name} for Clinics in Pakistan")),
            'description' => SeoHelper::description($fill($this->seo_description ?: ($defaults['description'] ?? $fallbackDescription))),
            'lead' => $fill($this->description ?: ($defaults['lead'] ?? null)),
            'content' => $fill($this->content ?: ($defaults['content'] ?? null)),
        ];
    }

    public function getImageUrlAttribute()
    {
        $path = $this->image
            ? (str_contains($this->image, '/') ? $this->image : 'categories/'.$this->image)
            : null;

        // Categories often have no upload on a given environment, or point at one
        // that never got deployed. Fall back to the bundled image named after the
        // slug, so dropping public/images/categories/<slug>.webp is enough.
        $bundled = $this->slug ? 'categories/'.$this->slug.'.webp' : null;

        return ImageHelper::resolve($path)
            ?? ImageHelper::resolve($bundled)
            ?? url('images/placeholder-category.webp');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
