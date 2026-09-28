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
            $path = $file->storeAs($folder, "{$filename}.webp", 'public');
            static::makeThumbnail($path);

            return $path;
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
                    static::makeThumbnail($path);

                    return $path;
                }
            }
        }

        $path = $file->storeAs($folder, "{$filename}.{$extension}", 'public');
        static::makeThumbnail($path);

        return $path;
    }

    public static function delete(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        $normalizedPath = ltrim(Str::of($path)->after('/storage/')->toString(), '/');

        $thumbnailPath = static::thumbnailPath($normalizedPath);
        if (Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }

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

    /** Where the thumbnail of an upload lives on the public disk. */
    public static function thumbnailPath(string $path, int $width = 480): string
    {
        $normalizedPath = ltrim(Str::of($path)->after('/storage/')->toString(), '/');

        return 'thumbs/' . $width . '/' . preg_replace('/\.[a-z0-9]+$/i', '', $normalizedPath) . '.webp';
    }

    /**
     * Create a WebP thumbnail (default 480px wide) for an upload on the public
     * disk. Returns the thumbnail path, or null when it cannot be made.
     */
    public static function makeThumbnail(?string $path, int $width = 480): ?string
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://']) || ! function_exists('imagewebp')) {
            return null;
        }

        $normalizedPath = ltrim(Str::of($path)->after('/storage/')->toString(), '/');
        $disk = Storage::disk('public');

        if (! $disk->exists($normalizedPath)) {
            return null;
        }

        $source = @imagecreatefromstring($disk->get($normalizedPath));
        if ($source === false) {
            return null;
        }

        $originalWidth = imagesx($source);
        $originalHeight = imagesy($source);
        $targetWidth = min($width, $originalWidth);
        $targetHeight = (int) round($originalHeight * $targetWidth / max(1, $originalWidth));

        $thumb = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

        ob_start();
        imagewebp($thumb, null, 80);
        $contents = ob_get_clean();
        imagedestroy($thumb);
        imagedestroy($source);

        if ($contents === false || $contents === '') {
            return null;
        }

        $thumbnailPath = static::thumbnailPath($normalizedPath, $width);
        $disk->put($thumbnailPath, $contents);

        return $thumbnailPath;
    }

    /** URL of an upload's thumbnail if one exists, otherwise null. */
    public static function thumbnailUrl(?string $path, int $width = 480): ?string
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://', '/'])) {
            return null;
        }

        $thumbnailPath = static::thumbnailPath($path, $width);

        return Storage::disk('public')->exists($thumbnailPath) ? url(Storage::url($thumbnailPath)) : null;
    }
}
