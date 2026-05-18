@props(['items' => []])

<nav aria-label="Breadcrumb" class="text-sm">
    <ol class="flex flex-wrap items-center gap-1.5 text-zinc-500" itemscope itemtype="https://schema.org/BreadcrumbList">
        @foreach ($items as $i => $item)
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                @if (isset($item['url']) && ! $loop->last)
                    <a href="{{ $item['url'] }}" itemprop="item" class="transition hover:text-primary">
                        <span itemprop="name">{{ $item['label'] }}</span>
                    </a>
                @else
                    <span itemprop="name" class="font-medium text-zinc-900">{{ $item['label'] }}</span>
                @endif
                <meta itemprop="position" content="{{ $i + 1 }}">
            </li>
            @unless ($loop->last)
                <li aria-hidden="true" class="text-zinc-300">/</li>
            @endunless
        @endforeach
    </ol>
</nav>
