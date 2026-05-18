@php
    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number', '923001234567');
    $whatsAppLink = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsAppNumber);
@endphp

<section class="bg-zinc-900">
    <div class="relative overflow-hidden">

        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/footer-above.png') }}" alt="Wholesale Inquiry"
                class="absolute inset-0 h-full w-full object-cover object-center opacity-40">
            <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/95 via-zinc-950/75 to-zinc-950/30"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 mx-auto max-w-[1280px] px-6 py-14 lg:px-20 lg:py-20"
             style="display:grid; grid-template-columns: 2fr 1fr; align-items: center; gap: 2.5rem;">

            {{-- Left: Icon + Text --}}
            <div class="flex flex-col lg:flex-row items-center lg:items-center gap-8 text-center lg:text-left">

                {{-- WhatsApp Icon --}}
                <div class="shrink-0 flex h-20 w-20 lg:h-24 lg:w-24 items-center justify-center rounded-full bg-primary shadow-2xl shadow-primary/40">
                    <i class="fa-brands fa-whatsapp text-white text-4xl lg:text-5xl"></i>
                </div>

                {{-- Text --}}
                <div>
                    <h2 class="text-3xl lg:text-5xl font-extrabold tracking-tight text-white font-heading leading-tight">
                        Looking for <span class="text-primary">Wholesale Prices?</span>
                    </h2>
                    <p class="mt-3 text-base lg:text-xl text-zinc-300 leading-relaxed">
                        Contact us on WhatsApp for the best wholesale deals and product inquiries.
                    </p>
                </div>
            </div>

            {{-- Right: Button --}}
            <div class="flex justify-center lg:justify-end">
                <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer"
                   class="group relative flex items-center justify-center gap-3 overflow-hidden bg-primary px-10 py-5 lg:px-14 lg:py-6 text-sm lg:text-base font-bold uppercase tracking-widest text-white shadow-2xl shadow-primary/30 transition-all hover:scale-[1.03] active:scale-[0.98]">
                    {{-- Shine --}}
                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-700 group-hover:translate-x-full pointer-events-none"></div>

                    <i class="fa-brands fa-whatsapp text-2xl relative z-10"></i>
                    <span class="relative z-10">Chat on WhatsApp</span>
                    <i class="fa-solid fa-arrow-right text-xs relative z-10 transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>

        </div>
    </div>
</section>