{{-- Hero Slider --}}

@php
    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number', '+92 300 XXXXXXX');
    $whatsAppLink   = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsAppNumber ?: '923001234567');
@endphp

<section class="relative bg-bg-light" style="overflow:hidden;">

    {{-- Decorative side bars --}}
    <div class="pointer-events-none absolute -left-8 top-1/3 hidden h-48 w-10 rounded-r-3xl bg-accent/45 lg:block" style="z-index:5;"></div>
    <div class="pointer-events-none absolute -right-8 top-1/3 hidden h-48 w-10 rounded-l-3xl bg-accent/45 lg:block" style="z-index:5;"></div>

    {{-- Clip wrapper --}}
    <div id="hero-clip" style="width:100%; overflow:hidden; position:relative;">

        {{-- Flex slider track --}}
        <div id="hero-slider" style="display:flex; transition:transform 0.6s cubic-bezier(0.77,0,0.175,1);">

            {{-- ===== SLIDE 1 – Aesthetic Machines ===== --}}
            <div class="hero-slide px-4 pt-8 pb-0 sm:px-6 lg:px-8 lg:pt-16 lg:pb-0" style="flex-shrink:0;">
                <div class="mx-auto grid max-w-[1180px] items-center gap-8 lg:grid-cols-[0.92fr_1.08fr]">

                    <div class="order-2 lg:order-1">
                        <div class="mb-4 inline-flex min-h-12 items-center gap-2 rounded-2xl bg-white px-4 text-sm font-semibold text-text-secondary shadow-sm">
                            <span class="h-2.5 w-2.5 rounded-full bg-success"></span>
                            Wholesale supplier since 2017
                        </div>
                        <h1 class="font-heading text-[2.45rem] font-bold leading-[1.04] tracking-normal text-text-primary sm:text-5xl lg:text-6xl">
                            <span class="text-primary">Advanced Aesthetic</span> Machines for Modern Clinics
                        </h1>
                        <p class="mt-5 max-w-xl text-base leading-7 text-text-secondary">
                            The Cosmex is a trusted direct importer and supplier of advanced aesthetic machines — empowering clinics and spas with cutting-edge technology.
                        </p>
                        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary w-full sm:w-auto">
                                <i class="fa-brands fa-whatsapp text-white"></i>
                                Get Wholesale Pricing
                            </a>
                            <a href="{{ route('products.index') }}" class="btn-outline-primary w-full sm:w-auto">
                                Explore Machines
                            </a>
                        </div>
                        <div class="mt-8 grid grid-cols-3 gap-3 text-xs font-semibold text-text-primary">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-award text-xl text-primary"></i><span>Premium Quality Products</span></div>
                            <div class="flex items-center gap-2"><i class="fa-regular fa-user text-xl text-primary"></i><span>Expert Support &amp; Training</span></div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-xl text-primary"></i><span>Reliable After-Sales Service</span></div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <div class="relative mx-auto aspect-[4/3] max-h-[430px] lg:aspect-square lg:max-h-[560px]">
                            <img src="{{ asset('images/COSMEX-AESTHETIC-IMPORTER.png') }}" alt="Cosmex aesthetic machines"
                                class="absolute inset-0 h-full w-full object-contain object-center"
                                loading="eager" fetchpriority="high">
                        </div>
                    </div>

                </div>
            </div>
            {{-- END SLIDE 1 --}}

            {{-- ===== SLIDE 2 – Aesthetic Products ===== --}}
            <div class="hero-slide px-4 pt-8 pb-0 sm:px-6 lg:px-8 lg:pt-16 lg:pb-0" style="flex-shrink:0;">
                <div class="mx-auto grid max-w-[1180px] items-center gap-8 lg:grid-cols-[0.92fr_1.08fr]">

                    <div class="order-2 lg:order-1">
                        <div class="mb-4 inline-flex min-h-12 items-center gap-2 rounded-2xl bg-white px-4 text-sm font-semibold text-text-secondary shadow-sm">
                            <span class="h-2.5 w-2.5 rounded-full bg-success"></span>
                            Professional Skincare Range
                        </div>
                        <h1 class="font-heading text-[2.45rem] font-bold leading-[1.04] tracking-normal text-text-primary sm:text-5xl lg:text-6xl">
                            <span class="text-primary">Premium Aesthetic</span> Products for Skin &amp; Beauty
                        </h1>
                        <p class="mt-5 max-w-xl text-base leading-7 text-text-secondary">
                            Discover our curated range of professional aesthetic products — serums, peels, and skincare solutions trusted by leading salons and clinics across Pakistan.
                        </p>
                        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary w-full sm:w-auto">
                                <i class="fa-brands fa-whatsapp text-white"></i>
                                Order Now
                            </a>
                            <a href="{{ route('products.index') }}" class="btn-outline-primary w-full sm:w-auto">
                                View Products
                            </a>
                        </div>
                        <div class="mt-8 grid grid-cols-3 gap-3 text-xs font-semibold text-text-primary">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-flask text-xl text-primary"></i><span>Clinically Tested Formulas</span></div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-leaf text-xl text-primary"></i><span>Safe &amp; Dermatologist Approved</span></div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-xl text-primary"></i><span>Nationwide Delivery</span></div>
                        </div>
                    </div>

                    {{-- Image placeholder – drop your file in public/images/ and update the src --}}
                    <div class="order-1 lg:order-2">
                        <div class="relative mx-auto aspect-[4/3] max-h-[430px] lg:aspect-square lg:max-h-[560px]">
                            <img src="{{ asset('images/aesthetic_products_hero.png') }}" alt="Cosmex aesthetic products"
                                class="absolute inset-0 h-full w-full object-contain object-center"
                                loading="lazy">
                        </div>
                    </div>

                </div>
            </div>
            {{-- END SLIDE 2 --}}

        </div>{{-- /hero-slider --}}
    </div>{{-- /hero-clip --}}

    {{-- Navigation Dots --}}
    <div class="flex justify-center gap-3 pb-6 pt-2" style="margin-bottom: 50px;" id="hero-dots" aria-label="Slide navigation">
        <button class="hero-dot rounded-full bg-primary transition-all duration-300" style="height:10px;width:32px;" data-target="0" aria-label="Slide 1"></button>
        <button class="hero-dot rounded-full transition-all duration-300" style="height:10px;width:10px;background:rgba(var(--color-primary-rgb,0,106,196),0.3);" data-target="1" aria-label="Slide 2"></button>
    </div>

    {{-- Prev / Next arrows (Hidden per user request) --}}
    <button id="hero-prev"
        style="display:none; position:absolute;left:12px;top:45%;transform:translateY(-50%);z-index:20;"
        class="hidden h-10 w-10 items-center justify-center rounded-full bg-white/80 shadow-md backdrop-blur-sm transition hover:bg-white hover:shadow-lg focus:outline-none"
        aria-label="Previous slide">
        <i class="fa-solid fa-chevron-left text-primary"></i>
    </button>
    <button id="hero-next"
        style="display:none; position:absolute;right:12px;top:45%;transform:translateY(-50%);z-index:20;"
        class="hidden h-10 w-10 items-center justify-center rounded-full bg-white/80 shadow-md backdrop-blur-sm transition hover:bg-white hover:shadow-lg focus:outline-none"
        aria-label="Next slide">
        <i class="fa-solid fa-chevron-right text-primary"></i>
    </button>

