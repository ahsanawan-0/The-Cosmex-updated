@php
    $siteName = 'The Cosmex';
    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number', '923001234567');
    $contactPhone = \App\Models\Setting::get('contact_phone', '+92 300 1234567');
    $contactEmail = \App\Models\Setting::get('contact_email', 'info@thecosmex.com');
    $whatsAppLink = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsAppNumber);
    // Dynamically load ALL active top-level categories — controlled entirely by the admin portal
    $navCategories = \App\Models\Category::whereNull('parent_id')
        ->where('status', 'active')
        ->with([
            'children' => function ($query) {
                $query->where('status', 'active')->orderBy('sort_order');
            },
            'products' => function ($query) {
                $query->where('status', 'active')->oldest();
            },
        ])
        ->orderBy('sort_order')
        ->get();
    $isActive = fn (...$patterns) => request()->routeIs(...$patterns);

    // Determine which top-level nav category is "active" for the current page
    $activeNavCategoryId = null;
    if (request()->routeIs('products.show')) {
        $slug = request()->route('slug') ?? request()->route('product');
        $currentProduct = \App\Models\Product::with('category.parent')
            ->where('slug', $slug)->first();
        if ($currentProduct && $currentProduct->category) {
            // Walk up to the root category
            $cat = $currentProduct->category;
            while ($cat->parent_id !== null && $cat->parent) {
                $cat = $cat->parent;
            }
            $activeNavCategoryId = $cat->id;
        }
    } elseif (request()->routeIs('category.show')) {
        $slug = request()->route('slug') ?? request()->route('category');
        $cat = \App\Models\Category::with('parent')->where('slug', $slug)->first();
        if ($cat) {
            while ($cat->parent_id !== null && $cat->parent) {
                $cat = $cat->parent;
            }
            $activeNavCategoryId = $cat->id;
        }
    }
@endphp

