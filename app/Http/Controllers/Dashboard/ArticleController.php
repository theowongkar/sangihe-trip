<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'status' => 'nullable|string|in:Draf,Terbit,Arsip',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $status = $validated['status'] ?? null;
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Berita Dengan Data Author dan Category
        $articles = Article::with('author')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhereHas('author', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($query) use ($status) {
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

        return view('dashboard.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('dashboard.articles.create');
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status'   => 'required|string|in:Draf,Terbit,Arsip',
            'content'  => 'required|string|min:10',
            'image_path'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan gambar
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('articles', 'public');
        }

        // Simpan artikel
        $article = Article::create([
            'author_id' => Auth::id(),
            'title' => $validated['title'],
            'status' => $validated['status'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('dashboard.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        // Validasi Input
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'status'      => 'required|string|in:Draf,Terbit,Arsip',
            'content'     => 'required|string|min:10',
            'image_path'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update gambar jika ada file baru
        if ($request->hasFile('image_path')) {
            if ($article->image_path && Storage::disk('public')->exists($article->image_path)) {
                Storage::disk('public')->delete($article->image_path);
            }
            $imagePath = $request->file('image_path')->store('articles', 'public');
        } else {
            $imagePath = $article->image_path;
        }

        // Update post
        $article->update([
            'title'       => $validated['title'],
            'status'      => $validated['status'],
            'content'     => $validated['content'],
            'image'       => $imagePath,
        ]);

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        // Hapus gambar jika ada
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        // Hapus data artikel
        $article->delete();

        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }
}
