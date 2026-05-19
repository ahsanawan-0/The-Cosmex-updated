<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\CacheService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for all generated URLs and assets on production
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Custom gold-themed pagination
        Paginator::defaultView('vendor.pagination.custom');

        // Share site config with all views
        View::share('siteName', config('site.name'));
        View::share('siteTagline', config('site.tagline'));

        // Share navigation categories with header (for mega menu / nav links)
        View::composer('components.header', function ($view) {
            $navCategories = Category::where('status', 'active')
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug']);

            $view->with('navCategories', $navCategories);
        });

        // Share categories with footer too
        View::composer('components.footer', function ($view) {
            $footerCategories = Category::where('status', 'active')
                ->orderBy('sort_order')
                ->take(6)
                ->get(['id', 'name', 'slug']);

            $view->with('footerCategories', $footerCategories);
        });
    }
}
