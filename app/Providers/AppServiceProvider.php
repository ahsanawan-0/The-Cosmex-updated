<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        // In production every generated URL (links, canonicals, sitemap, schema)
        // uses APP_URL, never the host or /public base the request came in on.
        if (config('app.env') === 'production') {
            URL::forceRootUrl(rtrim((string) config('app.url'), '/'));
            URL::forceScheme('https');
        }

        // Custom gold-themed pagination
        Paginator::defaultView('vendor.pagination.custom');

        // Share site config with all views
        View::share('siteName', config('site.name'));
        View::share('siteTagline', config('site.tagline'));

        // Footer links come from the database so renamed or empty categories
        // can never produce a broken or thin link on every page.
        View::composer('components.footer', function ($view) {
            $categories = Category::where('status', 'active')
                ->withActiveProducts()
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug', 'parent_id']);

            $view->with('footerTopCategories', $categories->whereNull('parent_id')->values());
            $view->with('footerPopularCategories', $categories->whereNotNull('parent_id')->take(6)->values());
        });
    }
}
