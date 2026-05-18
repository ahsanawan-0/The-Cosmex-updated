<section class="bg-bg-light py-10 lg:py-16">
    <div class="mx-auto mb-7 max-w-[1180px] px-4 sm:px-6 lg:px-8">
        <p class="mb-2 text-center text-[11px] font-bold uppercase text-accent">Our Categories</p>
        <h2 class="mx-auto max-w-2xl text-center font-heading text-2xl font-bold tracking-normal text-text-primary lg:text-3xl">Explore Our Range of Advanced Aesthetic Solutions</h2>
        <p class="mt-2 max-w-xl text-sm text-text-secondary">High quality aesthetic products and advanced machines for your clinic.</p>
    </div>

    <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

            {{-- Aesthetic Products Card --}}
            <div
                class="group relative flex overflow-hidden rounded-2xl bg-white shadow-card transition duration-300 hover:shadow-hover">
                <div class="z-10 flex min-h-[230px] flex-1 flex-col items-start justify-center p-6 text-left lg:p-8">
                    <h3 class="mb-3 font-heading text-2xl font-bold text-text-primary">Aesthetic Products</h3>
                    <p class="mb-7 max-w-[250px] text-sm leading-relaxed text-text-secondary">Wide range of injectables,
                        skincare products and consumables.</p>
                    <a href="{{ route('category.show', 'aesthetic-products') }}"
                        class="inline-flex min-h-12 items-center gap-3 rounded-2xl bg-primary px-5 text-sm font-semibold text-white transition active:scale-95">
                        Explore Products
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="relative min-h-[230px] flex-1 overflow-hidden">
                    <img src="{{ asset('images/aesthetic_products_promo.png') }}" alt="Aesthetic Products"
                        class="absolute inset-0 h-full w-full object-contain object-bottom p-3 transition-transform duration-700 group-hover:scale-105">
                </div>
            </div>

            {{-- Aesthetic Machines Card --}}
            <div
                class="group relative flex overflow-hidden rounded-2xl bg-white shadow-card transition duration-300 hover:shadow-hover">
                <div class="z-10 flex min-h-[230px] flex-1 flex-col items-start justify-center p-6 text-left lg:p-8">
                    <h3 class="mb-3 font-heading text-2xl font-bold text-text-primary">Aesthetic Machines</h3>
                    <p class="mb-7 max-w-[250px] text-sm leading-relaxed text-text-secondary">Advanced technology machines for
                        every aesthetic need.</p>
                    <a href="{{ route('category.show', 'laser-machines') }}"
                        class="inline-flex min-h-12 items-center gap-3 rounded-2xl bg-primary px-5 text-sm font-semibold text-white transition active:scale-95">
                        Explore Machines
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="relative min-h-[230px] flex-1 overflow-hidden">
                    <img src="{{ asset('images/aesthetic_machines_promo.png') }}" alt="Aesthetic Machines"
                        class="absolute inset-0 h-full w-full object-contain object-bottom p-3 transition-transform duration-700 group-hover:scale-105">
                </div>
            </div>

        </div>
    </div>
</section>
