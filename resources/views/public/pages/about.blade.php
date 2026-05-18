@extends('layouts.app')

@section('title', 'About Cosmex Pvt Ltd | Professional Aesthetic Products Pakistan')
@section('meta_description', "Learn about Cosmex Pvt Ltd, Pakistan's trusted supplier for professional aesthetic machines, clinic products, and beauty equipment.")
@section('canonical', url('/about'))

@section('content')
    <section class="bg-bg-light px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
        <div class="mx-auto max-w-[1180px]">
            <p class="text-sm font-semibold uppercase text-primary">Our Story</p>
            <h1 class="mt-3 font-heading text-4xl font-bold tracking-normal text-text-primary sm:text-5xl">About Cosmex Pvt Ltd</h1>
            <p class="mt-4 max-w-2xl text-base leading-8 text-text-secondary">
                Pakistan's trusted source for professional aesthetic machines, clinic products, and beauty equipment.
            </p>
        </div>
    </section>

    <section class="bg-bg-light px-4 pb-12 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-[1180px] items-center gap-6 lg:grid-cols-2">
            <div class="rounded-2xl bg-white p-6 shadow-card lg:p-8">
                <p class="text-sm font-semibold uppercase text-primary">Who We Are</p>
                <h2 class="mt-3 font-heading text-3xl font-bold text-text-primary">Built for aesthetic professionals</h2>
                <p class="mt-5 text-base leading-8 text-text-secondary">Cosmex Pvt Ltd was founded with a single mission: to make reliable aesthetic machines and clinic-grade products accessible to professionals across Pakistan.</p>
                <p class="mt-4 text-base leading-8 text-text-secondary">We source directly from trusted distributors and authorized suppliers, ensuring every product you receive is genuine, sealed, and ready for professional use.</p>
            </div>
            <div class="flex min-h-[280px] items-center justify-center rounded-2xl bg-white p-10 shadow-card">
                <div class="text-center">
                    <p class="font-heading text-6xl font-bold text-primary">Cosmex</p>
                    <p class="mt-3 text-sm font-medium text-text-secondary">Professional Aesthetic Supply</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-bg-light px-4 pb-12 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-[1180px] grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach([
                ['num' => '1000+', 'label' => 'Products'],
                ['num' => '4', 'label' => 'Core Categories'],
                ['num' => '100%', 'label' => 'Authentic'],
                ['num' => 'PK', 'label' => 'Nationwide Delivery'],
            ] as $stat)
                <div class="rounded-2xl bg-white p-5 text-center shadow-card">
                    <p class="font-heading text-3xl font-bold text-primary">{{ $stat['num'] }}</p>
                    <p class="mt-2 text-xs font-semibold uppercase text-text-secondary">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-bg-light px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-[1180px]">
            <h2 class="font-heading text-3xl font-bold text-text-primary">Our Values</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Authenticity First', 'desc' => 'Every product is sourced from reliable suppliers with quality at the center.'],
                    ['icon' => 'fa-solid fa-comments', 'title' => 'Customer First', 'desc' => 'Fast WhatsApp support, clear guidance, and practical product help.'],
                    ['icon' => 'fa-solid fa-truck-fast', 'title' => 'Fast Delivery', 'desc' => 'Reliable delivery across Pakistan for clinics and professionals.'],
                ] as $val)
                    <div class="rounded-2xl bg-white p-6 shadow-card">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary"><i class="{{ $val['icon'] }}"></i></div>
                        <h3 class="mt-4 font-heading text-xl font-semibold text-text-primary">{{ $val['title'] }}</h3>
                        <p class="mt-2 text-sm leading-7 text-text-secondary">{{ $val['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
