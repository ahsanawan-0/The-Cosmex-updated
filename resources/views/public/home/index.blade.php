@extends('layouts.app')

@section('title', 'Cosmex Pvt Ltd - Professional Aesthetic Machines & Products')
@section('meta_description', 'Cosmex is a trusted importer and wholesale supplier of aesthetic clinic products and advanced machines in Pakistan since 2017.')
@section('canonical', url('/'))
@section('meta_keywords', 'aesthetic machines pakistan, clinic supplies pakistan, botox suppliers, diode laser machine, hydrafacial machine, cosmex')
@section('og_image', asset('images/og-homepage.jpg'))

@section('schema')
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebSite",
      "name": "Cosmex Pvt Ltd",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ url('/search') }}?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    },
    {
      "@@type": "Organization",
      "name": "Cosmex Pvt Ltd",
      "url": "{{ url('/') }}",
      "logo": "{{ url('/images/placeholder-product.webp') }}"
    }
  ]
}
@endsection

@section('content')
    @include('public.home._hero')
    @include('public.home._hero_features')
    @include('public.home._category_grid')

    <x-product.section
        :products="$hydrafacialProducts"
        title="HydraFacial Series"
        subtitle="Premium hydrafacial consumables and machines for your clinic"
        category-slug="hydrafacial"
        category-label="View All HydraFacial"
    />

    @include('public.home._aesthetic_categories', ['aestheticCategories' => $aestheticCategories])

    <x-product.section
        :products="$laserProducts"
        title="Laser Machines"
        subtitle="Advanced diode, IPL and CO2 laser machines for aesthetic clinics"
        category-slug="laser-machines"
        category-label="View All Lasers"
    />

    @include('public.home._reviews', ['featuredReviews' => $featuredReviews])
    @include('public.home._wholesale_cta')
@endsection
