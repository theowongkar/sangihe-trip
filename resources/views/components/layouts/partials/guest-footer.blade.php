<footer class="bg-[#0d4b57] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 py-12">
            {{-- Logo --}}
            <div class="lg:col-span-2">
                <div>
                    <h3 class="text-2xl font-bold">SangiheTrip</h3>
                </div>

                <p class="max-w-sm mt-3 text-gray-200 leading-relaxed">Sistem berbasis web yang membantu wisatawan
                    membuat dan mengatur itinerary wisata secara mudah dan efisien.</p>
            </div>

            {{-- Akses Cepat --}}
            <div>
                <h3 class="mb-3 font-bold">Akses Cepat</h3>
                <ul class="space-y-1">
                    <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                    <li><a href="{{ route('product.index') }}" class="hover:underline">Produk</a></li>
                    <li><a href="#" class="hover:underline">Artikel</a></li>
                </ul>
            </div>

            {{-- Kategori Populer --}}
            <div>
                <h3 class="mb-3 font-bold">Kategori Populer</h3>
                <ul class="space-y-1">
                    <li><a href="{{ route('product.index', ['category' => 'destinasi-wisata']) }}"
                            class="hover:underline">Destinasi Wisata</a></li>
                    <li><a href="{{ route('product.index', ['category' => 'makanan-minuman']) }}"
                            class="hover:underline">Makanan & Minuman</a></li>
                    <li><a href="{{ route('product.index', ['category' => 'kerajinan-handmade']) }}"
                            class="hover:underline">Kerajinan & Handmade</a></li>
                </ul>
            </div>

            {{-- Kontak Kami --}}
            <div>
                <h3 class="mb-3 font-bold">Kontak Kami</h3>
                <ul class="space-y-1">
                    <li>Email: <a href="#" class="text-gray-200 hover:underline">sangihetrip@gmail.com</a></li>
                    <li>Instagram: <a href="#" class="text-gray-200 hover:underline">@sangihetrip</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
