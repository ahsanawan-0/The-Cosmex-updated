<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeoHelper
{
    public static function generateTitle(?string $pageTitle, string $siteName = 'Cosmex Pvt Ltd'): string
    {
        $pageTitle = trim((string) $pageTitle);

        if ($pageTitle === '') {
            return $siteName;
        }

        return Str::contains($pageTitle, $siteName) ? $pageTitle : "{$pageTitle} | {$siteName}";
    }

    public static function generateDescription(?string $text, int $max = 160): string
    {
        $cleanText = preg_replace('/\s+/', ' ', strip_tags((string) $text)) ?? '';

        return Str::limit(trim($cleanText), $max, '...');
    }

    public static function generateKeywords(mixed $product): string
    {
        $name = trim((string) data_get($product, 'name'));
        $category = trim((string) data_get($product, 'category.name'));

        $keywords = array_filter([
            $name,
            $category,
            $name !== '' && $category !== '' ? "{$name} {$category}" : null,
            'Cosmex Pvt Ltd',
            'aesthetic machines',
            'aesthetic products Pakistan',
        ]);

        return implode(', ', array_values(array_unique($keywords)));
    }

    public static function generateCanonicalUrl(string $route, array $params = []): string
    {
        if (filter_var($route, FILTER_VALIDATE_URL)) {
            return $route;
        }

        if (Str::startsWith($route, '/')) {
            return url($route);
        }

        return route($route, $params);
    }
}
