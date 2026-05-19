@php
    $siteTagline = 'Professional Aesthetic Products & Machines';
    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number', '+92 300 XXXXXXX');
    $whatsAppLink = 'https://wa.me/'.preg_replace('/\D+/', '', $whatsAppNumber ?: '923001234567');
    $instagram = \App\Models\Setting::get('social_instagram', '#');
    $facebook = \App\Models\Setting::get('social_facebook', '#');
    $tiktok = \App\Models\Setting::get('social_tiktok', '#');
@endphp

<footer class="bg-white text-text-primary">
    <div class="mx-auto max-w-[1180px] px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
            <div>
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/COSMEX_LOGO.png') }}" alt="Cosmex Logo" class="h-[60px] w-auto object-contain">
                </a>
                <p class="mt-5 max-w-sm text-sm leading-7 text-text-secondary">{{ $siteTagline }} imported for clinics, dermatologists, and beauty professionals.</p>
                <div class="mt-6 flex items-center gap-5">
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <div>
                <h3 class="footer-title">Quick Links</h3>
                <ul class="mt-6 space-y-3 text-sm text-text-secondary">
                    <li><a href="{{ route('products.index') }}" class="transition hover:text-primary">All Products</a></li>
                    <li><a href="{{ route('category.show', 'laser-machines') }}" class="transition hover:text-primary">Laser Machines</a></li>
                    <li><a href="{{ route('category.show', 'hydrafacial') }}" class="transition hover:text-primary">HydraFacial</a></li>
                    <li><a href="{{ route('category.show', 'aesthetic-products') }}" class="transition hover:text-primary">Aesthetic Products</a></li>
                    <li><a href="{{ route('category.show', 'other-equipment') }}" class="transition hover:text-primary">Other Equipment</a></li>
                    <li><a href="{{ route('about') }}" class="transition hover:text-primary">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="transition hover:text-primary">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-title">Popular</h3>
                <ul class="mt-6 space-y-3 text-sm text-text-secondary">
                    <li><a href="{{ route('category.show', 'exosomes') }}" class="transition hover:text-primary">Exosomes</a></li>
                    <li><a href="{{ route('category.show', 'botox') }}" class="transition hover:text-primary">Botox</a></li>
                    <li><a href="{{ route('category.show', 'dermal-fillers') }}" class="transition hover:text-primary">Dermal Fillers</a></li>
                    <li><a href="{{ route('category.show', 'skin-whitening-injections') }}" class="transition hover:text-primary">Skin Whitening Injections</a></li>
                    <li><a href="{{ route('category.show', 'tools-devices') }}" class="transition hover:text-primary">Tools &amp; Devices</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-title">Contact</h3>
                <ul class="mt-6 space-y-4 text-sm text-text-secondary">
                    <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-primary"></i><span>{{ \App\Models\Setting::get('contact_phone', '0328-4333364') }}</span></li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-primary"></i><span>{{ \App\Models\Setting::get('contact_email', 'info@thecosmex.com') }}</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-primary mt-1"></i><span>{{ \App\Models\Setting::get('address', '21-B, G Block, Johar Town, Lahore, Pakistan') }}</span></li>
                </ul>
                <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-8 inline-flex items-center gap-2 text-sm">
                    <i class="fa-brands fa-whatsapp text-white"></i>
                    <span>WhatsApp Inquiry</span>
                </a>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-4 border-t border-border pt-6 text-sm text-text-secondary lg:flex-row lg:items-center lg:justify-between">
            <p>© 2026 Cosmex Pvt Ltd. All Rights Reserved.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('privacy') }}" class="footer-link">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="footer-link">Terms &amp; Conditions</a>
                <a href="{{ route('sitemap') }}" class="footer-link">Sitemap</a>
            </div>
            <p>Made in Pakistan</p>
        </div>
    </div>
</footer>
