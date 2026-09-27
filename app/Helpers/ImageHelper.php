<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function upload(UploadedFile $file, string $folder = 'products'): string
    {
        $folder = trim($folder, '/');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = (string) Str::uuid();

        if ($extension === 'webp') {
            return $file->storeAs($folder, "{$filename}.webp", 'public');
        }

        if (in_array($extension, ['jpg', 'jpeg', 'png'], true) && function_exists('imagewebp')) {
            $image = match ($extension) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($file->getRealPath()),
                'png' => @imagecreatefrompng($file->getRealPath()),
            };

            if ($image !== false) {
                if ($extension === 'png') {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                }

                ob_start();
                imagewebp($image, null, 90);
                $contents = ob_get_clean();
                imagedestroy($image);

                if ($contents !== false) {
                    $path = "{$folder}/{$filename}.webp";
                    Storage::disk('public')->put($path, $contents);

                    return $path;
                }
            }
        }

        return $file->storeAs($folder, "{$filename}.{$extension}", 'public');
    }

    public static function delete(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        $normalizedPath = ltrim(Str::of($path)->after('/storage/')->toString(), '/');

        return Storage::disk('public')->exists($normalizedPath)
            ? Storage::disk('public')->delete($normalizedPath)
            : false;
    }

    /**
     * Resolve an image path to a URL, or null when nothing is actually there.
     *
     * Returning null lets callers try a second path before giving up on a
     * placeholder, which a plain getUrl() cannot express.
     */
    public static function resolve(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return url(ltrim($path, '/'));
        }

        $normalizedPath = ltrim(Str::of($path)->after('/storage/')->toString(), '/');

        if (Storage::disk('public')->exists($normalizedPath)) {
            return url(Storage::url($normalizedPath));
        }

        // Fall back to an image shipped with the repo, e.g. a record pointing at
        // 'categories/botox.webp' resolves to public/images/categories/botox.webp.
        // Uploads live on the public disk, which is not deployed, so this keeps
        // bundled imagery working on servers that never received those uploads.
        if (is_file(public_path('images/'.$normalizedPath))) {
            return url('images/'.$normalizedPath);
        }

        return null;
    }

    public static function getUrl(?string $path, string $placeholder = '/images/placeholder-product.webp'): string
    {
        return static::resolve($path) ?? url(ltrim($placeholder, '/'));
    }
}
