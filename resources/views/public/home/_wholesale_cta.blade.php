@php
    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number', '923001234567');
    $whatsAppLink = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsAppNumber);
@endphp

<section class="bg-primary py-16 lg:py-20 overflow-hidden shadow-inner">
    <div class="mx-auto max-w-[1280px] px-6 lg:px-20">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10 text-center lg:text-left">

            {{-- Left: Icon + Text --}}
            <div class="flex flex-col lg:flex-row items-center gap-8">
                {{-- White WhatsApp Icon Box --}}
                <div class="shrink-0 flex h-20 w-20 lg:h-24 lg:w-24 items-center justify-center rounded-full bg-white shadow-xl">
                    <i class="fa-brands fa-whatsapp text-primary text-4xl lg:text-5xl"></i>
                </div>

                {{-- Text --}}
                <div>
                    <h2 class="text-3xl lg:text-5xl font-extrabold tracking-tight text-white font-heading leading-tight">
                        Looking for Wholesale Prices?
                    </h2>
                    <p class="mt-3 text-base lg:text-lg text-white leading-relaxed max-w-xl">
                        Contact us on WhatsApp for the best wholesale deals, bulk pricing, and direct clinic inquiries.
                    </p>
                </div>
            </div>

            {{-- Right: White CTA Button --}}
            <div class="flex justify-center shrink-0">
                <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer"
                   class="group flex items-center justify-center gap-3 rounded-full bg-white px-10 py-5 lg:px-12 lg:py-6 text-sm lg:text-base font-bold uppercase tracking-wider text-primary shadow-xl transition-all hover:bg-white/95 hover:scale-105 active:scale-95">
                    <i class="fa-brands fa-whatsapp text-2xl text-primary"></i>
                    <span>Chat on WhatsApp</span>
                    <i class="fa-solid fa-arrow-right text-xs text-primary transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>

        </div>
    </div>
</section>