<div class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl">
    <div class="bg-primary px-4 py-2 text-center text-[11px] font-bold uppercase tracking-wide text-white sm:text-xs">
        Note: Cosmex imports directly and sells only to dermatologists and aestheticians.
    </div>

    <div class="hidden border-b border-border bg-white lg:block">
        <div class="mx-auto flex h-10 max-w-[1180px] items-center justify-end gap-7 text-xs font-medium text-text-secondary">
            <a href="tel:{{ $contactPhone }}" class="inline-flex items-center gap-2 transition hover:text-primary">
                <i class="fa-solid fa-phone text-primary"></i>
                {{ $contactPhone }}
            </a>
            <a href="mailto:{{ $contactEmail }}" class="inline-flex items-center gap-2 transition hover:text-primary">
                <i class="fa-regular fa-envelope text-primary"></i>
                {{ $contactEmail }}
            </a>
        </div>
    </div>

    <header class="border-b border-border bg-white">
        <div class="mx-auto flex h-[78px] max-w-[1180px] items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ $siteName }} Home">
                <img src="{{ asset('images/COSMEX_LOGO.png') }}" alt="{{ $siteName }} Logo" class="h-[60px] w-auto object-contain">
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('products.index') }}" class="rounded-full px-4 py-3 text-xs font-bold uppercase text-text-primary transition hover:bg-bg-light hover:text-accent">All Products</a>

                @foreach ($navCategories as $navCategory)
                    @php
                        $navItems = $navCategory->children->isNotEmpty() ? $navCategory->children : $navCategory->products;
                        $isProductMenu = $navCategory->children->isEmpty();
                        // Dynamic promo label: use first word of category name, uppercased
                        $promoLabel = strtoupper(explode(' ', $navCategory->name)[0]);
                        // Dynamic promo image: check for known images, fall back to a default
                        $knownImages = [
                            'Laser Machines'     => 'Laser Machines.png',
                            'HydraFacial'        => 'HydraFacial.png',
                            'Aesthetic Products' => 'Aesthetic Equipment.png',
                            'Other Equipment'    => 'Aesthetic Equipment.png',
                        ];
                        $promoImage = $knownImages[$navCategory->name] ?? 'Aesthetic Equipment.png';
                        $isNavActive = $activeNavCategoryId === $navCategory->id;
                    @endphp
                    <div class="group relative">
                        <a href="{{ route('category.show', $navCategory->slug) }}" class="inline-flex items-center gap-2 rounded-full px-4 py-3 text-xs font-bold uppercase transition {{ $isNavActive ? 'bg-bg-light text-accent' : 'text-text-primary hover:bg-bg-light hover:text-accent' }}">
                            {{ $navCategory->name }}
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </a>

                        <div class="invisible absolute left-1/2 top-full w-[860px] max-w-[90vw] -translate-x-1/2 translate-y-3 opacity-0 transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                            <div class="overflow-hidden rounded-[24px] border border-border bg-white shadow-hover">
                                <div class="grid grid-cols-[1fr_260px]">
                                    <div class="grid max-h-[420px] grid-cols-2 gap-x-4 gap-y-1 overflow-y-auto p-5 hide-scrollbar">
                                        @forelse ($navItems as $item)
                                            <a href="{{ $isProductMenu ? route('products.show', $item->slug) : route('category.show', $item->slug) }}"
                                                class="flex min-h-11 items-center gap-3 rounded-2xl px-3 py-2 text-sm font-semibold text-text-secondary transition hover:bg-bg-light hover:text-primary">
                                                <span class="h-2 w-2 shrink-0 rounded-full bg-accent"></span>
                                                <span class="line-clamp-2">{{ $item->name }}</span>
                                            </a>
                                        @empty
                                            <a href="{{ route('category.show', $navCategory->slug) }}"
                                                class="flex min-h-11 items-center gap-3 rounded-2xl px-3 py-2 text-sm font-semibold text-text-secondary transition hover:bg-bg-light hover:text-primary">
                                                <span class="h-2 w-2 shrink-0 rounded-full bg-accent"></span>
                                                <span>{{ $navCategory->name }}</span>
                                            </a>
                                        @endforelse
                                    </div>
                                    <div class="relative min-h-[260px] overflow-hidden bg-bg-light p-5 flex flex-col justify-between">
                                        <div class="relative z-10 flex items-center justify-between">
                                            <div>
                                                <p class="font-heading text-lg font-bold text-text-primary">{{ $navCategory->name }}</p>
                                                <a href="{{ route('category.show', $navCategory->slug) }}" class="mt-2 inline-flex min-h-9 items-center justify-center gap-2 rounded-full bg-primary px-4 text-[11px] font-bold uppercase text-white transition hover:bg-primary-dark shadow-md shadow-primary/20">
                                                    View All
                                                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="relative mt-4 flex justify-center items-end h-[160px]">
                                            <img src="{{ asset('images/' . $promoImage) }}" alt="{{ $navCategory->name }}" class="max-h-[150px] w-auto object-cover rounded-2xl overflow-hidden shadow-md transition-transform duration-500 group-hover:scale-105">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <button type="button" data-search-open aria-label="Search" class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-bg-light text-text-primary transition active:scale-95 hover:text-primary">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>
            </div>
        </div>
    </header>
</div>

<nav class="fixed inset-x-0 bottom-0 z-50 border-t border-border/80 bg-white/95 px-3 pb-[max(10px,env(safe-area-inset-bottom))] pt-2 shadow-[0_-14px_30px_rgba(7,95,184,0.10)] backdrop-blur-xl lg:hidden" aria-label="Mobile navigation">
    <div class="mx-auto grid max-w-[430px] grid-cols-5 gap-1">
        <a href="{{ route('home') }}" class="mobile-tab {{ $isActive('home') ? 'is-active' : '' }}"><i class="fa-solid fa-house"></i><span>Home</span></a>
        <a href="{{ route('products.index') }}" class="mobile-tab {{ $isActive('products.*') ? 'is-active' : '' }}"><i class="fa-solid fa-layer-group"></i><span>Products</span></a>
        <button type="button" data-search-open class="mobile-tab"><i class="fa-solid fa-magnifying-glass"></i><span>Search</span></button>
        <button type="button" data-mobile-categories-open class="mobile-tab {{ $isActive('category.show') ? 'is-active' : '' }}"><i class="fa-solid fa-grip"></i><span>Categories</span></button>
        <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="mobile-tab"><i class="fa-brands fa-whatsapp"></i><span>Quote</span></a>
    </div>
</nav>

