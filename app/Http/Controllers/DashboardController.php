<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->inRandomOrder()->limit(1);
        }])->get();
        $products = Product::inRandomOrder()->take(4)->get();
        return view('dashboard', compact('categories', 'products'));
    }
}