</section>

<script>
(function () {
    var clip      = document.getElementById('hero-clip');
    var slider    = document.getElementById('hero-slider');
    var slides    = slider.querySelectorAll('.hero-slide');
    var dots      = document.querySelectorAll('.hero-dot');
    var prevBtn   = document.getElementById('hero-prev');
    var nextBtn   = document.getElementById('hero-next');
    var total     = slides.length;
    var current   = 0;
    var autoTimer = null;

    /* ── Set each slide to the clip wrapper's pixel width ── */
    function setWidths() {
        var w = clip.offsetWidth;
        slides.forEach(function (s) { s.style.width = w + 'px'; });
        /* Re-apply current position without animation */
        slider.style.transition = 'none';
        slider.style.transform  = 'translateX(-' + (current * clip.offsetWidth) + 'px)';
        requestAnimationFrame(function () {
            slider.style.transition = 'transform 0.6s cubic-bezier(0.77,0,0.175,1)';
        });
    }

    function goTo(index) {
        current = (index + total) % total;
        slider.style.transform = 'translateX(-' + (current * clip.offsetWidth) + 'px)';
        dots.forEach(function (d, i) {
            d.style.width   = i === current ? '32px' : '10px';
            d.style.opacity = i === current ? '1'    : '0.35';
        });
    }

    function startAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(function () { goTo(current + 1); }, 5000);
    }

    prevBtn.addEventListener('click', function () { goTo(current - 1); startAuto(); });
    nextBtn.addEventListener('click', function () { goTo(current + 1); startAuto(); });
    dots.forEach(function (d) {
        d.addEventListener('click', function () { goTo(+d.dataset.target); startAuto(); });
    });

    slider.addEventListener('mouseenter', function () { clearInterval(autoTimer); });
    slider.addEventListener('mouseleave', startAuto);

    /* Swipe */
    var touchStartX = 0;
    slider.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend',   function (e) {
        var diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) { goTo(diff > 0 ? current + 1 : current - 1); startAuto(); }
    }, { passive: true });

    window.addEventListener('resize', setWidths);

    /* Init */
    setWidths();
    goTo(0);
    startAuto();
})();
</script>