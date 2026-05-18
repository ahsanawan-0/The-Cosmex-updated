<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F8F9FA">
    <link rel="icon" href="{{ asset('images/cosmex_fav.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = 'Cosmex Pvt Ltd';
        $siteTagline = 'Professional Aesthetic Products & Machines';
        $seoTitle = trim($__env->yieldContent('title')) ?: $siteName;
        $seoDescription = trim($__env->yieldContent('meta_description')) ?: $siteTagline;
        $seoCanonical = trim($__env->yieldContent('canonical')) ?: url()->current();
        $seoKeywords = trim($__env->yieldContent('meta_keywords'));
        $ogImage = trim($__env->yieldContent('og_image')) ?: url('/images/placeholder-product.webp');
        $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
        $schemaContent = trim($__env->yieldContent('schema'));
        $defaultSchema = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
            'logo' => url('/images/placeholder-product.webp'),
            'description' => $siteTagline,
            'sameAs' => array_values(array_filter([
                \App\Models\Setting::get('social_instagram'),
                \App\Models\Setting::get('social_facebook'),
                \App\Models\Setting::get('social_tiktok'),
                \App\Models\Setting::get('social_whatsapp'),
            ])),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    @endphp

    <x-seo.meta-tags :title="$seoTitle" :description="$seoDescription" :canonical="$seoCanonical"
        :keywords="$seoKeywords" />
    <x-seo.og-tags :title="$seoTitle" :description="$seoDescription" :image="$ogImage" :url="$seoCanonical"
        :type="$ogType" />
    <x-seo.schema>
        {!! $schemaContent !== '' ? $schemaContent : $defaultSchema !!}
    </x-seo.schema>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://wa.me">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @if (config('services.ga.id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ config('services.ga.id') }}');
        </script>
    @endif

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        [data-cloak] {
            display: none !important;
        }

        :root {
        --font-open-sans: 'Open Sans', sans-serif;
        --font-outfit: 'Outfit', sans-serif;
        }

        body,
        html {
            font-family: var(--font-open-sans) !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading,
        .section-title {
            font-family: var(--font-outfit) !important;
        }

        * {
            font-family: inherit;
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body_class', 'bg-bg-light text-text-primary antialiased')">
    @include('components.header')

    <main class="min-h-screen">
        @hasSection('body')
            @yield('body')
        @else
            @yield('content')
        @endif
    </main>

    @include('components.footer')

    @stack('scripts')

    {{-- Scroll to Top Button --}}
    <button id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed bottom-6 right-6 z-50 hidden h-12 w-12 translate-y-20 items-center justify-center rounded-2xl bg-primary text-white opacity-0 shadow-lg transition-all duration-300 hover:scale-105 focus:outline-none lg:flex"
            aria-label="Scroll to top">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollBtn = document.getElementById('scrollToTopBtn');
            if (scrollBtn) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) {
                        scrollBtn.classList.remove('translate-y-20', 'opacity-0');
                        scrollBtn.classList.add('translate-y-0', 'opacity-100');
                    } else {
                        scrollBtn.classList.add('translate-y-20', 'opacity-0');
                        scrollBtn.classList.remove('translate-y-0', 'opacity-100');
                    }
                });
            }
        });
    </script>
</body>

</html>
