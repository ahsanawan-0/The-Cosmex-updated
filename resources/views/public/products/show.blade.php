@extends('layouts.app')

@php
    $seoTitle = $product->seo_title ?: $product->name . ' - Wholesale Supplier Pakistan | Cosmex Pvt Ltd';
    $seoDesc  = $product->seo_description ?: 'Buy ' . $product->name . ' wholesale in Pakistan. Best price PKR ' . number_format($product->price) . '. Authentic clinic quality product. Inquire via WhatsApp.';
    $canonical = url('/products/' . $product->slug);
    $whatsappNum = preg_replace('/\D+/', '', \App\Models\Setting::get('whatsapp_number', '923001234567'));
    $waMsg = rawurlencode('Hi, I want a wholesale inquiry for: ' . $product->name . "\nPrice: PKR " . number_format($product->sale_price ?? $product->price) . "\nLink: " . $canonical);
    $waLink = 'https://wa.me/' . $whatsappNum . '?text=' . $waMsg;
    $phone  = \App\Models\Setting::get('contact_phone', '+923001234567');

    $allImages = [$product->main_image_url];
    if (!empty($product->gallery_images)) {
        foreach ($product->gallery_images as $gi) {
            $allImages[] = asset('storage/' . $gi);
        }
    }
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)
@section('canonical', $canonical)
@section('og_image', $product->main_image_url)
@section('og_type', 'product')

@section('schema')
[
  {
    "@@context": "https://schema.org",
    "@@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ strip_tags($product->short_description ?? '') }}",
    "image": ["{{ $product->main_image_url }}"],
    "brand": { "@type": "Brand", "name": "Cosmex Pvt Ltd" },
    "offers": {
      "@@type": "Offer",
      "priceCurrency": "PKR",
      "price": "{{ $product->sale_price ?? $product->price }}",
      "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
      "url": "{{ $canonical }}",
      "seller": { "@type": "Organization", "name": "Cosmex Pvt Ltd" }
    },
    "category": "{{ $product->category->name ?? '' }}"
  },
  {
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
      {"@@type":"ListItem","position":1,"name":"Home","item":"{{ url('/') }}"},
      {"@@type":"ListItem","position":2,"name":"{{ $product->category->name ?? 'Products' }}","item":"{{ $product->category ? url('/category/'.$product->category->slug) : url('/products') }}"},
      {"@@type":"ListItem","position":3,"name":"{{ $product->name }}","item":"{{ $canonical }}"}
    ]
  }
]
@endsection

