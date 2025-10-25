<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Home</x-slot>

    {{-- Bagian Header --}}
    <header class="relative h-96 bg-cover bg-center" style="background-image: url('img/hero-image.webp')">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Konten di tengah -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
            <h1 class="text-2xl md:text-4xl font-bold mb-4">Selamat Datang di Website Kami</h1>
            <p class="text-lg md:text-xl">
                Temukan pengalaman terbaik bersama kami di destinasi pilihanmu.
            </p>
            <a href="{{ route('product.index') }}"
                class="mt-8 bg-white text-[#167c8d] font-semibold px-6 py-3 rounded-xl shadow hover:bg-[#167c8d] hover:text-white transition">
                Jelajahi Sekarang
            </a>
        </div>
    </header>

    {{-- Bagian Kategori Produk --}}
    <section>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8" x-data="{
            currentIndex: 0,
            totalItems: {{ $productCategories->count() }},
            itemsPerView: 1,
            itemWidth: 0,
            setItemsPerView() {
                const width = window.innerWidth;
                if (width >= 1280) this.itemsPerView = 8; // xl
                else if (width >= 1024) this.itemsPerView = 6; // lg
                else if (width >= 768) this.itemsPerView = 6; // md
                else this.itemsPerView = 3;
                this.itemWidth = this.$refs.track.clientWidth / this.itemsPerView;
            },
            goTo(index) { this.currentIndex = index; },
            init() {
                this.setItemsPerView();
                window.addEventListener('resize', () => this.setItemsPerView());
            }
        }"
            x-init="init()">

            <h2 class="mb-5 text-xl font-bold">Kategori Produk</h2>

            <div class="overflow-hidden relative">
                <div class="flex transition-transform duration-300"
                    :style="`transform: translateX(-${currentIndex * itemWidth}px)`" x-ref="track">
                    @forelse ($productCategories as $productCategory)
                        <div class="flex-shrink-0 px-2" :style="`width: ${itemWidth}px`">
                            <a href="{{ route('product.index', ['category' => $productCategory->slug]) }}"
                                aria-label="Kategori Produk">
                                <img src="{{ $productCategory->image_path ? asset('storage/' . $productCategory->image_path) : asset('img/placeholder-image.webp') }}"
                                    alt="{{ implode(' ', array_slice(explode(' ', $productCategory->name), 0, 2)) }}"
                                    class="w-full aspect-square object-cover border border-gray-300 rounded-lg shadow" />
                            </a>
                            <h3 class="mt-2 text-sm text-center">{{ $productCategory->name }}</h3>
                        </div>
                    @empty
                        <p class="text-lg font-semibold text-gray-700">
                            Oops, Kategori belum tersedia.
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Dot navigation -->
            <div class="flex justify-center mt-4 space-x-2">
                <template x-for="i in Math.ceil(totalItems / itemsPerView)" :key="i">
                    <button @click="goTo(i - 1)" aria-label="Dot Button"
                        :class="{ 'bg-blue-500': currentIndex === i - 1, 'bg-gray-300': currentIndex !== i - 1 }"
                        class="w-3 h-3 rounded-full cursor-pointer"></button>
                </template>
            </div>
        </div>
    </section>

    {{-- Bagian Produk --}}
    <section>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8">
            <h2 class="mb-5 text-xl font-bold">Produk Unggulan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
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
        </div>
    </section>

    {{-- Bagian Artikel --}}
    <section>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8">
            <h2 class="mb-5 text-xl font-bold">Artikel Terbaru</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse ($articles as $article)
                    <a href="#"
                        class="w-full flex flex-col bg-white border border-gray-300 rounded-lg shadow overflow-hidden">
                        <img src="{{ $article->image_path ? asset('storage/' . $article->image_path) : asset('img/placeholder-image.webp') }}"
                            alt="{{ implode(' ', array_slice(explode(' ', $article->title), 0, 2)) }}"
                            class="w-full aspect-video object-cover" />
                        <div class="px-4 py-2">
                            <h3 class="mb-1 leading-tight line-clamp-2">{{ $article->title }}</h3>
                            <p class="mb-2 text-gray-500 text-xs line-clamp-3">{{ $article->content }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-2 md:col-span-4 lg:col-span-5 text-center py-10">
                        <p class="text-lg font-semibold text-gray-700">
                            Oops, produk belum tersedia.
                        </p>
                        <p class="text-gray-500 mt-1">
                            Ayo dukung UMKM dan cek artikel lainnya!
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</x-guest-layout>
