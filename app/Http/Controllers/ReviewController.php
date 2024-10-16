<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Pastikan produk ada
        $product = Product::findOrFail($productId);

        // Simpan review baru
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('products.show', $product->id)->with('success', 'Review successfully added!');
    }

    public function destroy($id)
    {
        // Find the review
        $review = Review::findOrFail($id);

        // Delete the review
        $review->delete();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Review successfully deleted!');
    }

}
