<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
@php
/** @var \Illuminate\Support\Collection $products */
/** @var \Illuminate\Support\Collection $categories */
/** @var array $pages */
@endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['loc'] }}</loc>
        <lastmod>{{ $page['lastmod'] }}</lastmod>
        @foreach ($page['videos'] ?? [] as $video)
        <video:video>
            <video:thumbnail_loc>{{ asset('images/videos/' . $video['file'] . '.webp') }}</video:thumbnail_loc>
            <video:title>{{ $video['title'] }}</video:title>
            <video:description>{{ $video['description'] }}</video:description>
            <video:content_loc>{{ asset('videos/' . $video['file'] . '.mp4') }}</video:content_loc>
            <video:duration>{{ $video['duration'] }}</video:duration>
            <video:publication_date>{{ $video['uploaded'] }}</video:publication_date>
        </video:video>
        @endforeach
    </url>
    @endforeach

    @foreach($posts as $post)
    <url>
        <loc>{{ route('blog.show', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->toDateString() }}</lastmod>
        <image:image>
            <image:loc>{{ $post->cover_url }}</image:loc>
        </image:image>
    </url>
    @endforeach

    @foreach($categories as $category)
    <url>
        <loc>{{ url('/category/' . $category->slug) }}</loc>
        <lastmod>{{ $category->updated_at->toDateString() }}</lastmod>
    </url>
    @endforeach

    @foreach($products as $product)
    <url>
        <loc>{{ url('/products/' . $product->slug) }}</loc>
        <lastmod>{{ $product->updated_at->toDateString() }}</lastmod>
        @if ($product->main_image)
        <image:image>
            <image:loc>{{ $product->main_image_url }}</image:loc>
        </image:image>
        @endif
    </url>
    @endforeach
</urlset>
