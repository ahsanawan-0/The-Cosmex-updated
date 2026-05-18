<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('status', 'active')
            ->whereIn('name', ['Laser Machines', 'HydraFacial', 'Aesthetic Products', 'Other Equipment'])
            ->orderBy('sort_order')
            ->get();

        // Products for "HydraFacial Series" section
        $hydrafacialCategory = Category::where('slug', 'like', '%hydra%')
            ->orWhere('name', 'like', '%Hydra%')
            ->first();
        $hydrafacialProducts = $hydrafacialCategory
            ? Product::with('category')->active()
                ->where('category_id', $hydrafacialCategory->id)
                ->latest()->take(4)->get()
            : collect();

        // Products for "Laser Machines" section
        $laserCategory = Category::where('slug', 'like', '%laser%')
            ->orWhere('name', 'like', '%Laser%')
            ->first();
        $laserProducts = $laserCategory
            ? Product::with('category')->active()
                ->where('category_id', $laserCategory->id)
                ->latest()->take(4)->get()
            : collect();

        // If no specific category found, get latest active products
        if ($hydrafacialProducts->isEmpty()) {
            $hydrafacialProducts = Product::with('category')->active()->latest()->take(4)->get();
        }
        if ($laserProducts->isEmpty()) {
            $laserProducts = Product::with('category')->active()->latest()->skip(4)->take(4)->get();
        }

        // Aesthetic product categories for the slider
        $aestheticCategories = Category::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // Recent approved reviews for homepage
        $featuredReviews = Review::with('product')
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('public.home.index', compact(
            'categories',
            'hydrafacialProducts',
            'laserProducts',
            'aestheticCategories',
            'featuredReviews'
        ));
    }
}
