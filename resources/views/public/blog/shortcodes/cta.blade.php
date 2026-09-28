@php
    $number = preg_replace('/\D+/', '', (string) \App\Models\Setting::get('whatsapp_number'));
    $message = rawurlencode('Hi, I read your guide "' . $post->title . '" and would like prices and availability.');
@endphp
<div class="not-prose my-8 flex flex-col gap-4 rounded-2xl bg-primary px-6 py-6 text-white sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="font-heading text-lg font-bold">Want current prices or stock?</p>
        <p class="mt-1 text-sm text-white/85">Send us the model name on WhatsApp. We deliver across Pakistan from our Johar Town, Lahore office.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="https://wa.me/{{ $number }}?text={{ $message }}" target="_blank" rel="noopener noreferrer"
            class="inline-flex min-h-11 items-center gap-2 rounded-full bg-white px-5 text-sm font-bold text-primary transition hover:bg-white/90">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> WhatsApp us
        </a>
        @if ($category)
            <a href="{{ route('category.show', $category->slug) }}"
                class="inline-flex min-h-11 items-center gap-2 rounded-full border border-white/60 px-5 text-sm font-bold text-white transition hover:bg-white/10">
                See all {{ $category->name }}
            </a>
        @endif
    </div>
</div>
