<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    @if (config('services.ga.id') && ! app()->environment('local'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());

            gtag('config', '{{ config('services.ga.id') }}');

            // Count WhatsApp and phone taps as leads.
            document.addEventListener('click', function (event) {
                var link = event.target.closest && event.target.closest('a[href^="https://wa.me"], a[href^="tel:"]');
                if (link) {
                    gtag('event', 'generate_lead', { method: link.href.indexOf('tel:') === 0 ? 'phone' : 'whatsapp' });
                }
            });
        </script>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F8F9FA">

    @php
        $decode = fn (string $value) => html_entity_decode(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Sections set with @section('x', $value) arrive HTML-escaped. Decode them
        // once here so the components below escape exactly once.
        $seoTitle = \App\Helpers\SeoHelper::title($__env->yieldContent('title'));
        $seoDescription = \App\Helpers\SeoHelper::description($__env->yieldContent('meta_description'))
            ?: config('site.tagline') . ' for clinics across Pakistan.';
        $seoCanonical = $decode($__env->yieldContent('canonical')) ?: url()->current();
        $seoRobots = $decode($__env->yieldContent('robots')) ?: 'index, follow, max-image-preview:large';
        $ogImage = $decode($__env->yieldContent('og_image')) ?: url(config('site.og_image'));
        $ogType = $decode($__env->yieldContent('og_type')) ?: 'website';
        $pageSchema = trim($__env->yieldContent('schema'));

        $fontsUrl = 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap';
        $iconsUrl = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css';
    @endphp

    <x-seo.meta-tags :title="$seoTitle" :description="$seoDescription" :canonical="$seoCanonical" :robots="$seoRobots" />
    <x-seo.og-tags :title="$seoTitle" :description="$seoDescription" :image="$ogImage" :url="$seoCanonical"
        :type="$ogType" />

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('images/favicon-48.png') }}" type="image/png" sizes="48x48">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo.schema>{!! \App\Helpers\SeoHelper::json(\App\Helpers\SeoHelper::siteSchema()) !!}</x-seo.schema>
    @if ($pageSchema !== '')
        <x-seo.schema>{!! $pageSchema !!}</x-seo.schema>
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    {{-- Fonts and icons load without blocking the first paint --}}
    <link rel="preload" as="style" href="{{ $fontsUrl }}">
    <link rel="stylesheet" href="{{ $fontsUrl }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ $iconsUrl }}" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ $fontsUrl }}">
        <link rel="stylesheet" href="{{ $iconsUrl }}">
    </noscript>

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
    @stack('head')
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
