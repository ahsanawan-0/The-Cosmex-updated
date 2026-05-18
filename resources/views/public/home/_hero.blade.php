<section class="relative overflow-hidden bg-bg-light px-4 pb-8 pt-8 sm:px-6 lg:px-8 lg:py-16">
    <div class="pointer-events-none absolute -left-8 top-1/3 hidden h-48 w-10 rounded-r-3xl bg-accent/45 lg:block">
    </div>
    <div class="pointer-events-none absolute -right-8 top-1/3 hidden h-48 w-10 rounded-l-3xl bg-accent/45 lg:block">
    </div>
    <div class="mx-auto grid max-w-[1180px] items-center gap-8 lg:grid-cols-[0.92fr_1.08fr]">
        <div class="order-2 lg:order-1">
            <div
                class="mb-4 inline-flex min-h-12 items-center gap-2 rounded-2xl bg-white px-4 text-sm font-semibold text-text-secondary shadow-sm">
                <span class="h-2.5 w-2.5 rounded-full bg-success"></span>
                Wholesale supplier since 2017
            </div>
            <h1
                class="font-heading text-[2.45rem] font-bold leading-[1.04] tracking-normal text-text-primary sm:text-5xl lg:text-6xl">
                <span class="text-primary">Premium Aesthetic</span> Solutions for Skin, Beauty & Wellness
            </h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-text-secondary">
                The Cosmex is a trusted direct importer and supplier of advanced aesthetic machines and premium
                professional skincare products.
            </p>
            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                @php
                    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number', '+92 300 XXXXXXX');
                    $whatsAppLink = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsAppNumber ?: '923001234567');
                @endphp
                <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer"
                    class="btn-primary w-full sm:w-auto">
                    <i class="fa-brands fa-whatsapp text-white"></i>
                    Get Wholesale Pricing
                </a>
                <a href="{{ route('products.index') }}" class="btn-outline-primary w-full sm:w-auto">
                    Contact Us
                </a>
            </div>
            <div class="mt-8 grid grid-cols-3 gap-3 text-xs font-semibold text-text-primary">
                <div class="flex items-center gap-2"><i class="fa-solid fa-award text-xl text-primary"></i><span>Premium
                        Quality Products</span></div>
                <div class="flex items-center gap-2"><i class="fa-regular fa-user text-xl text-primary"></i><span>Expert
                        Support & Training</span></div>
                <div class="flex items-center gap-2"><i
                        class="fa-solid fa-shield-halved text-xl text-primary"></i><span>Reliable After-Sales
                        Service</span></div>
            </div>
        </div>

        <div class="order-1 lg:order-2">
            <div
                class="relative mx-auto aspect-[4/3] max-h-[430px] overflow-hidden rounded-[28px] bg-gradient-to-br from-[#F3F9FF] via-white to-[#EAF5FF] shadow-card lg:aspect-square lg:max-h-[560px]">
                <div class="absolute bottom-8 left-1/2 h-56 w-64 -translate-x-1/2 rounded-[28px] bg-primary"></div>
                <img src="{{ asset('images/aesthetic_hero.png') }}" alt="Cosmex aesthetic machines and products"
                    class="absolute inset-0 h-full w-full object-contain object-center p-4 sm:p-8" loading="eager"
                    fetchpriority="high">
            </div>
        </div>
    </div>
</section>