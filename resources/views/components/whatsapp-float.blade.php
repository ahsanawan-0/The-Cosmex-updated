@php
    $waNumber = preg_replace('/\D+/', '', \App\Models\Setting::get('whatsapp_number') ?: '923284333364');
    $waLink = 'https://wa.me/'.$waNumber.'?text='.rawurlencode('Hi, I would like to know more about your products.');
@endphp

<a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="wa-fab" aria-label="Chat with us on WhatsApp" title="Chat with us on WhatsApp">
    @include('components.partials.icons.whatsapp')
</a>

{{-- Self-contained styles: the prebuilt Tailwind CSS only has classes that existed at build time. --}}
<style>
    /* Phones and tablets: float above the fixed bottom nav (77px tall, plus the iPhone home-bar inset). */
    .wa-fab {
        position: fixed;
        right: 16px;
        bottom: calc(92px + env(safe-area-inset-bottom, 0px));
        z-index: 55; /* above the bottom nav (50), below the category and search sheets (68+) */
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 9999px;
        background: #25D366;
        color: #fff;
        box-shadow: 0 10px 25px rgba(37, 211, 102, .35), 0 4px 10px rgba(0, 0, 0, .12);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .wa-fab:hover { transform: scale(1.06); box-shadow: 0 14px 30px rgba(37, 211, 102, .45), 0 6px 14px rgba(0, 0, 0, .14); }
    .wa-fab:focus-visible { outline: 3px solid #075FB8; outline-offset: 3px; }
    .wa-fab svg { width: 30px; height: 30px; }
    .wa-fab::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: -1;
        border-radius: inherit;
        background: #25D366;
        animation: wa-fab-pulse 2.4s ease-out infinite;
    }
    @keyframes wa-fab-pulse {
        0% { transform: scale(1); opacity: .45; }
        80%, 100% { transform: scale(1.6); opacity: 0; }
    }

    /* Desktop: stack directly above the scroll-to-top button (48px at bottom/right 24px), centred on it. */
    @media (min-width: 1024px) {
        .wa-fab { right: 20px; bottom: 88px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .wa-fab { transition: none; }
        .wa-fab::before { display: none; }
    }
</style>
