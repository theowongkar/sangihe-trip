<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function upsert(Request $request, Product $product)
    {
        // Validasi Input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $review = $product->reviews()->where('user_id', $userId)->first();

        if ($review) {
            $review->update($validated);
            $message = 'Ulasan berhasil diperbarui!';
        } else {
            $product->reviews()->create([
                'user_id' => $userId,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);
            $message = 'Ulasan berhasil disimpan!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy(ProductReview $review)
    {
        // Cek apakah user pemilik review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus Review
        $review->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus!');
    }
}
