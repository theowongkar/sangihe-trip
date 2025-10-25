<x-guest-layout>
    {{-- Judul Halaman --}}
    <x-slot name="title">{{ $article->title }}</x-slot>

    {{-- Artikel Detail --}}
    <section class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
            <div
                class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-6 transition">

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('article.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium bg-[#167c8d] text-white hover:bg-[#126a79] transition">
                        ← Kembali
                    </a>
                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                        👁️ {{ $article->views }}x dilihat
                    </span>
                </div>

                {{-- Gambar Utama --}}
                <div class="overflow-hidden rounded-xl shadow-sm">
                    <img src="{{ $article->image_path ? asset('storage/' . $article->image_path) : asset('img/placeholder-image.webp') }}"
                        alt="{{ $article->title }}"
                        class="w-full aspect-video object-cover hover:scale-105 transition duration-700 ease-in-out">
                </div>

                {{-- Judul --}}
                <h1 class="text-3xl font-bold text-gray-900 leading-tight">
                    {{ $article->title }}
                </h1>

                {{-- Isi Artikel --}}
                <article
                    class="prose prose-lg max-w-none text-gray-700 prose-a:text-[#167c8d] prose-img:rounded-lg">
                    {!! nl2br(e($article->content)) !!}
                </article>
            </div>
        </div>
    </section>
</x-guest-layout>
