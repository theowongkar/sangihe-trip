<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Produk</x-slot>

    {{-- Bagian Produk --}}
    <section>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8">
            <div class="flex flex-col md:flex-row gap-5">
                <div class="w-60">
                    <h2 class="mb-5 text-xl font-bold">Filter</h2>

                    <div>
                        <h3 class="mb-2 font-medium">Cari</h3>
                        <form action="" method="GET">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Temukan di sini..."
                                class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md focus:outline-none">

                            <input type="hidden" name="category" value="{{ request('category') }}">
                        </form>
                    </div>

                    <div class="mt-5">
                        <h3 class="mb-2 font-medium">Kategori Produk</h3>
                        <form action="{{ route('product.index') }}" method="GET">
                            <ul class="space-y-3">
                                <li class="flex items-center gap-x-2">
                                    <input type="radio" name="category" id="cat-all" value=""
                                        {{ request('category') == null ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <label for="cat-all" class="text-xs text-gray-800">
                                        Semua Kategori
                                    </label>
                                </li>

                                @foreach ($productCategories as $productCategory)
                                    <li class="flex items-center gap-x-2">
                                        <input type="radio" name="category" id="cat-{{ $productCategory->id }}"
                                            value="{{ $productCategory->slug }}"
                                            {{ request('category') == $productCategory->slug ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <label for="cat-{{ $productCategory->id }}" class="text-xs text-gray-800">
                                            {{ $productCategory->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>

                            <input type="hidden" name="search" value="{{ request('search') }}">
                        </form>
                    </div>
                </div>

                <div class="md:flex-1">
                    <h2 class="mb-5 text-xl font-bold">Produk Terkait</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        @forelse ($products as $product)
                            <div class="w-full flex flex-col border border-gray-300 rounded-lg shadow overflow-hidden">
                                <a href="{{ route('product.show', $product->slug) }}" class="flex-1 bg-white">
                                    <img src="{{ $product->primaryImage?->image_path ? asset('storage/' . $product->primaryImage->image_path) : asset('img/placeholder-image.webp') }}"
                                        alt="{{ implode(' ', array_slice(explode(' ', $product->name), 0, 2)) }}"
                                        class="w-full aspect-video object-cover" />
                                    <div class="px-4 py-2">
                                        <h3 class="mb-1 leading-tight line-clamp-2">{{ $product->name }}</h3>
                                        <p class="mb-2 text-gray-500 text-xs line-clamp-1">
                                            {{ $product->category->name }}
                                        </p>
                                        <span
                                            class="px-2 py-1 bg-yellow-500/30 text-xs whitespace-nowrap border border-yellow-500 rounded-lg">
                                            ⭐ {{ $product->averageRating() ?? 0 }}
                                        </span>
                                    </div>
                                </a>
                                <div class="flex items-center justify-between px-4 py-2 bg-gray-200">
                                    <span class="font-medium">Rp.
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 md:col-span-4 lg:col-span-5 text-center py-10">
                                <p class="text-lg font-semibold text-gray-700">
                                    Oops, produk belum tersedia.
                                </p>
                                <p class="text-gray-500 mt-1">
                                    Ayo dukung UMKM dan cek kategori lainnya!
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5">
                        {{ $products->withQueryString()->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
