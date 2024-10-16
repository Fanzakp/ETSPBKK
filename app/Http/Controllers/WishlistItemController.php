<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistItemController extends Controller
{
    public function index()
    {
        // Ambil item wishlist dengan pagination, misalnya 9 item per halaman
        $wishlistItems = Auth::user()->wishlistItems()->paginate(9);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request, $productId)
    {
        // Tambahkan item ke wishlist
        $wishlistItem = new WishlistItem();
        $wishlistItem->user_id = Auth::id();
        $wishlistItem->product_id = $productId;
        $wishlistItem->save();

        return redirect()->route('wishlist.index')->with('success', 'Item added to wishlist');
    }

    public function remove($wishlistItemId)
    {
        // Hapus item dari wishlist
        $wishlistItem = WishlistItem::where('id', $wishlistItemId)->where('user_id', Auth::id())->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->route('wishlist.index')->with('success', 'Item removed from wishlist');
        }

        return redirect()->route('wishlist.index')->with('error', 'Item not found');
    }
}
