<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportShopifyCsv extends Command
{
    protected $signature = 'import:shopify-csv {file? : Path to CSV file (default: products.csv in project root)}';
    protected $description = 'Import products from the Shopify-scraped CSV file (products.csv)';

    public function handle(): int
    {
        $file = $this->argument('file') ?? base_path('products.csv');

        if (! file_exists($file)) {
            $this->error("File not found: {$file}");
            return self::FAILURE;
        }

        $handle = fopen($file, 'rb');
        if (! $handle) {
            $this->error('Unable to open the CSV file.');
            return self::FAILURE;
        }

        // Read and normalize headers
        $headerRow = fgetcsv($handle) ?: [];
        $headers = array_map(fn ($v) => Str::of((string) $v)->trim()->lower()->toString(), $headerRow);

        $requiredHeaders = ['name', 'price_raw'];
        $missing = array_diff($requiredHeaders, $headers);
        if ($missing !== []) {
            $this->error('Missing required CSV columns: ' . implode(', ', $missing));
            fclose($handle);
            return self::FAILURE;
        }

        // Ensure a default category exists
        $defaultCategory = Category::firstOrCreate(
            ['slug' => 'uncategorized'],
            ['name' => 'Uncategorized', 'status' => 'active', 'sort_order' => 999]
        );

        $imported = 0;
        $skipped = 0;
        $errors = [];

        DB::transaction(function () use ($handle, $headers, $defaultCategory, &$imported, &$skipped, &$errors) {
            $rowNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                if (count($row) !== count($headers)) {
                    $skipped++;
                    $errors[] = "Row {$rowNumber}: column count mismatch (expected " . count($headers) . ", got " . count($row) . ")";
                    continue;
                }

                $data = array_combine($headers, $row);
                if (! is_array($data)) {
                    $skipped++;
                    $errors[] = "Row {$rowNumber}: invalid row structure.";
                    continue;
                }

                $name = trim((string) ($data['name'] ?? ''));
                $priceRaw = trim((string) ($data['price_raw'] ?? ''));

                if ($name === '' || $priceRaw === '' || ! is_numeric($priceRaw)) {
                    $skipped++;
                    $errors[] = "Row {$rowNumber}: missing or invalid name/price (name='{$name}', price_raw='{$priceRaw}').";
                    continue;
                }

                // Resolve category
                $categoryName = trim((string) ($data['categories'] ?? ''));
                $category = null;
                if ($categoryName !== '') {
                    $category = Category::where('slug', Str::slug($categoryName))
                        ->orWhere('name', $categoryName)
                        ->first();
                }
                $category = $category ?? $defaultCategory;

                // Parse compare_at_price (sale logic: original price is compare_at, sale price is price_raw)
                $compareAt = trim(str_replace(['Rs.', 'Rs', ',', ' '], '', (string) ($data['compare_at_price'] ?? '')));
                $price = (float) $priceRaw;
                $salePrice = null;

                if ($compareAt !== '' && is_numeric($compareAt) && (float) $compareAt > $price) {
                    // Product is on sale: compare_at is the original price, price_raw is the sale price
                    $salePrice = $price;
                    $price = (float) $compareAt;
                }

                // Determine availability/status
                $available = strtolower(trim((string) ($data['available'] ?? 'true')));
                $status = in_array($available, ['true', '1', 'yes'], true) ? 'active' : 'inactive';

                // Generate unique slug
                $slug = $this->generateUniqueSlug($data['slug'] ?? $name);

                // Main image
                $mainImage = trim((string) ($data['main_image'] ?? ''));

                // Short description
                $shortDesc = trim((string) ($data['short_description'] ?? ''));

                Product::create([
                    'category_id'       => $category->id,
                    'name'              => $name,
                    'slug'              => $slug,
                    'price'             => $price,
                    'sale_price'        => $salePrice,
                    'stock'             => 0,
                    'short_description' => $shortDesc !== '' ? $shortDesc : null,
                    'description'       => null,
                    'main_image'        => $mainImage !== '' ? $mainImage : null,
                    'status'            => $status,
                ]);

                $imported++;
            }
        });

        fclose($handle);

        $this->info("✅ Import complete: {$imported} products imported, {$skipped} skipped.");

        if ($skipped > 0 && $this->option('verbose')) {
            $this->warn('Errors:');
            foreach (array_slice($errors, 0, 20) as $error) {
                $this->line("  • {$error}");
            }
            if (count($errors) > 20) {
                $this->line("  ... and " . (count($errors) - 20) . " more.");
            }
        }

        return self::SUCCESS;
    }

    private function generateUniqueSlug(string $value): string
    {
        $baseSlug = Str::slug($value);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'product';
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
