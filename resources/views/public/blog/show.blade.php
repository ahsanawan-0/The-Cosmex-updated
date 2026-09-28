@extends('layouts.app')

@php
    $postUrl = route('blog.show', $post->slug);
@endphp

@section('title', $post->seo_title ?: $post->title)
@section('meta_description', $post->seo_description ?: $post->excerpt)
@section('canonical', $postUrl)
@section('og_image', $post->cover_url)
@section('og_type', 'article')

@push('head')
    @if ($post->published_at)
        <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
    @endif
    <meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@section('schema')
{!! \App\Helpers\SeoHelper::json($schema) !!}
@endsection

@section('content')
    <article>
        <header class="border-b border-border bg-white">
            <div class="mx-auto max-w-[860px] px-4 py-8 sm:px-6 lg:py-12">
                <x-breadcrumb :items="[
                    ['label' => 'Home', 'url' => route('home')],
                    ['label' => 'Blog', 'url' => route('blog.index')],
                    ['label' => $post->title, 'url' => $postUrl],
                ]" />
                @if ($category)
                    <a href="{{ route('category.show', $category->slug) }}" class="mt-5 inline-flex rounded-full bg-accent-soft px-3 py-1.5 text-[11px] font-bold uppercase text-accent hover:text-primary">{{ $category->name }}</a>
                @endif
                <h1 class="mt-4 font-heading text-3xl font-bold leading-tight text-text-primary sm:text-4xl">{{ $post->title }}</h1>
                @if ($post->excerpt)
                    <p class="mt-4 text-lg leading-8 text-text-secondary">{{ $post->excerpt }}</p>
                @endif
                <p class="mt-5 flex flex-wrap gap-x-4 gap-y-1 text-sm text-text-secondary">
                    <span>By <a href="{{ route('about') }}" class="font-semibold text-text-primary hover:text-primary">{{ $post->author }}</a></span>
                    <span>Updated <time datetime="{{ $post->updated_at->toDateString() }}">{{ $post->updated_at->format('j F Y') }}</time></span>
                    <span>{{ $post->reading_minutes }} min read</span>
                </p>
            </div>
            <div class="mx-auto max-w-[1000px] px-4 pb-8 sm:px-6">
                <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" width="1200" height="630" fetchpriority="high"
                    class="w-full rounded-3xl object-cover shadow-card">
            </div>
        </header>

        <div class="bg-bg-light py-10 lg:py-14">
            <div class="mx-auto max-w-[860px] px-4 sm:px-6">
                @if (count($toc) > 2)
                    <nav aria-label="In this guide" class="mb-10 rounded-2xl border border-border bg-white p-5 shadow-card">
                        <p class="text-sm font-bold uppercase tracking-wide text-text-primary">In this guide</p>
                        <ol class="mt-3 grid gap-2 text-sm sm:grid-cols-2">
                            @foreach ($toc as $i => $item)
                                <li><a href="#{{ $item['id'] }}" class="text-primary hover:underline">{{ $i + 1 }}. {{ $item['text'] }}</a></li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                <div class="prose prose-zinc max-w-none prose-headings:font-heading prose-headings:scroll-mt-40 prose-h2:mt-12 prose-h2:text-2xl prose-h3:text-lg prose-a:text-primary prose-table:text-sm prose-img:rounded-2xl">
                    {!! $html !!}
                </div>

                <aside class="mt-12 rounded-2xl border border-border bg-white p-6 shadow-card">
                    <p class="font-heading text-lg font-bold text-text-primary">About the author</p>
                    <p class="mt-2 text-sm leading-6 text-text-secondary">
                        Written by the product team at <a href="{{ route('about') }}" class="font-semibold text-primary hover:underline">{{ config('site.name') }}</a>, importers of aesthetic machines and clinic products for dermatologists, clinics and salons across Pakistan, based in Johar Town, Lahore.
                        Questions about a machine? <a href="{{ route('contact') }}" class="font-semibold text-primary hover:underline">Contact our team</a>.
                    </p>
                    <p class="mt-4 text-xs leading-5 text-zinc-500">
                        Prices in this guide come live from our catalogue and can change; confirm them before ordering. This is general buying information, not medical advice: treatments should be carried out by qualified, trained practitioners following the manufacturer's instructions. Brand names are trademarks of their respective owners.
                    </p>
                </aside>
            </div>
        </div>
    </article>

    @if ($relatedProducts->isNotEmpty())
        <section class="bg-white py-12 lg:py-16">
            <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <h2 class="font-heading text-2xl font-bold text-text-primary">{{ $category->name }} in our catalogue</h2>
                    <a href="{{ route('category.show', $category->slug) }}" class="text-sm font-semibold text-primary hover:underline">See all {{ $category->name }} →</a>
                </div>
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-6">
                    @foreach ($relatedProducts as $product)
                        <x-product.card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($relatedPosts->isNotEmpty())
        <section class="bg-bg-light py-12 lg:py-16">
            <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
                <h2 class="mb-6 font-heading text-2xl font-bold text-text-primary">More guides</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedPosts as $related)
                        <x-blog.card :post="$related" heading-level="h3" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