<div id="mobile-categories-overlay" class="fixed inset-0 z-[68] hidden bg-text-primary/25 backdrop-blur-sm lg:hidden"></div>
<section id="mobile-categories-sheet" class="fixed inset-x-3 bottom-[86px] z-[69] hidden rounded-[28px] border border-border bg-white p-4 shadow-hover lg:hidden">
    <div class="mb-3 flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase text-accent">Product Menu</p>
            <h2 class="font-heading text-lg font-bold text-text-primary">Browse Categories</h2>
        </div>
        <button type="button" data-mobile-categories-close class="flex h-11 w-11 items-center justify-center rounded-2xl bg-bg-light text-text-secondary" aria-label="Close categories">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="max-h-[58vh] space-y-2 overflow-y-auto hide-scrollbar">
        <a href="{{ route('products.index') }}" class="flex min-h-12 items-center justify-between rounded-2xl bg-bg-light px-4 text-sm font-bold text-text-primary">
            All Products
            <i class="fa-solid fa-arrow-right text-xs text-primary"></i>
        </a>
        @foreach ($navCategories as $navCategory)
            <a href="{{ route('category.show', $navCategory->slug) }}" class="flex min-h-12 items-center justify-between rounded-2xl bg-bg-light px-4 text-sm font-bold text-text-primary">
                {{ $navCategory->name }}
                <i class="fa-solid fa-arrow-right text-xs text-primary"></i>
            </a>
        @endforeach
    </div>
</section>

<div id="search-overlay" class="fixed inset-0 z-[70] hidden bg-text-primary/25 backdrop-blur-sm"></div>
<section id="search-sheet" class="fixed inset-x-0 top-0 z-[80] -translate-y-full rounded-b-[28px] bg-white px-4 pb-5 pt-[max(18px,env(safe-area-inset-top))] shadow-2xl shadow-text-primary/15 transition-transform duration-300">
    <div class="mx-auto max-w-[680px]">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase text-accent">Find Products</p>
                <h2 class="font-heading text-xl font-semibold text-text-primary">Search The Cosmex</h2>
            </div>
            <button type="button" data-search-close aria-label="Close search" class="flex h-12 w-12 items-center justify-center rounded-2xl bg-bg-light text-text-secondary transition active:scale-95 hover:text-text-primary">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('search') }}" method="GET" class="flex min-h-12 items-center gap-3 rounded-2xl bg-bg-light px-4 ring-1 ring-border/80 transition focus-within:ring-primary/40">
            <i class="fa-solid fa-magnifying-glass text-sm text-primary"></i>
            <input id="global-search-input" type="search" name="q" value="{{ request('q') }}" placeholder="Search products and machines" class="h-12 flex-1 border-0 bg-transparent text-base text-text-primary outline-none placeholder:text-text-secondary">
        </form>

        <div class="mt-4 flex gap-2 overflow-x-auto hide-scrollbar">
            @foreach(['Aesthetic Machines', 'Fillers', 'Exosomes', 'HydraFacial', 'Laser', 'Skincare'] as $term)
                <a href="{{ route('search', ['q' => $term]) }}" class="shrink-0 rounded-full bg-bg-light px-4 py-2 text-sm font-semibold text-text-secondary transition hover:bg-primary hover:text-white">
                    {{ $term }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<script>
    (() => {
        const overlay = document.getElementById('search-overlay');
        const sheet = document.getElementById('search-sheet');
        const input = document.getElementById('global-search-input');
        const openers = document.querySelectorAll('[data-search-open]');
        const closers = document.querySelectorAll('[data-search-close]');
        const categoryOverlay = document.getElementById('mobile-categories-overlay');
        const categorySheet = document.getElementById('mobile-categories-sheet');
        const categoryOpeners = document.querySelectorAll('[data-mobile-categories-open]');
        const categoryClosers = document.querySelectorAll('[data-mobile-categories-close]');

        const openSearch = () => {
            overlay?.classList.remove('hidden');
            sheet?.classList.remove('-translate-y-full');
            window.setTimeout(() => input?.focus(), 220);
        };

        const closeSearch = () => {
            sheet?.classList.add('-translate-y-full');
            window.setTimeout(() => overlay?.classList.add('hidden'), 220);
        };

        const openCategories = () => {
            categoryOverlay?.classList.remove('hidden');
            categorySheet?.classList.remove('hidden');
        };

        const closeCategories = () => {
            categoryOverlay?.classList.add('hidden');
            categorySheet?.classList.add('hidden');
        };

        openers.forEach((button) => button.addEventListener('click', openSearch));
        closers.forEach((button) => button.addEventListener('click', closeSearch));
        overlay?.addEventListener('click', closeSearch);
        categoryOpeners.forEach((button) => button.addEventListener('click', openCategories));
        categoryClosers.forEach((button) => button.addEventListener('click', closeCategories));
        categoryOverlay?.addEventListener('click', closeCategories);
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSearch();
                closeCategories();
            }
        });
    })();
</script>
