<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'name'       => env('SITE_NAME', 'The Cosmex'),
    'legal_name' => env('SITE_LEGAL_NAME', 'Cosmex Pvt Ltd'),
    'tagline'    => env('SITE_TAGLINE', 'Professional Aesthetic Products & Machines'),
    'domain'     => env('APP_URL', 'https://thecosmex.com'),
    'logo'       => '/images/COSMEX_LOGO.png',
    'og_image'   => '/images/og-homepage.jpg',

    /*
    |--------------------------------------------------------------------------
    | Structured Address (LocalBusiness schema)
    |--------------------------------------------------------------------------
    */
    'street'  => env('CONTACT_STREET', '21-B, G Block, Johar Town'),
    'city'    => env('CONTACT_CITY', 'Lahore'),
    'region'  => env('CONTACT_REGION', 'Punjab'),
    'country' => env('CONTACT_COUNTRY', 'PK'),

    /*
    |--------------------------------------------------------------------------
    | Contact & WhatsApp
    |--------------------------------------------------------------------------
    */
    'whatsapp'      => env('WHATSAPP_NUMBER', '923284333364'),
    'contact_email' => env('CONTACT_EMAIL', 'info@thecosmex.com'),
    'contact_phone' => env('CONTACT_PHONE', '0328-4333364'),
    'address'       => env('CONTACT_ADDRESS', '21-B, G Block, Johar Town, Lahore, Pakistan'),

    /*
    |--------------------------------------------------------------------------
    | Social Profiles
    |--------------------------------------------------------------------------
    */
    'social_instagram' => env('SOCIAL_INSTAGRAM', 'https://www.instagram.com/thecosmex'),
    'social_facebook'  => env('SOCIAL_FACEBOOK', 'https://www.facebook.com/people/The-Cosmex/61566922037220/'),
    'social_tiktok'    => env('SOCIAL_TIKTOK', ''),

    /*
    |--------------------------------------------------------------------------
    | Homepage videos
    |--------------------------------------------------------------------------
    | Files live in public/videos (MP4, H.264) with posters in
    | public/images/videos. Used by the homepage section, its VideoObject
    | structured data and the sitemap.
    */
    'videos' => [
        [
            'file' => 'hydrafacial-machine',
            'title' => 'HydraFacial Machine',
            'description' => 'A closer look at a multi-handpiece HydraFacial machine with illuminated solution bottles and a touch screen.',
            'duration' => 3,
            'uploaded' => '2026-09-28T20:06:46+05:00',
            'category' => 'hydrafacial',
            'link_label' => 'HydraFacial machines',
        ],
        [
            'file' => 'hifu-machine',
            'title' => 'HIFU Skin-Tightening Machine',
            'description' => 'A HIFU machine with two cartridge handpieces and a touch-screen depth display.',
            'duration' => 9,
            'uploaded' => '2026-09-28T20:07:08+05:00',
            'category' => 'other-machines',
            'link_label' => 'HIFU & RF machines',
        ],
        [
            'file' => 'aesthetic-machines-lineup',
            'title' => 'Aesthetic Machine Line-up',
            'description' => 'A walk past a line-up of HydraFacial, laser and HIFU machines for aesthetic clinics.',
            'duration' => 9,
            'uploaded' => '2026-09-28T20:07:19+05:00',
            'category' => 'aesthetic-machines',
            'link_label' => 'All aesthetic machines',
        ],
        [
            'file' => 'emsculpt-co2-laser',
            'title' => 'Emsculpt & CO2 Fractional Laser',
            'description' => 'Emsculpt body-contouring and CO2 fractional laser machines, alongside other clinic equipment.',
            'duration' => 15,
            'uploaded' => '2026-09-28T20:10:28+05:00',
            'category' => 'aesthetic-machines',
            'link_label' => 'Body & laser machines',
        ],
        [
            'file' => 'hydrafacial-skin-analyser',
            'title' => 'HydraFacial with Skin Analyser',
            'description' => 'A HydraFacial machine with a built-in skin-analyser screen and multiple treatment handpieces.',
            'duration' => 5,
            'uploaded' => '2026-09-28T20:10:55+05:00',
            'category' => 'hydrafacial',
            'link_label' => 'HydraFacial machines',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */
    'currency'        => 'PKR',
    'currency_symbol' => 'PKR ',

    /*
    |--------------------------------------------------------------------------
    | Product Settings
    |--------------------------------------------------------------------------
    */
    'low_stock_threshold' => 5,
    'products_per_page'   => 24,

    /*
    |--------------------------------------------------------------------------
    | Image Settings
    |--------------------------------------------------------------------------
    */
    'image_quality'    => 85,
    'max_image_size'   => 5120, // KB
    'allowed_mimes'    => ['jpeg', 'jpg', 'png', 'webp'],
    'placeholder'      => '/images/placeholder-product.webp',
];
