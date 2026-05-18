<div class="relative z-20 mb-8 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-[1180px] rounded-2xl bg-white p-4 shadow-card sm:p-6 lg:p-8">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            
            @php
                $heroFeatures = [
                    [
                        'icon' => 'fa-solid fa-users', 
                        'title' => 'Who We Are', 
                        'text' => 'Cosmex imports professional aesthetic products and machines.'
                    ],
                    [
                        'icon' => 'fa-regular fa-circle-check', 
                        'title' => 'Our Mission', 
                        'text' => 'Deliver premium quality products with trust and professionalism.'
                    ],
                    [
                        'icon' => 'fa-solid fa-eye', 
                        'title' => 'Our Vision', 
                        'text' => 'To be Pakistan\'s most trusted aesthetic solutions partner.'
                    ],
                    [
                        'icon' => 'fa-solid fa-shield-halved', 
                        'title' => 'Our Promise', 
                        'text' => 'Quality, authenticity and the best service for our clients.'
                    ],
                ];
            @endphp
            
            @foreach ($heroFeatures as $feature)
                <div class="flex min-h-24 items-start gap-4 rounded-2xl bg-bg-light p-4">
                    <div class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-primary shadow-sm">
                        <i class="{{ $feature['icon'] }} text-lg"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 text-sm font-semibold text-text-primary">{{ $feature['title'] }}</h3>
                        <p class="text-[13px] font-medium leading-relaxed text-text-secondary">{{ $feature['text'] }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
