@props([
    'title',
    'description',
    'canonical',
    'keywords' => '',
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $canonical }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="Cosmex Pvt Ltd">
