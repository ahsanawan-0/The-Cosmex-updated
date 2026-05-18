@props([
    'product' => null,
    'theme' => 'green',
])

@php
    $number = preg_replace('/\D+/', '', \App\Models\Setting::get('whatsapp_number', env('WHATSAPP_NUMBER', '923001234567')));
    $message = $product
        ? 'Hi, I want to order '.$product->name
        : 'Hi, I want to place an order.';
    $link = 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    $themeClasses = $theme === 'gold'
        ? 'bg-primary text-white hover:bg-primary-dark'
        : 'bg-emerald-600 text-white hover:bg-emerald-700';
@endphp

<a
    href="{{ $link }}"
    target="_blank"
    rel="noopener noreferrer"
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-full px-4 py-2.5 font-medium transition '.$themeClasses]) }}
>
    @include('components.partials.icons.whatsapp')
    <span>Order on WhatsApp</span>
</a>
