<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'folder' => ['nullable', 'string', 'max:50'],
        ]);

        $folder = $data['folder'] ?? 'products';
        $path = ImageHelper::upload($request->file('image'), $folder);

        return response()->json([
            'path' => $path,
            'url' => ImageHelper::getUrl($path),
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $data = $request->validate([
            'path' => ['required', 'string'],
        ]);

        ImageHelper::delete($data['path']);

        return response()->json([
            'deleted' => true,
        ]);
    }
}
