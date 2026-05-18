@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-center gap-1">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full text-zinc-300" aria-disabled="true">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-zinc-600 transition hover:bg-primary/10 hover:text-primary" rel="prev" aria-label="Previous page">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="inline-flex h-10 w-10 items-center justify-center text-sm text-zinc-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-semibold text-white" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-sm text-zinc-600 transition hover:bg-primary/10 hover:text-primary">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-zinc-600 transition hover:bg-primary/10 hover:text-primary" rel="next" aria-label="Next page">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full text-zinc-300" aria-disabled="true">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </nav>
@endif
