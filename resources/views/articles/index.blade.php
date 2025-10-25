<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Artikel</x-slot>

    {{-- Bagian Artikel --}}
    <section>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8">
            <div class="flex flex-col md:flex-row gap-5">
                <div class="w-60">
                    <h2 class="mb-5 text-xl font-bold">Filter</h2>

                    <div>
                        <h3 class="mb-2 font-medium">Cari</h3>
                        <form action="{{ route('article.index') }}" method="GET">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Temukan di sini..."
                                class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:outline-none">
                        </form>
                    </div>
                </div>

                <div class="md:flex-1">
                    <h2 class="mb-5 text-xl font-bold">Artikel Terkait</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        @forelse ($articles as $article)
                            <div class="w-full flex flex-col border border-gray-300 rounded-lg shadow overflow-hidden">
                                <a href="{{ route('article.show', $article->slug) }}" class="flex-1 bg-white">
                                    <img src="{{ $article->image_path ? asset('storage/' . $article->image_path) : asset('img/placeholder-image.webp') }}"
                                        alt="{{ implode(' ', array_slice(explode(' ', $article->title), 0, 2)) }}"
                                        class="w-full aspect-video object-cover" />
                                    <div class="px-4 py-2">
                                        <h3 class="mb-1 leading-tight line-clamp-2">{{ $article->title }}</h3>
                                        <p class="mb-2 text-gray-500 text-xs line-clamp-3">
                                            {{ $article->content }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-2 md:col-span-4 lg:col-span-5 text-center py-10">
                                <p class="text-lg font-semibold text-gray-700">
                                    Oops, artikel belum tersedia.
                                </p>
                                <p class="text-gray-500 mt-1">
                                    Ayo dukung UMKM dan cek artikel lainnya!
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5">
                        {{ $articles->withQueryString()->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
