@props(['post', 'headingLevel' => 'h2'])

<article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-card transition duration-300 hover:-translate-y-1 hover:shadow-hover">
    <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-[1200/630] overflow-hidden bg-bg-light" tabindex="-1" aria-hidden="true">
        <img src="{{ $post->cover_url }}" alt="" width="1200" height="630" loading="lazy" decoding="async"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
    </a>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-accent">
            {{ optional($post->category)->name ?? 'Guide' }} · {{ $post->reading_minutes }} min read
        </p>
        <{{ $headingLevel }} class="mt-2 font-heading text-lg font-bold leading-snug text-text-primary">
            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary">{{ $post->title }}</a>
        </{{ $headingLevel }}>
        @if ($post->excerpt)
            <p class="mt-2 line-clamp-3 text-sm leading-6 text-text-secondary">{{ $post->excerpt }}</p>
        @endif
        <a href="{{ route('blog.show', $post->slug) }}" class="mt-auto inline-flex items-center gap-1 pt-4 text-sm font-semibold text-primary" aria-label="Read: {{ $post->title }}">
            Read guide <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
        </a>
    </div>
</article>
