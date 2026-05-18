@extends('layouts.app')
@section('title', '404 - Page Not Found | Cosmex Pvt Ltd')
@section('content')
    <div class="flex min-h-[70vh] flex-col items-center justify-center bg-bg-light px-4 py-24 text-center">
        <p class="font-heading text-[10rem] leading-none text-primary opacity-20 select-none">404</p>
        <div class="-mt-8">
            <h1 class="font-heading text-4xl text-zinc-900 sm:text-5xl">Page Not Found</h1>
            <p class="mx-auto mt-4 max-w-md text-base text-zinc-500">
                The page you're looking for doesn't exist or may have been moved. Let's get you back on track.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                <a href="{{ route('home') }}" class="btn-primary inline-flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/></svg>
                    Go to Home
                </a>
                <a href="{{ route('products.index') }}" class="btn-outline-primary inline-flex items-center justify-center">Browse Products</a>
            </div>
        </div>
    </div>
@endsection
