<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil kategori produk
        $productCategories = ProductCategory::get();

        // Ambil produk
        $products = Product::with('primaryImage')
            ->withAvg('reviews', 'rating')
            ->where('status', 'Terbit')
            ->orderByDesc('reviews_avg_rating')
            ->limit(8)
            ->get();

        // Ambil artikel
        $articles = Article::where('status', 'Terbit')
            ->orderByDesc('created_at', 'DESC')
            ->limit(8)
            ->get();

        return view('index', compact('productCategories', 'products', 'articles'));
    }
}
