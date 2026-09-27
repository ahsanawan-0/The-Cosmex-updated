{{-- Aesthetic Products Category Slider --}}
@php
    $aestheticProductCategories = [
        ['name' => 'Exosomes',                  'slug' => 'exosomes'],
        ['name' => 'Botox',                     'slug' => 'botox'],
        ['name' => 'Dermal Fillers',            'slug' => 'dermal-fillers'],
        ['name' => 'Numbing Creams',            'slug' => 'numbing-creams'],
        ['name' => 'Otesaly Meso Serum',        'slug' => 'otesaly-meso-serum'],
        ['name' => 'Skin Whitening Injections', 'slug' => 'skin-whitening-injections'],
        ['name' => 'Stayve BB Glow',            'slug' => 'stayve-bb-glow'],
        ['name' => 'Microneedling',             'slug' => 'microneedling'],
        ['name' => 'Injectables',               'slug' => 'injectables'],
        ['name' => 'Peels & Serums',            'slug' => 'peels-serums'],
        ['name' => 'Tools & Devices',           'slug' => 'tools-devices'],
    ];

    // Merge with actual DB categories where image exists
    $dbCategories = $aestheticCategories->keyBy('slug');
@endphp

<section class="py-16 lg:py-20 bg-zinc-50 overflow-hidden w-full">
    <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-primary mb-2">Browse By Type</p>
                <h2 class="text-2xl lg:text-3xl font-bold tracking-tight text-zinc-900 font-heading">Explore Aesthetic Products</h2>
                <p class="mt-2 text-sm text-zinc-500">Premium injectables, serums and devices for aesthetic clinics</p>
            </div>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:text-primary/80 transition-colors whitespace-nowrap group">
                View All Products
                <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>

        {{-- Circular Category Slider --}}
        <div class="relative">
            {{-- Scroll Container --}}
            <div id="aesth-slider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory pb-3 aesth-scroll">
                @foreach($aestheticProductCategories as $cat)
                    @php
                        $dbCat = $dbCategories->get($cat['slug']);
                    @endphp
                    @continue(! $dbCat)
                    @php
                        $imageUrl = $dbCat->image_url;
                        $linkUrl = route('category.show', $dbCat->slug);
                    @endphp
                    <a href="{{ $linkUrl }}"
                       class="group flex-none w-[140px] sm:w-[160px] lg:w-[180px] snap-start text-center">
                        <div class="relative aspect-square overflow-hidden rounded-full bg-zinc-100 ring-1 ring-zinc-200/70 shadow-sm transition-all duration-300 group-hover:ring-2 group-hover:ring-primary/40 group-hover:shadow-lg group-hover:shadow-primary/10">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $cat['name'] }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            >
                        </div>

                        <p class="mt-4 px-1 text-[13px] font-semibold leading-snug text-zinc-800 transition-colors group-hover:text-primary">{{ $cat['name'] }}</p>
                    </a>
                @endforeach
            </div>

            {{-- Prev/Next Arrows (desktop) --}}
            <button onclick="document.getElementById('aesth-slider').scrollBy({left:-196,behavior:'smooth'})"
                    class="hidden lg:flex absolute -left-5 top-[38%] -translate-y-1/2 h-10 w-10 items-center justify-center rounded-full bg-white border border-zinc-200 shadow-md text-zinc-700 hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 z-10">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <button onclick="document.getElementById('aesth-slider').scrollBy({left:196,behavior:'smooth'})"
                    class="hidden lg:flex absolute -right-5 top-[38%] -translate-y-1/2 h-10 w-10 items-center justify-center rounded-full bg-white border border-zinc-200 shadow-md text-zinc-700 hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 z-10">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>
    </div>
</section>

<style>
.aesth-scroll { scrollbar-width: none; -ms-overflow-style: none; }
.aesth-scroll::-webkit-scrollbar { display: none; }
</style>
