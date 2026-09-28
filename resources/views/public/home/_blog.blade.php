{{-- Latest guides: internal links from the homepage to the blog --}}
@if (isset($latestPosts) && $latestPosts->isNotEmpty())
    <section class="bg-bg-light py-10 lg:py-16">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-2 text-[11px] font-semibold uppercase text-primary">Buying Guides</p>
                    <h2 class="font-heading text-2xl font-bold tracking-normal text-text-primary lg:text-3xl">Guides for Aesthetic Clinics</h2>
                    <p class="mt-2 text-sm text-text-secondary">Machine price guides and comparisons, with prices that update from our catalogue.</p>
                </div>
                <a href="{{ route('blog.index') }}"
                   class="inline-flex min-h-12 items-center gap-2 rounded-2xl bg-white px-4 text-sm font-semibold text-primary shadow-sm transition active:scale-95">
                    All Guides
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latestPosts as $post)
                    <x-blog.card :post="$post" heading-level="h3" />
                @endforeach
            </div>
        </div>
    </section>
@endif