@push('styles')
<style>
    .pdp-zoom-wrap { position: relative; overflow: hidden; cursor: crosshair; }
    .pdp-zoom-wrap img { transition: transform .3s ease; transform-origin: center center; }
    .pdp-zoom-wrap:hover img { transform: scale(1.8); }
    .pdp-thumb { border: 2px solid transparent; opacity: .68; transition: all .2s; border-radius: 16px; }
    .pdp-thumb:hover, .pdp-thumb.active { border-color: var(--color-primary); opacity: 1; }
    .pdp-lightbox { position: fixed; inset: 0; z-index: 999; background: rgba(0,0,0,.92); display: none; align-items: center; justify-content: center; }
    .pdp-lightbox.open { display: flex; }
    .pdp-lightbox img { max-height: 85vh; max-width: 85vw; object-fit: contain; }
    .pdp-lb-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); color: #fff; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; transition: background .2s; cursor: pointer; }
    .pdp-lb-btn:hover { background: rgba(255,255,255,.25); }
    .pdp-lb-close { position: absolute; top: 20px; right: 20px; background: none; border: none; color: #fff; font-size: 28px; cursor: pointer; z-index: 10; }
    .pdp-tab-btn { min-height: 48px; padding: 12px 20px; font-size: 13px; font-weight: 700; border-radius: 999px; color: var(--color-text-secondary); transition: all .2s; background: transparent; white-space: nowrap; }
    .pdp-tab-btn:hover { color: var(--color-primary); background: var(--color-bg-light); }
    .pdp-tab-btn.active { color: #fff; background: var(--color-primary); }
    .pdp-counter { display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 11px; background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); color: #fff; }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="border-b border-border bg-white">
        <div class="mx-auto max-w-[1180px] px-4 py-3 sm:px-6 lg:px-8">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => $product->category->name ?? 'Products', 'url' => $product->category ? route('category.show', $product->category->slug) : route('products.index')],
                ['label' => $product->name],
            ]" />
        </div>
    </div>

    {{-- ═══ MAIN PRODUCT ═══ --}}
    <section class="bg-bg-light py-8 lg:py-14">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-16">

                {{-- LEFT: Image Gallery --}}
                <div class="flex flex-col-reverse gap-4 sm:flex-row">
                    {{-- Vertical Thumbnails --}}
                    @if(count($allImages) > 1)
                    <div class="flex gap-2 sm:flex-col sm:gap-3 sm:w-[72px] shrink-0 overflow-x-auto sm:overflow-y-auto sm:max-h-[560px] hide-scrollbar">
                        @foreach($allImages as $idx => $imgUrl)
                        <button onclick="pdpSetImage({{ $idx }})"
                            class="pdp-thumb shrink-0 h-16 w-16 overflow-hidden bg-white shadow-sm sm:h-[68px] sm:w-[68px] {{ $idx === 0 ? 'active' : '' }}"
                            data-thumb-idx="{{ $idx }}">
                            <img src="{{ $imgUrl }}" alt="View {{ $idx+1 }}" class="w-full h-full object-cover" loading="lazy">
                        </button>
                        @endforeach
                    </div>
                    @endif

                    {{-- Main Image with Zoom --}}
                    <div class="flex-1">
                        <div class="pdp-zoom-wrap aspect-square cursor-pointer rounded-[28px] bg-gradient-to-br from-[#F3F9FF] via-white to-[#FFF1E8] shadow-card" onclick="pdpOpenLightbox()" onmousemove="pdpZoomMove(event)" onmouseleave="pdpZoomReset()">
                            <img id="pdp-main-img" src="{{ $allImages[0] }}" alt="{{ $product->name }}" class="h-full w-full object-contain p-5" loading="eager" fetchpriority="high">
                        </div>
                        <button onclick="pdpOpenLightbox()" class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-text-secondary transition hover:text-primary">
                            <i class="fa-solid fa-expand text-[10px]"></i> Click image to enlarge
                        </button>
                    </div>
                </div>

                {{-- RIGHT: Product Info --}}
                <div class="flex flex-col rounded-[28px] bg-white p-5 shadow-card sm:p-7 lg:p-8">
                    {{-- Category --}}
                    @if($product->category)
                    <a href="{{ route('category.show', $product->category->slug) }}"
                       class="inline-flex w-fit rounded-full bg-accent-soft px-3 py-1.5 text-[11px] font-bold uppercase text-accent transition hover:text-primary">
                        {{ $product->category->name }}
                    </a>
                    @endif

                    {{-- Name --}}
                    <h1 class="mt-4 font-heading text-2xl font-bold leading-snug text-text-primary sm:text-3xl lg:text-[36px]">{{ $product->name }}</h1>

                    {{-- Rating --}}
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star text-[12px] {{ $i <= $avgRating ? 'text-amber-400' : 'text-zinc-300' }}"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-zinc-400">{{ $reviews->count() > 0 ? $reviews->count() . ' review' . ($reviews->count() > 1 ? 's' : '') : 'No reviews yet' }}</span>
                    </div>

                    {{-- Price --}}
                    <div class="mt-5 flex flex-wrap items-baseline gap-3">
                        @if($product->is_on_sale)
                            <span class="font-heading text-3xl font-bold text-primary">PKR {{ number_format($product->sale_price) }}</span>
                            <span class="text-base text-zinc-400 line-through">PKR {{ number_format($product->price) }}</span>
                        @else
                            <span class="font-heading text-3xl font-bold text-primary">PKR {{ number_format($product->price) }}</span>
                        @endif
                    </div>

                    {{-- Availability --}}
                    <div class="mt-3">
                        @if($product->stock > 5)
                            <span class="inline-flex items-center gap-1.5 text-sm text-emerald-600">
                                <i class="fa-solid fa-circle-check text-xs"></i> In Stock
                            </span>
                        @elseif($product->stock > 0)
                            <span class="inline-flex items-center gap-1.5 text-sm text-amber-600">
                                <i class="fa-solid fa-triangle-exclamation text-xs"></i> Only {{ $product->stock }} left
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-sm text-red-500">
                                <i class="fa-solid fa-circle-xmark text-xs"></i> Out of Stock
                            </span>
                        @endif
                    </div>

                    {{-- Short Description --}}
                    @if($product->short_description)
                        <p class="mt-5 text-sm leading-7 text-text-secondary">{{ $product->short_description }}</p>
                    @endif

                    <div class="my-6 h-px bg-border"></div>

                    {{-- WhatsApp CTA --}}
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                       class="flex min-h-12 w-full items-center justify-center gap-3 rounded-full bg-primary px-6 text-sm font-bold uppercase text-white transition hover:bg-primary-dark active:scale-[.98]">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        Wholesale Inquiry
                    </a>

                    {{-- Call CTA --}}
                    <a href="tel:{{ $phone }}"
                       class="mt-3 flex min-h-12 w-full items-center justify-center gap-2 rounded-full border border-accent px-6 text-sm font-bold uppercase text-text-primary transition hover:bg-accent hover:text-white">
                        <i class="fa-solid fa-phone text-xs"></i>
                        Call for Inquiry
                    </a>

                    {{-- Share --}}
                    <div class="mt-5 flex items-center gap-3">
                        <span class="text-xs uppercase tracking-widest text-zinc-400">Share</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($canonical) }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-10 w-10 items-center justify-center rounded-full border border-border text-text-secondary transition hover:border-primary hover:text-primary">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-10 w-10 items-center justify-center rounded-full border border-border text-text-secondary transition hover:border-[#25D366] hover:text-[#25D366]">
                            <i class="fa-brands fa-whatsapp text-xs"></i>
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ $canonical }}').then(()=>{this.title='Copied!';setTimeout(()=>this.title='Copy Link',2000)})"
                           class="flex h-10 w-10 items-center justify-center rounded-full border border-border text-text-secondary transition hover:border-primary hover:text-primary" title="Copy Link">
                            <i class="fa-solid fa-link text-xs"></i>
                        </button>
                    </div>

                    {{-- Trust Badges --}}
                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <div class="flex flex-col items-center gap-1.5 rounded-2xl border border-border bg-bg-light p-3 text-center">
                            <i class="fa-solid fa-shield-halved text-base text-primary"></i>
                            <span class="text-[11px] font-semibold text-text-secondary">Clinic Quality</span>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-2xl border border-border bg-bg-light p-3 text-center">
                            <i class="fa-solid fa-truck-fast text-base text-primary"></i>
                            <span class="text-[11px] font-semibold text-text-secondary">Direct Imports</span>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-2xl border border-border bg-bg-light p-3 text-center">
                            <i class="fa-solid fa-user-doctor text-base text-primary"></i>
                            <span class="text-[11px] font-semibold text-text-secondary">Professional Use</span>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 rounded-2xl border border-border bg-bg-light p-3 text-center">
                            <i class="fa-solid fa-handshake text-base text-primary"></i>
                            <span class="text-[11px] font-semibold text-text-secondary">Trusted Supply</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ TABS ═══ --}}
    <section class="bg-bg-light py-10 lg:py-14">
        <div class="mx-auto max-w-[1180px] rounded-[28px] bg-white px-4 py-5 shadow-card sm:px-6 lg:px-8">
            <div class="flex gap-2 overflow-x-auto rounded-full bg-bg-light p-1 hide-scrollbar">
                <button onclick="pdpTab('description',this)" class="pdp-tab-btn active">Description</button>
                <button onclick="pdpTab('howto',this)" class="pdp-tab-btn">How to Use</button>
                <button onclick="pdpTab('delivery',this)" class="pdp-tab-btn">Delivery Info</button>
                <button onclick="pdpTab('reviews',this)" class="pdp-tab-btn">Reviews ({{ $reviews->count() }})</button>
            </div>

            <div id="pdp-panel-description" class="pdp-panel pt-8 prose prose-zinc max-w-none text-sm leading-7 text-text-secondary">
                @if($product->description)
                    {!! $product->description !!}
                @elseif($product->short_description)
                    <p>{{ $product->short_description }}</p>
                @else
                    <p class="text-zinc-400">No description available for this product yet.</p>
                @endif
            </div>

            <div id="pdp-panel-howto" class="pdp-panel hidden pt-8 text-sm leading-7 text-text-secondary">
                <p><strong>Professional-use notice:</strong> Cosmex imports directly and sells only to dermatologists and aestheticians. Products must be used or administered by qualified professionals. For clinical guidance or wholesale inquiries, please reach out to us on WhatsApp.</p>
            </div>

            <div id="pdp-panel-delivery" class="pdp-panel hidden pt-8">
                <ul class="space-y-4 text-sm text-text-secondary">
                    <li class="flex items-start gap-3"><i class="fa-solid fa-truck mt-0.5 text-zinc-400"></i><span><strong>Nationwide Delivery:</strong> 3–7 business days across Pakistan.</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-bolt mt-0.5 text-zinc-400"></i><span><strong>Lahore:</strong> Same day or next day delivery available.</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-money-bill mt-0.5 text-zinc-400"></i><span><strong>Payment:</strong> Cash on Delivery (COD) available nationwide.</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-box mt-0.5 text-zinc-400"></i><span><strong>Packaging:</strong> Products are carefully packed to ensure safe delivery.</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-rotate-left mt-0.5 text-zinc-400"></i><span><strong>Returns:</strong> Contact us within 3 days if there's an issue.</span></li>
                </ul>
            </div>

            {{-- Reviews Panel --}}
            <div id="pdp-panel-reviews" class="pdp-panel hidden pt-8">
                {{-- Success Message --}}
                @if(session('review_success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl bg-emerald-50 border border-emerald-200 p-4">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <p class="text-sm text-emerald-700">{{ session('review_success') }}</p>
                    </div>
                @endif

                {{-- Review Summary --}}
                @if($reviews->count() > 0)
                <div class="flex flex-col sm:flex-row gap-8 mb-10 p-6 bg-zinc-50 rounded-2xl border border-zinc-100">
                    <div class="text-center shrink-0">
                        <div class="text-5xl font-bold text-zinc-900 font-heading">{{ number_format($avgRating, 1) }}</div>
                        <div class="flex justify-center gap-0.5 mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star text-sm {{ $i <= $avgRating ? 'text-amber-400' : 'text-zinc-300' }}"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">{{ $reviews->count() }} review{{ $reviews->count() > 1 ? 's' : '' }}</p>
                    </div>
                    <div class="flex-1 space-y-2">
                        @for($star = 5; $star >= 1; $star--)
                            @php $count = $reviews->where('rating', $star)->count(); $pct = $reviews->count() > 0 ? ($count / $reviews->count()) * 100 : 0; @endphp
                            <div class="flex items-center gap-3 text-xs">
                                <span class="w-4 text-right text-zinc-500">{{ $star }}</span>
                                <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                                <div class="flex-1 h-2 bg-zinc-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="w-6 text-zinc-400">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
                @endif

                {{-- Reviews List --}}
                @if($reviews->count() > 0)
                    <div class="space-y-6 mb-10">
                        @foreach($reviews as $review)
                        <div class="flex flex-col gap-3 p-5 rounded-xl border border-zinc-100 bg-white">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                        <span class="text-sm font-bold text-primary uppercase">{{ substr($review->reviewer_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-900">{{ $review->reviewer_name }}</p>
                                        <p class="text-[11px] text-zinc-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-0.5 shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-[11px] {{ $i <= $review->rating ? 'text-amber-400' : 'text-zinc-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-zinc-600 leading-relaxed">{{ $review->body }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-zinc-400 mb-8">
                        <i class="fa-regular fa-comment-dots text-4xl mb-3"></i>
                        <p class="text-sm">No reviews yet. Be the first to leave a review!</p>
                    </div>
                @endif

                {{-- Submit Review Form --}}
                <div class="rounded-2xl border border-border bg-bg-light p-6 lg:p-8">
                    <h3 class="text-lg font-bold text-zinc-900 mb-6 font-heading">Write a Review</h3>
                    <form action="{{ route('reviews.store', $product->slug) }}" method="POST" class="space-y-5">
                        @csrf
                        {{-- Star Rating Picker --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-zinc-500 mb-2">Your Rating</label>
                            <div class="flex gap-2" id="star-picker">
                                @for($s = 1; $s <= 5; $s++)
                                    <button type="button" onclick="setRating({{ $s }})" data-star="{{ $s }}"
                                        class="star-btn text-2xl text-zinc-300 hover:text-amber-400 transition-colors">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="5">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-zinc-500 mb-2">Your Name *</label>
                                <input type="text" name="reviewer_name" required
                                    value="{{ old('reviewer_name') }}"
                                    placeholder="Dr. John Smith"
                                    class="min-h-12 w-full rounded-2xl border border-border px-4 text-sm text-zinc-900 placeholder-zinc-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/10">
                                @error('reviewer_name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-zinc-500 mb-2">Email (optional)</label>
                                <input type="email" name="reviewer_email"
                                    value="{{ old('reviewer_email') }}"
                                    placeholder="your@email.com"
                                    class="min-h-12 w-full rounded-2xl border border-border px-4 text-sm text-zinc-900 placeholder-zinc-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/10">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-zinc-500 mb-2">Your Review *</label>
                            <textarea name="body" required rows="4"
                                placeholder="Share your experience with this product..."
                                class="w-full resize-none rounded-2xl border border-border px-4 py-3 text-sm text-zinc-900 placeholder-zinc-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/10">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex min-h-12 items-center gap-2 rounded-full bg-primary px-8 text-sm font-bold uppercase text-white transition-all duration-200 hover:bg-primary-dark active:scale-[.98]">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ RELATED ═══ --}}
    @if($relatedProducts->count())
    <section class="bg-bg-light py-14 lg:py-20">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <p class="text-center text-[11px] font-bold uppercase text-accent">Related Products</p>
            <h2 class="mt-2 text-center font-heading text-2xl font-bold text-text-primary sm:text-3xl">You May Also Like</h2>
            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6 lg:gap-5">
                @foreach($relatedProducts as $related)
                    <x-product.card :product="$related" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ LIGHTBOX ═══ --}}
    <div id="pdp-lightbox" class="pdp-lightbox" onclick="if(event.target===this)pdpCloseLightbox()">
        <button class="pdp-lb-close" onclick="pdpCloseLightbox()" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        <button class="pdp-lb-btn" style="left:16px" onclick="pdpLbPrev()"><i class="fa-solid fa-chevron-left"></i></button>
        <img id="pdp-lb-img" src="" alt="Product image">
        <button class="pdp-lb-btn" style="right:16px" onclick="pdpLbNext()"><i class="fa-solid fa-chevron-right"></i></button>
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2">
            <span id="pdp-lb-counter" class="pdp-counter"></span>
        </div>
    </div>

<script>
(function(){
    var imgs = @json($allImages);
    var cur = 0;
    window.pdpSetImage = function(i){
        cur = i;
        document.getElementById('pdp-main-img').src = imgs[i];
        document.querySelectorAll('.pdp-thumb').forEach(function(t,idx){ t.classList.toggle('active', idx===i); });
    };
    window.pdpOpenLightbox = function(){
        var lb = document.getElementById('pdp-lightbox');
        document.getElementById('pdp-lb-img').src = imgs[cur];
        document.getElementById('pdp-lb-counter').textContent = (cur+1)+' / '+imgs.length;
        lb.classList.add('open');
        document.body.style.overflow='hidden';
    };
    window.pdpCloseLightbox = function(){
        document.getElementById('pdp-lightbox').classList.remove('open');
        document.body.style.overflow='';
    };
    window.pdpLbNext = function(){ cur=(cur+1)%imgs.length; pdpSetImage(cur); document.getElementById('pdp-lb-img').src=imgs[cur]; document.getElementById('pdp-lb-counter').textContent=(cur+1)+' / '+imgs.length; };
    window.pdpLbPrev = function(){ cur=(cur-1+imgs.length)%imgs.length; pdpSetImage(cur); document.getElementById('pdp-lb-img').src=imgs[cur]; document.getElementById('pdp-lb-counter').textContent=(cur+1)+' / '+imgs.length; };
    document.addEventListener('keydown',function(e){ if(!document.getElementById('pdp-lightbox').classList.contains('open'))return; if(e.key==='Escape')pdpCloseLightbox(); if(e.key==='ArrowRight')pdpLbNext(); if(e.key==='ArrowLeft')pdpLbPrev(); });

    // Zoom
    var wrap = document.querySelector('.pdp-zoom-wrap');
    var mImg = document.getElementById('pdp-main-img');
    window.pdpZoomMove = function(e){ var r=wrap.getBoundingClientRect(); var x=((e.clientX-r.left)/r.width)*100; var y=((e.clientY-r.top)/r.height)*100; mImg.style.transformOrigin=x+'% '+y+'%'; };
    window.pdpZoomReset = function(){ mImg.style.transformOrigin='center center'; };

    // Tabs
    window.pdpTab = function(name,btn){
        document.querySelectorAll('.pdp-panel').forEach(function(p){p.classList.add('hidden');});
        document.querySelectorAll('.pdp-tab-btn').forEach(function(b){b.classList.remove('active');});
        document.getElementById('pdp-panel-'+name).classList.remove('hidden');
        btn.classList.add('active');
    };

    // Star Rating Picker
    window.setRating = function(val){
        document.getElementById('rating-input').value = val;
        document.querySelectorAll('.star-btn').forEach(function(btn){
            var star = parseInt(btn.getAttribute('data-star'));
            btn.style.color = star <= val ? '#fbbf24' : '';
            btn.classList.toggle('text-amber-400', star <= val);
            btn.classList.toggle('text-zinc-300', star > val);
        });
    };
    // Init star picker at 5
    document.addEventListener('DOMContentLoaded', function(){ if(window.setRating) setRating(5); });
})();
</script>
@endsection
