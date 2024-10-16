<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlistItems()->with('product')->get();
        $total = $wishlistItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        return view('wishlist.index', compact('wishlistItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $user = Auth::user();
        $existingItem = $user->wishlistItems()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->increment('quantity');
        } else {
            $user->wishlistItems()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        $this->updateWishlistCount();
        return redirect()->back()->with('success', 'Product added to wishlist successfully!');
    }

    public function remove($id)
    {
        $user = Auth::user();
        $user->wishlistItems()->where('id', $id)->delete();

        $this->updateWishlistCount();
        return redirect()->back()->with('success', 'Product removed from wishlist successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $wishlistItem = $user->wishlistItems()->where('product_id', $id)->first();

        if ($wishlistItem) {
            $wishlistItem->update(['quantity' => $request->quantity]);
        }

        $this->updateWishlistCount();
        return redirect()->back()->with('success', 'Wishlist updated successfully!');
    }

    public function moveToCart($id)
    {
        $user = Auth::user();
        $wishlistItem = $user->wishlistItems()->where('product_id', $id)->first();

        if ($wishlistItem) {
            $cart = session()->get('cart', []);
            
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $wishlistItem->quantity;
            } else {
                $cart[$id] = [
                    "name" => $wishlistItem->product->name,
                    "quantity" => $wishlistItem->quantity,
                    "price" => $wishlistItem->product->price,
                    "image" => $wishlistItem->product->image_url
                ];
            }

            session()->put('cart', $cart);
            $wishlistItem->delete();
            
            $this->updateWishlistCount();
            return redirect()->route('cart.index')->with('success', 'Product moved to cart successfully!');
        }

        return redirect()->back()->with('error', 'Product not found in wishlist.');
    }

    public function clear()
    {
        $user = Auth::user();
        $user->wishlistItems()->delete();

        $this->updateWishlistCount();
        return redirect()->back()->with('success', 'Wishlist cleared successfully!');
    }

    private function updateWishlistCount()
    {
        $wishlistCount = Auth::user()->wishlistItems()->sum('quantity');
        session(['wishlistCount' => $wishlistCount]);
    }
}
