@props(['items' => []])

@php
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(fn ($item, $i) => array_filter([
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => \App\Helpers\SeoHelper::clean($item['label']),
            'item' => $item['url'] ?? null,
        ]))->all(),
    ];
@endphp

<nav aria-label="Breadcrumb" class="text-sm">
    <ol class="flex flex-wrap items-center gap-1.5 text-zinc-500">
        @foreach ($items as $i => $item)
            <li>
                @if (isset($item['url']) && ! $loop->last)
                    <a href="{{ $item['url'] }}" class="transition hover:text-primary">{{ $item['label'] }}</a>
                @else
                    <span class="font-medium text-zinc-900" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
            @unless ($loop->last)
                <li aria-hidden="true" class="text-zinc-300">/</li>
            @endunless
        @endforeach
    </ol>
</nav>
<script type="application/ld+json">{!! \App\Helpers\SeoHelper::json($breadcrumbSchema) !!}</script>
