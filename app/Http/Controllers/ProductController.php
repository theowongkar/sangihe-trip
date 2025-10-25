<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
        ]);

        // Ambil Nilai
        $search = $validated['search'] ?? null;
        $category = $validated['category'] ?? null;

        // Ambil kategori produk
        $productCategories = ProductCategory::all();

        // Query dasar produk
        $query = Product::with(['primaryImage', 'category'])
            ->withAvg('reviews', 'rating')
            ->where('status', 'Terbit');

        // Filter berdasarkan pencarian nama
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan kategori
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Urutkan dari rating tertinggi
        $products = $query->orderByDesc('reviews_avg_rating')->paginate(25);

        return view('products.index', compact('productCategories', 'products', 'search', 'category'));
    }

    public function show($slug)
    {
        // Ambil produk berdasarkan slug
        $product = Product::with(['images', 'primaryImage', 'category', 'operatingHours'])
            ->withAvg('reviews', 'rating')
            ->where('slug', $slug)
            ->where('status', 'Terbit')
            ->firstOrFail();

        // Ambil review produk
        $reviews = $product->reviews()->latest()->paginate(5);

        // Ambil review user yang sedang login (jika ada)
        $userReview = null;
        if (Auth::check()) {
            $userReview = $product->reviews()->where('user_id', Auth::id())->first();
        }

        return view('products.show', compact('product', 'reviews', 'userReview'));
    }
}
