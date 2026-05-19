@php
    $editing = isset($product);
    $product = $product ?? null;
    $selectedStatus = old('status', data_get($product, 'status', 'active'));
    $slugValue = old('slug', data_get($product, 'slug', ''));
    $productUrlPreview = url('/products').'/'.($slugValue !== '' ? $slugValue : 'your-product-slug');
    $galleryImages = data_get($product, 'gallery_images', []);
@endphp

<div class="grid gap-6 xl:grid-cols-[minmax(0,1.9fr)_minmax(320px,1.1fr)]">
    <div class="space-y-6">
        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-zinc-900">Basic Info</h2>
                <p class="mt-1 text-sm text-zinc-500">Set the product name, slug, category, and descriptions.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">Product Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', data_get($product, 'name')) }}" required data-slug-source class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                </div>

                <div class="md:col-span-2">
                    <div class="mb-2 flex items-center justify-between">
                        <label for="subtitle" class="text-sm font-medium text-zinc-700">Subtitle <span class="text-zinc-400 font-normal">(optional)</span></label>
                        <span class="text-xs text-zinc-500"><span data-char-count="subtitle">{{ strlen((string) old('subtitle', data_get($product, 'subtitle'))) }}</span>/150</span>
                    </div>
                    <input id="subtitle" name="subtitle" type="text" maxlength="150" value="{{ old('subtitle', data_get($product, 'subtitle')) }}" placeholder="e.g. Dual Pump, Professional Grade, 7-in-1 System" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                    <p class="mt-1.5 text-xs text-zinc-400">Shown below the product name on cards. Keep it short and descriptive.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="slug" class="mb-2 block text-sm font-medium text-zinc-700">Slug</label>
                    <input id="slug" name="slug" type="text" value="{{ $slugValue }}" data-slug-target class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                    <p class="mt-2 text-sm text-zinc-500">Preview: <span data-slug-preview>{{ $productUrlPreview }}</span></p>
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-medium text-zinc-700">Category</label>
                    <select id="category_id" name="category_id" required class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ data_get($category, 'id') }}" @selected((string) old('category_id', data_get($product, 'category_id')) === (string) data_get($category, 'id'))>
                                {{ data_get($category, 'name') }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div>
                    <label for="stock" class="mb-2 block text-sm font-medium text-zinc-700">Stock Quantity</label>
                    <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', data_get($product, 'stock', 0)) }}" required class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                </div>

                <div class="md:col-span-2">
                    <label for="short_description" class="mb-2 block text-sm font-medium text-zinc-700">Short Description</label>
                    <textarea id="short_description" name="short_description" rows="3" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">{{ old('short_description', data_get($product, 'short_description')) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="mb-2 block text-sm font-medium text-zinc-700">Full Description</label>
                    <textarea id="description" name="description" rows="8" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">{{ old('description', data_get($product, 'description')) }}</textarea>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <details class="group" open>
                <summary class="flex cursor-pointer list-none items-center justify-between text-xl font-semibold text-zinc-900">
                    SEO Section
                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-500 group-open:hidden">Expand</span>
                    <span class="hidden rounded-full bg-[#D4AF37]/10 px-3 py-1 text-xs font-medium text-[#8f6b08] group-open:inline-flex">Open</span>
                </summary>

                <div class="mt-6 space-y-5">
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="seo_title" class="text-sm font-medium text-zinc-700">SEO Title</label>
                            <span class="text-xs text-zinc-500"><span data-char-count="seo_title">{{ strlen((string) old('seo_title', data_get($product, 'seo_title'))) }}</span>/70</span>
                        </div>
                        <input id="seo_title" name="seo_title" type="text" maxlength="70" value="{{ old('seo_title', data_get($product, 'seo_title')) }}" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="seo_description" class="text-sm font-medium text-zinc-700">SEO Meta Description</label>
                            <span class="text-xs text-zinc-500"><span data-char-count="seo_description">{{ strlen((string) old('seo_description', data_get($product, 'seo_description'))) }}</span>/160</span>
                        </div>
                        <textarea id="seo_description" name="seo_description" rows="4" maxlength="160" class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">{{ old('seo_description', data_get($product, 'seo_description')) }}</textarea>
                    </div>

                    <div class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.22em] text-zinc-500">Canonical URL Preview</p>
                        <p class="mt-2 break-all text-sm text-zinc-700" data-canonical-preview>{{ $productUrlPreview }}</p>
                    </div>
                </div>
            </details>
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">Pricing</h2>
            <div class="mt-5 space-y-4">
                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-zinc-700">Price (PKR)</label>
                    <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', data_get($product, 'price')) }}" required data-price-input class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                </div>
                <div>
                    <label for="sale_price" class="mb-2 block text-sm font-medium text-zinc-700">Sale Price (PKR)</label>
                    <input id="sale_price" name="sale_price" type="number" min="0" step="0.01" value="{{ old('sale_price', data_get($product, 'sale_price')) }}" data-sale-price-input class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10">
                </div>
                <div class="rounded-2xl bg-zinc-50 px-4 py-3 text-sm text-zinc-600">
                    Discount: <span data-discount-output class="font-semibold text-[#8f6b08]">—</span>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">Visibility</h2>
            <div class="mt-5 space-y-4">
                <div>
                    <p class="mb-3 text-sm font-medium text-zinc-700">Status</p>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer sr-only" @checked($selectedStatus === 'active')>
                            <span class="flex items-center justify-center rounded-2xl border border-zinc-200 px-4 py-3 text-sm font-medium text-zinc-600 transition peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white">Active</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="inactive" class="peer sr-only" @checked($selectedStatus === 'inactive')>
                            <span class="flex items-center justify-center rounded-2xl border border-zinc-200 px-4 py-3 text-sm font-medium text-zinc-600 transition peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white">Inactive</span>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">Main Image</h2>
            <p class="mt-1 text-sm text-zinc-500">WebP recommended, max 5MB.</p>
            <div class="mt-5 space-y-4">
                <label class="flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-8 text-center">
                    <input type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp" data-main-image-input class="hidden">
                    <img src="{{ data_get($product, 'main_image_url', asset('images/placeholder-product.webp')) }}" alt="Main image preview" data-main-image-preview class="mb-4 h-32 w-32 rounded-3xl border border-zinc-200 object-cover">
                    <span class="text-sm font-medium text-zinc-700">Upload main product image</span>
                    <span class="mt-1 text-xs text-zinc-500">Click to choose or replace the image</span>
                </label>
            </div>
        </section>

        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">Gallery Images</h2>
            <p class="mt-1 text-sm text-zinc-500">Upload multiple supporting images for this product.</p>

            <div class="mt-5">
                <label class="flex cursor-pointer items-center justify-center rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-4 py-4 text-sm font-medium text-zinc-700">
                    <input type="file" name="gallery_images[]" accept=".jpg,.jpeg,.png,.webp" multiple data-gallery-input class="hidden">
                    Add gallery images
                </label>
            </div>

            @if ($editing && ! empty($galleryImages))
                <div class="mt-5">
                    <p class="mb-3 text-sm font-medium text-zinc-700">Existing Gallery</p>
                    <div class="grid grid-cols-2 gap-3" data-existing-gallery>
                        @foreach ($galleryImages as $image)
                            <label class="relative overflow-hidden rounded-2xl border border-zinc-200">
                                <img src="{{ \App\Helpers\ImageHelper::getUrl($image) }}" alt="Gallery image" class="h-28 w-full object-cover">
                                <span class="absolute inset-x-0 bottom-0 flex items-center gap-2 bg-black/65 px-3 py-2 text-xs text-white">
                                    <input type="checkbox" name="remove_gallery_images[]" value="{{ $image }}" class="rounded border-white/40 text-primary focus:ring-[#D4AF37]">
                                    Remove
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-5">
                <p class="mb-3 text-sm font-medium text-zinc-700">New Upload Preview</p>
                <div class="grid grid-cols-2 gap-3 md:grid-cols-3" data-gallery-preview></div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 transition hover:border-zinc-400">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center rounded-2xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-dark">
                {{ $submitLabel }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (() => {
            const slugify = (value) => value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            const nameInput = document.querySelector('[data-slug-source]');
            const slugInput = document.querySelector('[data-slug-target]');
            const slugPreview = document.querySelector('[data-slug-preview]');
            const canonicalPreview = document.querySelector('[data-canonical-preview]');
            const priceInput = document.querySelector('[data-price-input]');
            const salePriceInput = document.querySelector('[data-sale-price-input]');
            const discountOutput = document.querySelector('[data-discount-output]');
            const mainImageInput = document.querySelector('[data-main-image-input]');
            const mainImagePreview = document.querySelector('[data-main-image-preview]');
            const galleryInput = document.querySelector('[data-gallery-input]');
            const galleryPreview = document.querySelector('[data-gallery-preview]');
            const counters = {
                subtitle: document.querySelector('[data-char-count="subtitle"]'),
                seo_title: document.querySelector('[data-char-count="seo_title"]'),
                seo_description: document.querySelector('[data-char-count="seo_description"]'),
            };

            let slugManuallyEdited = Boolean(slugInput?.value);

            const updateSlugPreview = () => {
                const slugValue = slugInput?.value.trim() || 'your-product-slug';
                const url = `{{ url('/products') }}/${slugValue}`;

                if (slugPreview) slugPreview.textContent = url;
                if (canonicalPreview) canonicalPreview.textContent = url;
            };

            const updateDiscount = () => {
                const price = Number(priceInput?.value || 0);
                const salePrice = Number(salePriceInput?.value || 0);

                if (price > 0 && salePrice > 0 && salePrice < price) {
                    const discount = Math.round(((price - salePrice) / price) * 100);
                    discountOutput.textContent = `${discount}% off`;
                } else {
                    discountOutput.textContent = '—';
                }
            };

            const updateCounter = (id) => {
                const field = document.getElementById(id);
                const counter = counters[id];
                if (field && counter) {
                    counter.textContent = field.value.length;
                }
            };

            nameInput?.addEventListener('input', () => {
                if (!slugManuallyEdited && slugInput) {
                    slugInput.value = slugify(nameInput.value);
                    updateSlugPreview();
                }
            });

            slugInput?.addEventListener('input', () => {
                slugManuallyEdited = slugInput.value.trim() !== '';
                slugInput.value = slugify(slugInput.value);
                updateSlugPreview();
            });

            [priceInput, salePriceInput].forEach((input) => input?.addEventListener('input', updateDiscount));

            ['subtitle', 'seo_title', 'seo_description'].forEach((id) => {
                document.getElementById(id)?.addEventListener('input', () => updateCounter(id));
                updateCounter(id);
            });

            mainImageInput?.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (file && mainImagePreview) {
                    mainImagePreview.src = URL.createObjectURL(file);
                }
            });

            galleryInput?.addEventListener('change', (event) => {
                if (!galleryPreview) return;
                galleryPreview.innerHTML = '';

                Array.from(event.target.files || []).forEach((file) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-50';

                    const image = document.createElement('img');
                    image.className = 'h-28 w-full object-cover';
                    image.src = URL.createObjectURL(file);
                    image.alt = file.name;

                    const caption = document.createElement('p');
                    caption.className = 'truncate px-3 py-2 text-xs text-zinc-500';
                    caption.textContent = file.name;

                    wrapper.appendChild(image);
                    wrapper.appendChild(caption);
                    galleryPreview.appendChild(wrapper);
                });
            });

            updateSlugPreview();
            updateDiscount();
        })();
    </script>
@endpush
