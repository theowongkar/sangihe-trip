<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\ProductOperatingHour;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
            'status' => 'nullable|in:Draf,Terbit,Arsip',
        ]);

        // Ambil Nilai
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? null;

        // Ambil Semua Produk
        $products = Product::when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('owner_name', 'LIKE', "{$search}%");
            });
        })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $productCategories = ProductCategory::orderBy('name')->get();

        return view('dashboard.products.create', compact('productCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gmaps_link' => 'nullable|string',
            'facility' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Simpan data produk utama
        $product = Product::create([
            ...$validated,
            'facility' => $request->facility ?? [],
        ]);

        // Simpan gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Simpan jam operasional
        if ($request->has('hours')) {
            foreach ($request->hours as $day => $data) {
                ProductOperatingHour::create([
                    'product_id' => $product->id,
                    'day' => $day,
                    'open_time' => $data['open_time'] ?? null,
                    'close_time' => $data['close_time'] ?? null,
                    'is_open' => isset($data['is_open']) && $data['is_open'] == 1,
                ]);
            }
        }

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $productCategories = ProductCategory::all();

        // Format ulang jam operasional per hari
        $operatingHours = $product->operatingHours->keyBy('day');

        return view('dashboard.products.edit', compact('product', 'productCategories', 'operatingHours'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gmaps_link' => 'nullable|string',
            'facility' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Update data utama
        $product->update([
            ...$validated,
            'facility' => $request->facility ?? [],
        ]);

        // Upload gambar baru (jika ada)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Update jam operasional — hapus dulu yang lama
        $product->operatingHours()->delete();

        if ($request->has('hours')) {
            foreach ($request->hours as $day => $data) {
                $product->operatingHours()->create([
                    'day' => $day,
                    'open_time' => $data['open_time'] ?? null,
                    'close_time' => $data['close_time'] ?? null,
                    'is_open' => isset($data['is_open']) && $data['is_open'] == 1,
                ]);
            }
        }

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Hapus semua file gambar di storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->delete();

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil dihapus.');
    }
}
