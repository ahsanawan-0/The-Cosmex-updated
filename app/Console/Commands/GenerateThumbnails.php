<?php

namespace App\Console\Commands;

use App\Helpers\ImageHelper;
use App\Models\Product;
use Illuminate\Console\Command;

class GenerateThumbnails extends Command
{
    protected $signature = 'images:thumbnails {--force : Rebuild thumbnails that already exist}';

    protected $description = 'Create 480px WebP thumbnails for product images used on listing cards';

    public function handle(): int
    {
        $made = $skipped = $failed = 0;

        Product::query()->whereNotNull('main_image')->orderBy('id')->each(function (Product $product) use (&$made, &$skipped, &$failed) {
            $path = str_contains($product->main_image, '/') ? $product->main_image : 'products/' . $product->main_image;

            if (! $this->option('force') && ImageHelper::thumbnailUrl($path)) {
                $skipped++;

                return;
            }

            ImageHelper::makeThumbnail($path) ? $made++ : $failed++;
        });

        $this->info("Thumbnails created: {$made}, already present: {$skipped}, not possible: {$failed}");

        return self::SUCCESS;
    }
}
