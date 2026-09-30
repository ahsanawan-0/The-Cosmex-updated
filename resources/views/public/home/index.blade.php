@extends('layouts.app')

@section('title', 'Wholesale Aesthetic Machines Supplier in Pakistan')
@section('meta_description', 'Wholesale importer and supplier of aesthetic machines in Pakistan: HydraFacial, diode laser, HIFU and CO2 machines plus clinic products. Delivery nationwide.')
@section('canonical', url('/'))

@section('content')
    @include('public.home._hero')
    @include('public.home._hero_features')
    @include('public.home._category_grid')

    <x-product.section
        :products="$hydrafacialProducts"
        title="HydraFacial Machines"
        subtitle="Premium hydrafacial consumables and machines for your clinic"
        category-slug="hydrafacial"
        category-label="All HydraFacial Machines"
    />

    @include('public.home._aesthetic_categories', ['aestheticCategories' => $aestheticCategories])

    <x-product.section
        :products="$laserProducts"
        title="Laser Machines"
        subtitle="Advanced diode, IPL and CO2 laser machines for aesthetic clinics"
        category-slug="laser-machines"
        category-label="All Laser Machines"
    />

    @include('public.home._videos')

    @include('public.home._blog')

    @include('public.home._reviews', ['featuredReviews' => $featuredReviews])
    @include('public.home._wholesale_cta')

    <x-whatsapp-float />
@endsection
