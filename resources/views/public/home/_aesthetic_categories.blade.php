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

        {{-- Square Category Slider --}}
        <div class="relative">
            {{-- Scroll Container --}}
            <div id="aesth-slider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory pb-3 aesth-scroll">
                @foreach($aestheticProductCategories as $cat)
                    @php
                        $dbCat = $dbCategories->get($cat['slug']);
                        $imageUrl = $dbCat ? $dbCat->image_url : asset('images/placeholder-category.webp');
                        $linkUrl = $dbCat ? route('category.show', $dbCat->slug) : route('products.index');
                    @endphp
                    <a href="{{ $linkUrl }}"
                       class="group flex-none w-[160px] sm:w-[180px] lg:w-[200px] snap-start">
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-zinc-100 border border-zinc-200/60 group-hover:border-primary/30 transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-primary/10">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $cat['name'] }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                loading="lazy"
                            >
                            {{-- Dark Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/80 via-zinc-900/20 to-transparent"></div>

                            {{-- Category Name --}}
                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                <p class="text-white text-[12px] font-semibold leading-tight text-center">{{ $cat['name'] }}</p>
                            </div>

                            {{-- Hover Arrow --}}
                            <div class="absolute top-3 right-3 h-7 w-7 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <i class="fa-solid fa-arrow-right text-white text-[10px]"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Prev/Next Arrows (desktop) --}}
            <button onclick="document.getElementById('aesth-slider').scrollBy({left:-220,behavior:'smooth'})"
                    class="hidden lg:flex absolute -left-5 top-1/2 -translate-y-1/2 h-10 w-10 items-center justify-center rounded-full bg-white border border-zinc-200 shadow-md text-zinc-700 hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 z-10">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <button onclick="document.getElementById('aesth-slider').scrollBy({left:220,behavior:'smooth'})"
                    class="hidden lg:flex absolute -right-5 top-1/2 -translate-y-1/2 h-10 w-10 items-center justify-center rounded-full bg-white border border-zinc-200 shadow-md text-zinc-700 hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 z-10">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>
    </div>
</section>

<style>
.aesth-scroll { scrollbar-width: none; -ms-overflow-style: none; }
.aesth-scroll::-webkit-scrollbar { display: none; }
</style>
