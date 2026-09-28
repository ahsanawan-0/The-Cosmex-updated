@php
    $editing = isset($category);
    $category = $category ?? null;
    $slugValue = old('slug', data_get($category, 'slug', ''));
@endphp

<div class="mx-auto max-w-4xl rounded-3xl border border-zinc-200 bg-white p-8 shadow-sm">
    <div class="grid gap-6 md:grid-cols-2">
        <div class="md:col-span-1">
            <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">Category Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', data_get($category, 'name')) }}" required data-slug-source class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
        </div>

        <div class="md:col-span-1">
            <label for="parent_id" class="mb-2 block text-sm font-medium text-zinc-700">Parent Category (Optional)</label>
            <select id="parent_id" name="parent_id" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                <option value="">None (Top Level)</option>
                @foreach(isset($parents) ? $parents : [] as $parent)
                    <option value="{{ $parent->id }}" @selected(old('parent_id', data_get($category, 'parent_id')) == $parent->id)>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="slug" class="mb-2 block text-sm font-medium text-zinc-700">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ $slugValue }}" data-slug-target class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
            <p class="mt-2 text-sm text-zinc-500">Preview: <span data-slug-preview>{{ url('/category').'/'.($slugValue !== '' ? $slugValue : 'your-category-slug') }}</span></p>
        </div>

        <div class="md:col-span-2">
            <label for="description" class="mb-2 block text-sm font-medium text-zinc-700">Description</label>
            <textarea id="description" name="description" rows="5" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">{{ old('description', data_get($category, 'description')) }}</textarea>
            <p class="mt-1.5 text-xs text-zinc-400">Short plain-text introduction shown in the blue header under the category name (1–2 sentences). Use the buying guide below for formatted content.</p>
        </div>

        <div class="md:col-span-2 rounded-2xl border border-zinc-200 bg-zinc-50 p-5 space-y-5">
            <p class="text-sm font-semibold text-zinc-800">Search engine settings <span class="font-normal text-zinc-500">(leave blank to use the built-in defaults)</span></p>
            <div>
                <label for="seo_title" class="mb-2 block text-sm font-medium text-zinc-700">SEO title <span class="text-zinc-400 font-normal">(max 70; the site name is added automatically when it fits)</span></label>
                <input id="seo_title" name="seo_title" type="text" maxlength="70" value="{{ old('seo_title', data_get($category, 'seo_title')) }}" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>
            <div>
                <label for="seo_description" class="mb-2 block text-sm font-medium text-zinc-700">Meta description <span class="text-zinc-400 font-normal">(140–160 characters, end with a full sentence)</span></label>
                <textarea id="seo_description" name="seo_description" rows="3" maxlength="170" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">{{ old('seo_description', data_get($category, 'seo_description')) }}</textarea>
            </div>
            <div>
                <label for="content" class="mb-2 block text-sm font-medium text-zinc-700">Buying guide <span class="text-zinc-400 font-normal">(shown below the products; paste or type with headings, lists and tables)</span></label>
                <textarea id="content" name="content" rows="10" data-rich-editor data-height="420" data-upload-folder="categories" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">{{ old('content', data_get($category, 'content')) }}</textarea>
            </div>
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-medium text-zinc-700">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', data_get($category, 'sort_order', 0)) }}" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
        </div>

        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-zinc-700">Status</label>
            <select id="status" name="status" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                <option value="active" @selected(old('status', data_get($category, 'status', 'active')) === 'active')>Active</option>
                <option value="inactive" @selected(old('status', data_get($category, 'status', 'active')) === 'inactive')>Inactive</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-zinc-700">Category Image</label>
            <label class="flex min-h-56 cursor-pointer flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-8 text-center">
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" data-image-input class="hidden">
                <img src="{{ data_get($category, 'image_url', asset('images/placeholder-category.webp')) }}" alt="Category preview" data-image-preview class="mb-4 h-32 w-32 rounded-3xl border border-zinc-200 object-cover">
                <span class="text-sm font-medium text-zinc-700">Upload category image</span>
            </label>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 transition hover:border-zinc-400">Cancel</a>
        <button type="submit" class="inline-flex items-center rounded-2xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-opacity-90">{{ $submitLabel }}</button>
    </div>
</div>

@push('scripts')
    <script>
        (() => {
            const slugify = (value) => value.toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            const nameInput = document.querySelector('[data-slug-source]');
            const slugInput = document.querySelector('[data-slug-target]');
            const slugPreview = document.querySelector('[data-slug-preview]');
            const imageInput = document.querySelector('[data-image-input]');
            const imagePreview = document.querySelector('[data-image-preview]');
            let manual = Boolean(slugInput?.value);

            const updatePreview = () => {
                if (slugPreview && slugInput) slugPreview.textContent = `{{ url('/category') }}/${slugInput.value || 'your-category-slug'}`;
            };

            nameInput?.addEventListener('input', () => {
                if (!manual && slugInput) {
                    slugInput.value = slugify(nameInput.value);
                    updatePreview();
                }
            });

            slugInput?.addEventListener('input', () => {
                manual = slugInput.value.trim() !== '';
                slugInput.value = slugify(slugInput.value);
                updatePreview();
            });

            imageInput?.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (file && imagePreview) imagePreview.src = URL.createObjectURL(file);
            });

            updatePreview();
        })();
    </script>
@endpush

@include('admin.partials.rich-editor')
