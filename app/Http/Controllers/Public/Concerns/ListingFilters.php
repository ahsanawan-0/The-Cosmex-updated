<?php

namespace App\Http\Controllers\Public\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared, validated query-string handling for product listings.
 *
 * Unexpected input (arrays, unknown sort values, non-numeric prices) is
 * rejected or ignored instead of reaching the query builder and the views,
 * which previously returned HTTP 500 for URLs such as ?sort[]=x.
 */
trait ListingFilters
{
    private array $sortOptions = ['newest', 'price_low', 'price_high'];

    private array $filterKeys = ['category', 'q', 'min_price', 'max_price', 'on_sale', 'in_stock', 'sort'];

    protected function listingFilters(Request $request): array
    {
        foreach ([...$this->filterKeys, 'page'] as $key) {
            abort_if(is_array($request->query($key)), 404);
        }

        $number = fn (string $key) => is_numeric($request->query($key)) ? max(0, (float) $request->query($key)) : null;
        $sort = $request->query('sort');

        return [
            'category' => filled($request->query('category')) ? (string) $request->query('category') : null,
            'q' => filled($request->query('q')) ? strip_tags(mb_substr(trim((string) $request->query('q')), 0, 100)) : null,
            'min_price' => $number('min_price'),
            'max_price' => $number('max_price'),
            'on_sale' => $request->boolean('on_sale'),
            'in_stock' => $request->boolean('in_stock'),
            'sort' => in_array($sort, $this->sortOptions, true) ? $sort : 'newest',
        ];
    }

    /** Any filter, search or sort parameter makes a URL a non-indexable variant. */
    protected function isFilteredListing(Request $request): bool
    {
        return collect($this->filterKeys)->contains(fn (string $key) => filled($request->query($key)));
    }

    protected function applyListingFilters(Builder $query, array $filters): Builder
    {
        $effectivePrice = 'CASE WHEN sale_price IS NOT NULL AND sale_price < price THEN sale_price ELSE price END';

        if ($filters['min_price'] !== null) {
            $query->whereRaw("{$effectivePrice} >= ?", [$filters['min_price']]);
        }
        if ($filters['max_price'] !== null) {
            $query->whereRaw("{$effectivePrice} <= ?", [$filters['max_price']]);
        }
        if ($filters['on_sale']) {
            $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price');
        }
        if ($filters['in_stock']) {
            $query->where('stock', '>', 0);
        }

        match ($filters['sort']) {
            'price_low' => $query->orderByRaw("{$effectivePrice} ASC"),
            'price_high' => $query->orderByRaw("{$effectivePrice} DESC"),
            default => $query->latest(),
        };

        return $query;
    }

    /** Count and price range of the active products in the given categories. */
    protected function listingStats(Builder $query): array
    {
        $effectivePrice = 'CASE WHEN sale_price IS NOT NULL AND sale_price < price THEN sale_price ELSE price END';
        $row = (clone $query)->reorder()->toBase()
            ->selectRaw("COUNT(*) as total, MIN({$effectivePrice}) as min_price, MAX({$effectivePrice}) as max_price")
            ->first();

        return [
            'count' => (int) ($row->total ?? 0),
            'min' => $row->min_price !== null ? (int) round($row->min_price) : null,
            'max' => $row->max_price !== null ? (int) round($row->max_price) : null,
        ];
    }
}
