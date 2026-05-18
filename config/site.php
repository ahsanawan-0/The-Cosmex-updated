<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'name'     => env('SITE_NAME', 'Cosmex Pvt Ltd'),
    'tagline'  => env('SITE_TAGLINE', 'Professional Aesthetic Products & Machines'),
    'domain'   => env('APP_URL', 'https://cosmexpvtltd.com'),

    /*
    |--------------------------------------------------------------------------
    | Contact & WhatsApp
    |--------------------------------------------------------------------------
    */
    'whatsapp'      => env('WHATSAPP_NUMBER', '923001234567'),
    'contact_email' => env('CONTACT_EMAIL', 'info@cosmexpvtltd.com'),
    'contact_phone' => env('CONTACT_PHONE', '+923001234567'),

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
