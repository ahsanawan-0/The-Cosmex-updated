<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $product = Product::active()->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'reviewer_email' => 'nullable|email|max:150',
            'rating'         => 'required|integer|min:1|max:5',
            'body'           => 'required|string|min:10|max:1000',
        ]);

        $product->reviews()->create($validated);

        return back()->with('review_success', 'Thank you! Your review has been submitted and will appear after approval.');
    }
}
