@props([
    'title',
    'description',
    'canonical',
    'robots' => 'index, follow, max-image-preview:large',
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">
