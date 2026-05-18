<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'price', 'sale_price', 'stock',
        'short_description', 'description', 'main_image', 'gallery_images',
        'status', 'seo_title', 'seo_description'
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAvgRatingAttribute()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->approved()->count();
    }

    public function getMainImageUrlAttribute()
    {
        $path = $this->main_image
            ? (str_contains($this->main_image, '/') ? $this->main_image : 'products/'.$this->main_image)
            : null;

        return ImageHelper::getUrl($path, '/images/placeholder-product.webp');
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    public function getSalePriceFormattedAttribute()
    {
        return $this->sale_price ? 'Rs. ' . number_format($this->sale_price, 2) : null;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->is_on_sale) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
