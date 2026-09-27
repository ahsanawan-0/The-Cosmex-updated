<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'status', 'sort_order', 'parent_id'];

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
