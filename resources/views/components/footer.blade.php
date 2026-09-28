@php
    $siteTagline = 'Professional Aesthetic Products & Machines';
    $whatsAppNumber = \App\Models\Setting::get('whatsapp_number');
    $whatsAppLink = 'https://wa.me/'.preg_replace('/\D+/', '', $whatsAppNumber);
    $instagram = \App\Models\Setting::get('social_instagram');
    $facebook = \App\Models\Setting::get('social_facebook');
    $tiktok = \App\Models\Setting::get('social_tiktok');
@endphp

<footer class="bg-white text-text-primary">
    <div class="mx-auto max-w-[1180px] px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
            <div>
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/COSMEX_LOGO.png') }}" alt="{{ config('site.name') }} logo" width="240" height="60" loading="lazy" class="h-[60px] w-auto object-contain">
                </a>
                <p class="mt-5 max-w-sm text-sm leading-7 text-text-secondary">{{ $siteTagline }} imported for clinics, dermatologists, and beauty professionals across Pakistan.</p>
                <div class="mt-6 flex items-center gap-5">
                    @if ($facebook)<a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                    @if ($instagram)<a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if ($tiktok)<a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>@endif
                    <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="text-text-secondary transition hover:text-primary" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <div>
                <p class="footer-title font-heading">Quick Links</p>
                <ul class="mt-6 space-y-3 text-sm text-text-secondary">
                    <li><a href="{{ route('products.index') }}" class="transition hover:text-primary">All Products</a></li>
                    @foreach ($footerTopCategories as $footerCategory)
                        <li><a href="{{ route('category.show', $footerCategory->slug) }}" class="transition hover:text-primary">{{ $footerCategory->name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('blog.index') }}" class="transition hover:text-primary">Guides &amp; Blog</a></li>
                    <li><a href="{{ route('about') }}" class="transition hover:text-primary">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="transition hover:text-primary">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <p class="footer-title font-heading">Popular</p>
                <ul class="mt-6 space-y-3 text-sm text-text-secondary">
                    @foreach ($footerPopularCategories as $footerCategory)
                        <li><a href="{{ route('category.show', $footerCategory->slug) }}" class="transition hover:text-primary">{{ $footerCategory->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="footer-title font-heading">Contact</p>
                <ul class="mt-6 space-y-4 text-sm text-text-secondary">
                    <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-primary"></i><span>{{ \App\Models\Setting::get('contact_phone') }}</span></li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-primary"></i><span>{{ \App\Models\Setting::get('contact_email') }}</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-primary mt-1"></i><span>{{ \App\Models\Setting::get('address') }}</span></li>
                </ul>
                <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-8 inline-flex items-center gap-2 text-sm">
                    <i class="fa-brands fa-whatsapp text-white"></i>
                    <span>WhatsApp Inquiry</span>
                </a>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-4 border-t border-border pt-6 text-sm text-text-secondary lg:flex-row lg:items-center lg:justify-between">
            <p>© {{ date('Y') }} {{ config('site.legal_name') }}. All Rights Reserved.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('privacy') }}" class="footer-link">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="footer-link">Terms &amp; Conditions</a>
                <a href="{{ route('sitemap') }}" class="footer-link">Sitemap</a>
            </div>
            <p>Johar Town, Lahore, Pakistan</p>
        </div>
    </div>
</footer>
