<div class="relative z-20 mb-8">
    <div class="mx-auto rounded-2xl sm:rounded-full bg-primary py-5 px-6 sm:px-8 shadow-card" style="background: #1558b0; max-width: 1180px;">

        @php
            $heroFeatures = [
                [
                    'icon'  => 'fa-solid fa-users',
                    'title' => 'Who We Are',
                    'text'  => 'Cosmex imports professional aesthetic products and machines.'
                ],
                [
                    'icon'  => 'fa-solid fa-bullseye',
                    'title' => 'Our Mission',
                    'text'  => 'Deliver premium quality products with trust and professionalism.'
                ],
                [
                    'icon'  => 'fa-solid fa-eye',
                    'title' => 'Our Vision',
                    'text'  => 'To be Pakistan\'s most trusted aesthetic solutions partner.'
                ],
                [
                    'icon'  => 'fa-solid fa-shield-halved',
                    'title' => 'Our Promise',
                    'text'  => 'Quality, authenticity and the best service for our clients.'
                ],
            ];
        @endphp

        <div class="flex flex-col sm:flex-row items-stretch">
            @foreach ($heroFeatures as $index => $feature)
                {{-- Vertical divider before every item except the first --}}
                @if ($index > 0)
                    <div class="hidden sm:block w-px bg-white/25 my-2 mx-6 shrink-0"></div>
                @endif

                <div class="flex flex-1 items-center gap-4 py-2 sm:py-0">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white" style="min-width:48px;">
                        <i class="{{ $feature['icon'] }} text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white leading-snug">{{ $feature['title'] }}</h3>
                        <p class="text-xs leading-relaxed text-white mt-0.5" style="max-width: 200px;">{{ $feature['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
