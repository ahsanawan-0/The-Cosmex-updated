{{-- Machine videos: short vertical clips, loaded only when they play --}}
@php
    $videos = collect(config('site.videos', []))
        ->filter(fn ($video) => is_file(public_path('videos/' . $video['file'] . '.mp4')))
        ->values();

    $videoSchema = [
        '@context' => 'https://schema.org',
        '@graph' => $videos->map(fn ($video) => [
            '@type' => 'VideoObject',
            '@id' => url('/') . '/#video-' . $video['file'],
            'name' => $video['title'],
            'description' => $video['description'],
            'thumbnailUrl' => [asset('images/videos/' . $video['file'] . '.webp')],
            'uploadDate' => $video['uploaded'],
            'duration' => 'PT' . $video['duration'] . 'S',
            'contentUrl' => asset('videos/' . $video['file'] . '.mp4'),
            'publisher' => ['@id' => \App\Helpers\SeoHelper::organizationId()],
        ])->all(),
    ];
@endphp

@if ($videos->isNotEmpty())
    <section class="bg-white py-10 lg:py-16" aria-labelledby="machine-videos-title">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-2 text-[11px] font-semibold uppercase text-primary">Watch</p>
                    <h2 id="machine-videos-title" class="font-heading text-2xl font-bold tracking-normal text-text-primary lg:text-3xl">See Our Machines Up Close</h2>
                    <p class="mt-2 text-sm text-text-secondary">Short clips of machines we supply to clinics across Pakistan. Tap a video to play it with sound.</p>
                </div>
                <a href="{{ route('category.show', 'aesthetic-machines') }}"
                   class="inline-flex min-h-12 items-center gap-2 rounded-2xl bg-bg-light px-4 text-sm font-semibold text-primary shadow-sm transition active:scale-95">
                    All Aesthetic Machines
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>

            <div class="-mx-4 flex snap-x snap-mandatory scroll-px-4 gap-4 overflow-x-auto px-4 pb-3 hide-scrollbar lg:mx-0 lg:grid lg:grid-cols-5 lg:overflow-visible lg:scroll-px-0 lg:px-0">
                @foreach ($videos as $video)
                    <figure class="w-[62vw] max-w-[240px] flex-none snap-start lg:w-auto lg:max-w-none" data-machine-video>
                        <div class="relative aspect-[9/16] overflow-hidden rounded-2xl bg-zinc-900 shadow-card">
                            <video
                                class="h-full w-full object-cover"
                                src="{{ asset('videos/' . $video['file'] . '.mp4') }}"
                                poster="{{ asset('images/videos/' . $video['file'] . '.webp') }}"
                                preload="none"
                                muted
                                loop
                                playsinline
                                width="464"
                                height="832"
                                aria-label="{{ $video['title'] }}: {{ $video['description'] }}"
                            ></video>
                            <button type="button" data-video-toggle
                                class="absolute inset-0 flex items-end justify-between bg-gradient-to-t from-black/60 via-black/0 to-black/0 p-3 text-left text-white transition"
                                aria-label="Play {{ $video['title'] }} with sound">
                                <span class="rounded-full bg-black/40 px-2 py-0.5 text-[11px] font-semibold tabular-nums text-white">{{ sprintf('0:%02d', $video['duration']) }}</span>
                                <span data-video-icon class="flex h-11 w-11 items-center justify-center rounded-full bg-white/90 text-primary shadow-md">
                                    <i class="fa-solid fa-volume-high text-sm" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                        <figcaption class="mt-3 px-1">
                            <h3 class="text-sm font-semibold leading-snug text-text-primary">{{ $video['title'] }}</h3>
                            <a href="{{ route('category.show', $video['category']) }}" class="mt-1 inline-flex items-center gap-1 text-xs font-semibold text-primary hover:underline">
                                {{ $video['link_label'] }}
                                <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                            </a>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    <script type="application/ld+json">{!! \App\Helpers\SeoHelper::json($videoSchema) !!}</script>

    <script>
        (function () {
            var cards = Array.prototype.slice.call(document.querySelectorAll('[data-machine-video]'));
            if (!cards.length) return;

            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var saveData = navigator.connection && navigator.connection.saveData;
            var autoPreview = !reduceMotion && !saveData && 'IntersectionObserver' in window;

            function videoOf(card) { return card.querySelector('video'); }

            function setIcon(card, playingWithSound) {
                var icon = card.querySelector('[data-video-icon] i');
                if (icon) icon.className = 'fa-solid ' + (playingWithSound ? 'fa-pause' : 'fa-volume-high') + ' text-sm';
            }

            function stopOthers(active) {
                cards.forEach(function (card) {
                    if (card === active) return;
                    var video = videoOf(card);
                    if (!video.muted) { video.muted = true; video.pause(); setIcon(card, false); }
                });
            }

            cards.forEach(function (card) {
                var video = videoOf(card);
                card.querySelector('[data-video-toggle]').addEventListener('click', function () {
                    if (video.muted || video.paused) {
                        stopOthers(card);
                        video.muted = false;
                        video.currentTime = video.paused ? video.currentTime : 0;
                        var playing = video.play();
                        if (playing && playing.catch) playing.catch(function () {});
                        setIcon(card, true);
                    } else {
                        video.pause();
                        video.muted = true;
                        setIcon(card, false);
                    }
                });
            });

            // Muted, looping previews while a clip is on screen; nothing loads until then.
            if (autoPreview) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        var video = videoOf(entry.target);
                        if (entry.isIntersecting && entry.intersectionRatio >= 0.6) {
                            if (video.paused) { var p = video.play(); if (p && p.catch) p.catch(function () {}); }
                        } else if (!entry.isIntersecting && !video.paused) {
                            video.pause();
                            if (!video.muted) { video.muted = true; setIcon(entry.target, false); }
                        }
                    });
                }, { threshold: [0, 0.6] });
                cards.forEach(function (card) { observer.observe(card); });
            }
        })();
    </script>
@endif
