@php
    $input = 'block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10';
    $publishedAt = old('published_at', optional(data_get($post, 'published_at'))->format('Y-m-d\TH:i'));
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
    <div class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <label for="title" class="mb-2 block text-sm font-medium text-zinc-700">Title (shown as the H1)</label>
            <input id="title" name="title" type="text" required value="{{ old('title', data_get($post, 'title')) }}" class="{{ $input }}">
        </div>
        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-zinc-700">URL slug <span class="font-normal text-zinc-400">(leave blank to create from the title; avoid changing it after publishing)</span></label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', data_get($post, 'slug')) }}" class="{{ $input }}">
        </div>
        <div>
            <label for="excerpt" class="mb-2 block text-sm font-medium text-zinc-700">Summary <span class="font-normal text-zinc-400">(1–2 sentences, shown under the title and on blog cards)</span></label>
            <textarea id="excerpt" name="excerpt" rows="3" maxlength="400" class="{{ $input }}">{{ old('excerpt', data_get($post, 'excerpt')) }}</textarea>
        </div>
        <div>
            <label for="body" class="mb-2 block text-sm font-medium text-zinc-700">Article</label>
            <textarea id="body" name="body" rows="24" data-rich-editor data-height="680" data-upload-folder="blog" class="{{ $input }}">{{ old('body', data_get($post, 'body')) }}</textarea>
        </div>
        <details class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-4 text-sm text-zinc-600">
            <summary class="cursor-pointer font-semibold text-zinc-800">Live price shortcodes (type them on their own line)</summary>
            <ul class="mt-3 space-y-1.5">
                <li><code>[[products:hifu-7d,hifu-9d]]</code> table of those products with live prices and stock</li>
                <li><code>[[price:hifu-7d]]</code> one product's current price, e.g. "PKR 460,000"</li>
                <li><code>[[range:hydrafacial]]</code> lowest to highest price in a category</li>
                <li><code>[[total:dr-pen-a6,led-light-mask]]</code> total price of several products</li>
                <li><code>[[video:hifu-machine]]</code> one of the homepage videos</li>
                <li><code>[[cta]]</code> WhatsApp call-to-action box</li>
            </ul>
            <p class="mt-3">Use product and category slugs from their URLs. Headings: use "Heading 2" for main sections (they form the table of contents) and "Heading 3" inside them.</p>
        </details>
    </div>

    <div class="space-y-6">
        <div class="space-y-5 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
            <div>
                <label for="status" class="mb-2 block text-sm font-medium text-zinc-700">Status</label>
                <select id="status" name="status" class="{{ $input }}">
                    <option value="draft" @selected(old('status', data_get($post, 'status', 'draft')) === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', data_get($post, 'status')) === 'published')>Published</option>
                </select>
            </div>
            <div>
                <label for="published_at" class="mb-2 block text-sm font-medium text-zinc-700">Publish date <span class="font-normal text-zinc-400">(blank = now)</span></label>
                <input id="published_at" name="published_at" type="datetime-local" value="{{ $publishedAt }}" class="{{ $input }}">
            </div>
            <div>
                <label for="category_slug" class="mb-2 block text-sm font-medium text-zinc-700">Related category</label>
                <select id="category_slug" name="category_slug" class="{{ $input }}">
                    <option value="">None</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(old('category_slug', data_get($post, 'category_slug')) === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-zinc-400">The post is linked from that category's page and shows its products.</p>
            </div>
            <div>
                <label for="author_name" class="mb-2 block text-sm font-medium text-zinc-700">Author</label>
                <input id="author_name" name="author_name" type="text" value="{{ old('author_name', data_get($post, 'author_name')) }}" placeholder="{{ config('site.name') }} Team" class="{{ $input }}">
            </div>
            <div>
                <label for="cover" class="mb-2 block text-sm font-medium text-zinc-700">Cover image <span class="font-normal text-zinc-400">(1200 × 630)</span></label>
                @if (data_get($post, 'cover_image'))
                    <img src="{{ $post->cover_url }}" alt="" class="mb-3 w-full rounded-xl border border-zinc-200">
                @endif
                <input id="cover" name="cover" type="file" accept=".jpg,.jpeg,.png,.webp" class="block w-full text-sm">
            </div>
        </div>

        <div class="space-y-5 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-zinc-800">Search engine settings</p>
            <div>
                <label for="seo_title" class="mb-2 block text-sm font-medium text-zinc-700">SEO title <span class="font-normal text-zinc-400">(max 70)</span></label>
                <input id="seo_title" name="seo_title" type="text" maxlength="70" value="{{ old('seo_title', data_get($post, 'seo_title')) }}" class="{{ $input }}">
            </div>
            <div>
                <label for="seo_description" class="mb-2 block text-sm font-medium text-zinc-700">Meta description <span class="font-normal text-zinc-400">(140–160 characters)</span></label>
                <textarea id="seo_description" name="seo_description" rows="4" maxlength="170" class="{{ $input }}">{{ old('seo_description', data_get($post, 'seo_description')) }}</textarea>
            </div>
        </div>

        <button type="submit" class="w-full rounded-lg bg-primary px-5 py-3 text-sm font-bold uppercase tracking-widest text-white shadow-sm transition hover:bg-opacity-90">{{ $submitLabel }}</button>
    </div>
</div>

@include('admin.partials.rich-editor')
