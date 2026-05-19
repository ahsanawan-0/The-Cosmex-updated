<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\CacheService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $categoryId = $request->query('category');
        $search = trim((string) $request->query('search'));

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when(in_array($status, ['active', 'inactive'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when(filled($categoryId), function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(20)
            ->through(fn (Product $product): array => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'main_image_url' => $product->main_image_url,
                'category_name' => $product->category?->name,
                'price' => (float) $product->price,
                'sale_price' => $product->sale_price !== null ? (float) $product->sale_price : null,
                'stock' => (int) $product->stock,
                'status' => $product->status,
            ])
            ->withQueryString();

        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Category $category): array => [
                'id' => $category->id,
                'name' => $category->name,
            ])
            ->all();

        return view('admin.products.index', compact('products', 'categories', 'status', 'categoryId', 'search'));
    }

    public function create(): View
    {
        $categories = $this->categoryOptions();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($this->buildPayload($request));
        CacheService::clearProductCaches();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(int $id): View
    {
        $product = Product::with(['category'])->findOrFail($id);
        $categories = $this->categoryOptions();

        $product = $this->normalizeProductFormData($product);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->update($this->buildPayload($request, $product));
        CacheService::clearProductCaches();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        ImageHelper::delete($product->main_image);
        collect($product->gallery_images ?? [])->each(fn ($path) => ImageHelper::delete($path));
        $product->delete();
        CacheService::clearProductCaches();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active',
        ]);
        CacheService::clearProductCaches();

        return response()->json([
            'success' => true,
            'value' => $product->fresh()->status,
        ]);
    }

    public function importForm(): View
    {
        return view('admin.products.import');
    }

    public function importCsv(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'rb');

        if (! $handle) {
            return back()->withErrors(['csv_file' => 'Unable to read the uploaded CSV file.']);
        }

        try {
            $headerRow = fgetcsv($handle) ?: [];
            $headers = array_map(fn ($value) => Str::of((string) $value)->trim()->lower()->toString(), $headerRow);
            $requiredHeaders = ['name', 'category_name', 'price'];
            $missingHeaders = array_values(array_diff($requiredHeaders, $headers));

            if ($missingHeaders !== []) {
                return back()->withErrors([
                    'csv_file' => 'Missing required columns: '.implode(', ', $missingHeaders),
                ]);
            }

            $summary = DB::transaction(function () use ($handle, $headers): array {
                $imported = 0;
                $skipped = 0;
                $errors = [];
                $rowNumber = 1;

                while (($row = fgetcsv($handle)) !== false) {
                    $rowNumber++;

                    if (count($row) !== count($headers)) {
                        $skipped++;
                        $errors[] = "Row {$rowNumber}: column count mismatch.";
                        continue;
                    }

                    $data = array_combine($headers, $row);

                    if (! is_array($data)) {
                        $skipped++;
                        $errors[] = "Row {$rowNumber}: invalid row structure.";
                        continue;
                    }

                    $name = trim((string) ($data['name'] ?? ''));
                    $price = trim((string) ($data['price'] ?? ''));
                    $categoryName = trim((string) ($data['category_name'] ?? ''));

                    if ($name === '' || $price === '') {
                        $skipped++;
                        $errors[] = "Row {$rowNumber}: missing required name or price.";
                        continue;
                    }

                    $category = $this->resolveCategory($categoryName);

                    if (! $category) {
                        $skipped++;
                        $errors[] = "Row {$rowNumber}: category '{$categoryName}' not found.";
                        continue;
                    }

                    Product::create([
                        'category_id' => $category->id,
                        'name' => $name,
                        'slug' => $this->generateUniqueSlug($name),
                        'price' => (float) $price,
                        'sale_price' => filled($data['sale_price'] ?? null) ? (float) $data['sale_price'] : null,
                        'stock' => (int) ($data['stock'] ?? 0),
                        'short_description' => $data['short_description'] ?? null,
                        'description' => $data['description'] ?? null,
                        'status' => in_array(($data['status'] ?? 'active'), ['active', 'inactive'], true) ? $data['status'] : 'active',
                        'seo_title' => $data['seo_title'] ?? null,
                        'seo_description' => $data['seo_description'] ?? null,
                    ]);

                    $imported++;
                }

                return compact('imported', 'skipped', 'errors');
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'Import failed. No products were imported.');
        } finally {
            fclose($handle);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$summary['imported']} products imported, {$summary['skipped']} skipped")
            ->with('import_summary', $summary);
    }

    public function downloadTemplate()
    {
        $headers = [
            'name',
            'category_name',
            'price',
            'sale_price',
            'stock',
            'short_description',
            'description',
            'status',
            'seo_title',
            'seo_description',
        ];

        $sample = [
            'Soprano Titanium New Shape',
            'Laser Machines',
            '2499',
            '2199',
            '35',
            'Professional aesthetic laser machine.',
            'Clinic-grade aesthetic equipment for professional use.',
            'active',
            'Soprano Titanium New Shape | Cosmex Pvt Ltd',
            'Shop Soprano Titanium New Shape at Cosmex Pvt Ltd.',
        ];

        return Response::streamDownload(function () use ($headers, $sample): void {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, $headers);
            fputcsv($handle, $sample);
            fclose($handle);
        }, 'products-import-template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function buildPayload(StoreProductRequest|UpdateProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();
        $data['status'] = $request->input('status', 'active');
        $data['slug'] = $this->generateUniqueSlug(
            $request->input('slug', $data['name']),
            $product?->id,
        );

        if ($request->hasFile('main_image')) {
            if ($product?->main_image) {
                ImageHelper::delete($product->main_image);
            }

            $data['main_image'] = ImageHelper::upload($request->file('main_image'), 'products');
        } else {
            $data['main_image'] = $product?->main_image;
        }

        $existingGallery = collect($product?->gallery_images ?? []);
        $galleryToRemove = collect($request->input('remove_gallery_images', []))
            ->filter()
            ->values();

        $galleryToRemove->each(fn ($path) => ImageHelper::delete($path));

        $retainedGallery = $existingGallery
            ->reject(fn ($path) => $galleryToRemove->contains($path))
            ->values();

        $newGalleryImages = collect($request->file('gallery_images', []))
            ->filter(fn ($file) => $file instanceof UploadedFile)
            ->map(fn (UploadedFile $file) => ImageHelper::upload($file, 'products'))
            ->values();

        if ($request->hasFile('gallery_images')) {
            $data['gallery_images'] = $retainedGallery
                ->merge($newGalleryImages)
                ->values()
                ->all();
        } else {
            $data['gallery_images'] = $retainedGallery->all();
        }

        return $data;
    }

    private function resolveCategory(?string $value): ?Category
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        return Category::query()
            ->where('slug', Str::slug($value))
            ->orWhere('name', $value)
            ->first();
    }

    private function categoryOptions(): array
    {
        return Category::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Category $category): array => [
                'id' => $category->id,
                'name' => $category->name,
            ])
            ->all();
    }



    private function normalizeProductFormData(Product $product): array
    {
        return [
            'id'                => $product->id,
            'name'              => $product->name,
            'subtitle'          => $product->subtitle,
            'slug'              => $product->slug,
            'category_id'       => $product->category_id,
            'stock'             => (int) $product->stock,
            'short_description' => $product->short_description,
            'description'       => $product->description,
            'price'             => (float) $product->price,
            'sale_price'        => $product->sale_price !== null ? (float) $product->sale_price : null,
            'status'            => $product->status,
            'seo_title'         => $product->seo_title,
            'seo_description'   => $product->seo_description,
            'main_image_url'    => $product->main_image_url,
            'gallery_images'    => array_values($product->gallery_images ?? []),
        ];
    }

    private function generateUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'product';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
