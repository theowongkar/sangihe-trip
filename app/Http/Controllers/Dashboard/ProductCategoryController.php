<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Ambil Semua Kategori Bisnis
        $productCategories = ProductCategory::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('name', 'ASC')
            ->paginate(20);

        return view('dashboard.product-categories.index', compact('productCategories'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:product_categories,name',
        ]);

        // Tambah Kategori Produk
        ProductCategory::create($validated);

        return redirect()->back()->with('success', 'Data kategori produk berhasil ditambahkan!');
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        // Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:product_categories,name,' . $productCategory->id,
        ]);

        // Ubah Kategori Produk
        $productCategory->update($validated);

        return redirect()->back()->with('success', 'Data kategori produk berhasil diperbarui!');
    }

    public function destroy(ProductCategory $productCategory)
    {
        // Hapus Kategori Produk
        $productCategory->delete();

        return redirect()->back()->with('success', 'Data kategori produk berhasil dihapus!');
    }
}
