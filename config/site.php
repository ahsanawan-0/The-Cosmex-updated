<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'name'     => env('SITE_NAME', 'The Cosmex'),
    'tagline'  => env('SITE_TAGLINE', 'Professional Aesthetic Products & Machines'),
    'domain'   => env('APP_URL', 'https://thecosmex.com'),

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
