<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Rute untuk tamu (pengguna yang tidak diautentikasi)
Route::get('/', function () {
    return view('auth.login');
});

// Swagger UI route
Route::get('/api/documentation', function () {
    return view('l5-swagger::index', [
        'urlToDocs' => url('/api/docs.json'),  // Path ke file Swagger JSON
        'operationsSorter' => 'alpha',  // Misalnya, sorting API secara alfabetis
        'configUrl' => null,
        'validatorUrl' => null
    ]);
});

// Rute untuk pengguna terautentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::resource('products', ProductController::class);

    // Checkout routes
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    
    // Order confirmation
    Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');

    // Rute untuk menampilkan detail pesanan
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::patch('/wishlist/update/{id}', [WishlistController::class, 'update'])->name('wishlist.update');
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    // Review routes
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

});

// Rute untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Manajemen pengguna
    Route::resource('users', UserController::class);

    // Manajemen produk (CRUD untuk admin)
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    
    // Manajemen pesanan 
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    // Manajemen pelanggan
    Route::resource('customers', CustomerController::class);
});

// Menyertakan rute autentikasi Laravel Breeze
require __DIR__.'/auth.php';