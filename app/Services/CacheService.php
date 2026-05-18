<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    // Cache key constants

    public const HOMEPAGE_BESTSELLERS = 'hp_bestsellers';
    public const HOMEPAGE_CATEGORIES  = 'hp_categories';
    public const NAV_CATEGORIES       = 'nav_categories';
    public const SITEMAP              = 'sitemap_xml';

    // TTL constants (seconds)
    public const TTL_SHORT  = 300;   // 5 min
    public const TTL_MEDIUM = 600;   // 10 min
    public const TTL_LONG   = 3600;  // 1 hour

    /**
     * Clear all product-related caches.
     * Call after any product create/update/delete or toggle action.
     */
    public static function clearProductCaches(): void
    {

        Cache::forget(self::HOMEPAGE_BESTSELLERS);
        Cache::forget(self::HOMEPAGE_CATEGORIES);
        Cache::forget(self::NAV_CATEGORIES);
        Cache::forget(self::SITEMAP);
    }



    /**
     * Clear all category-related caches.
     */
    public static function clearCategoryCaches(): void
    {
        Cache::forget(self::HOMEPAGE_CATEGORIES);
        Cache::forget(self::NAV_CATEGORIES);
        Cache::forget(self::SITEMAP);
    }

    /**
     * Flush everything.
     */
    public static function clearAll(): void
    {
        Cache::flush();
    }
}
