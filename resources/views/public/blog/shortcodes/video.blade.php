<figure class="not-prose mx-auto my-8 w-full max-w-[300px]">
    <div class="overflow-hidden rounded-2xl bg-zinc-900 shadow-card">
        <video class="aspect-[9/16] h-auto w-full object-cover"
            src="{{ asset('videos/' . $video['file'] . '.mp4') }}"
            poster="{{ asset('images/videos/' . $video['file'] . '.webp') }}"
            controls playsinline preload="none" width="464" height="832"
            aria-label="{{ $video['title'] }}: {{ $video['description'] }}"></video>
    </div>
    <figcaption class="mt-2 text-center text-xs text-text-secondary">{{ $video['title'] }} ({{ sprintf('0:%02d', $video['duration']) }})</figcaption>
</figure>
