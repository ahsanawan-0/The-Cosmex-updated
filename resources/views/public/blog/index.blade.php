@extends('layouts.app')

@php
    $blogUrl = route('blog.index');
    $pageCanonical = $posts->currentPage() > 1 ? $blogUrl . '?page=' . $posts->currentPage() : $blogUrl;
    $listSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        '@id' => $blogUrl . '#blog',
        'name' => config('site.name') . ' Guides',
        'url' => $blogUrl,
        'publisher' => ['@id' => \App\Helpers\SeoHelper::organizationId()],
        'blogPost' => $posts->getCollection()->map(fn ($post) => [
            '@type' => 'BlogPosting',
            'headline' => \App\Helpers\SeoHelper::clean($post->title),
            'url' => route('blog.show', $post->slug),
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'image' => $post->cover_url,
        ])->values()->all(),
    ];
@endphp

@section('title', 'Aesthetic Machine Price Guides & Clinic Tips' . ($posts->currentPage() > 1 ? ' – Page ' . $posts->currentPage() : ''))
@section('meta_description', 'Buying guides for aesthetic clinics in Pakistan: hydrafacial, diode laser, HIFU and microneedling pen prices, model comparisons and clinic set-up checklists.')
@section('canonical', $pageCanonical)

@section('schema')
{!! \App\Helpers\SeoHelper::json($listSchema) !!}
@endsection

@section('content')
    <div class="border-b border-border bg-white">
        <div class="mx-auto max-w-[1180px] px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Blog', 'url' => $blogUrl],
            ]" />
            <h1 class="mt-4 font-heading text-3xl font-bold text-text-primary sm:text-4xl">Guides for Aesthetic Clinics</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-text-secondary">
                Price guides, model comparisons and practical checklists for clinics and salons buying aesthetic machines in Pakistan. Prices in every guide update automatically from our catalogue.
            </p>
        </div>
    </div>

    <section class="bg-bg-light py-10 lg:py-14">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            @if ($posts->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-blog.card :post="$post" />
                    @endforeach
                </div>

                @if ($posts->hasPages())
                    <nav class="mt-10 flex justify-center gap-3" aria-label="Pagination">
                        @unless ($posts->onFirstPage())
                            <a href="{{ $posts->currentPage() === 2 ? $blogUrl : $posts->previousPageUrl() }}" rel="prev" class="btn-primary text-sm">Newer guides</a>
                        @endunless
                        @if ($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" rel="next" class="btn-primary text-sm">Older guides</a>
                        @endif
                    </nav>
                @endif
            @else
                <p class="text-center text-text-secondary">New guides are coming soon.</p>
            @endif
        </div>
    </section>
@endsection
