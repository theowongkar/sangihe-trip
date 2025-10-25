<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
        ]);

        // Ambil Nilai
        $search = $validated['search'] ?? null;

        // Query dasar produk
        $articles = Article::where('status', 'Terbit')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->orderBy('views', 'DESC')
            ->paginate(25);

        return view('articles.index', compact('articles', 'search'));
    }

    public function show($slug)
    {
        // Ambil artikel berdasarkan slug
        $article = Article::where('slug', $slug)
            ->where('status', 'Terbit')
            ->firstOrFail();

        // Buat key unik untuk cookie per artikel
        $cookieKey = 'viewed_article_' . $article->id;

        // Cek apakah user sudah pernah lihat artikel ini dalam 1 hari
        if (!Cookie::has($cookieKey)) {
            // Tambahkan jumlah view
            $article->increment('views');

            // Set cookie agar kedaluwarsa dalam 1 hari (1440 menit)
            Cookie::queue($cookieKey, true, 1440);
        }

        return view('articles.show', compact('article'));
    }
}
