<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->with(['parent'])
            ->withCount('products')
            ->latest()
            ->paginate(20)
            ->through(fn (Category $category): array => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'parent_name' => $category->parent?->name,
                'image_url' => $category->image_url,
                'products_count' => (int) $category->products_count,
                'status' => $category->status,
                'sort_order' => (int) $category->sort_order,
            ]);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get(['id', 'name']);
        return view('admin.categories.create', compact('parents'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->input('status', 'active');
        $data['slug'] = $this->generateUniqueSlug($request->input('slug', $data['name']));

        if ($request->hasFile('image')) {
            $data['image'] = ImageHelper::upload($request->file('image'), 'categories');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(int $id): View
    {
        $category = Category::findOrFail($id);
        $parents = Category::whereNull('parent_id')->where('id', '!=', $id)->orderBy('name')->get(['id', 'name']);
        
        $categoryData = [
            'id' => $category->id,
            'name' => $category->name,
            'parent_id' => $category->parent_id,
            'slug' => $category->slug,
            'description' => $category->description,
            'sort_order' => (int) $category->sort_order,
            'status' => $category->status,
            'image_url' => $category->image_url,
        ];

        return view('admin.categories.edit', ['category' => $categoryData, 'parents' => $parents]);
    }

    public function update(StoreCategoryRequest $request, int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();
        $data['status'] = $request->input('status', 'active');
        $data['slug'] = $this->generateUniqueSlug($request->input('slug', $data['name']), $category->id);

        if ($request->hasFile('image')) {
            ImageHelper::delete($category->image);
            $data['image'] = ImageHelper::upload($request->file('image'), 'categories');
        } else {
            // No new image uploaded — preserve the existing image path
            $data['image'] = $category->image;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $productCount = $category->products()->count();

        if ($productCount > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Cannot delete: {$productCount} products are in this category");
        }

        ImageHelper::delete($category->image);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    private function generateUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'category';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Category::query()
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
