<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">{{ $product->name }}</x-slot>

    {{-- Bagian Lihat Produk --}}
    <section>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Gambar dan Deskripsi --}}
                <div class="md:col-span-2" x-data="{ activeImage: '{{ $product->primaryImage?->image_path ? asset('storage/' . $product->primaryImage->image_path) : asset('img/placeholder-image.webp') }}' }">
                    <div
                        class="flex justify-center items-center w-full h-56 md:h-72 mx-auto bg-gray-100 border border-gray-300 rounded-lg overflow-hidden mb-3">
                        <img :src="activeImage"
                            alt="{{ implode(' ', array_slice(explode(' ', $product->name), 0, 2)) }}"
                            class="object-cover h-full aspect-square transition-all duration-300">
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach ($product->images as $productImage)
                            @php
                                $imagePath = $productImage->image_path
                                    ? asset('storage/' . $productImage->image_path)
                                    : asset('img/placeholder-image.webp');
                            @endphp
                            <div class="flex-shrink-0 w-20 h-20 cursor-pointer border border-gray-300 rounded-lg overflow-hidden"
                                @click="activeImage = '{{ $imagePath }}'">
                                <img src="{{ $imagePath }}"
                                    alt="{{ implode(' ', array_slice(explode(' ', $product->name), 0, 2)) }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bagian Utama --}}
                <div>
                    <div class="mb-5 space-y-4">
                        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                        <div class="flex flex-col space-y-2">
                            <span class="text-xl font-medium">Rp.
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-block w-fit px-2 py-1 bg-yellow-500/30 text-sm border border-yellow-500 rounded-lg">
                                    ⭐ {{ number_format($product->averageRating() ?? 0, 1) }}
                                </span>
                                <span class="text-sm text-gray-800">
                                    {{ $reviews->total() ?? $product->reviews()->count() }} Ulasan
                                </span>
                            </div>
                            <span
                                class="inline-block w-fit px-2 py-1 bg-blue-200 text-sm border border-blue-500 rounded-md">{{ $product->category->name }}</span>
                        </div>
                        <p class="line-clamp-4">{{ $product->description }}</p>
                    </div>
                </div>
            </div>


            {{-- Detail Produk --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 p-5 space-y-3 border border-gray-300 rounded-lg shadow">
                    {{-- Konten --}}
                    <div>
                        <h2 class="text-lg font-medium">{{ $product->name }}</h2>
                        <p>{{ $product->description }}</p>
                    </div>

                    {{-- Informasi Tambahan --}}
                    <div class="flex flex-col space-y-2">
                        <span class="inline-flex items-center gap-2"><x-icons.tags-fill /> Rp.
                            {{ number_format($product->price, 0, ',', '.') }}</span>
                        <p class="inline-flex items-center gap-2"><x-icons.person-box /> {{ $product->owner_name }}</p>
                        <p class="inline-flex items-center gap-2"><x-icons.telephone-plus-fill />
                            {{ $product->owner_phone }}</p>
                    </div>

                    {{-- Fasilitas --}}
                    <div>
                        <h2 class="font-medium">Fasilitas:</h2>
                        @foreach ($product->facility as $facility)
                            <p class="inline">{{ $facility }},</p>
                        @endforeach
                    </div>

                    {{-- Jam Operasional --}}
                    <div>
                        <h2 class="font-medium">Jam Operasional:</h2>
                        <div class="mt-2">
                            @if ($product->operatingHours->count() > 0)
                                <div class="grid grid-cols-2 gap-2 w-full md:max-w-sm">
                                    @foreach ($product->operatingHours as $oh)
                                        <h4 class="whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $oh->day }}
                                        </h4>
                                        <div class="whitespace-nowrap text-sm text-gray-700">
                                            @if ($oh->is_open)
                                                {{ \Carbon\Carbon::parse($oh->open_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($oh->close_time)->format('H:i') }}
                                            @else
                                                <span class="text-red-600">Tutup</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Belum ada informasi jam operasional</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="font-medium">Alamat:</h2>
                    <address>{{ $product->address }}</address>
                    <iframe src="{{ $product->gmaps_link }}" width="100%" height="200" class="mt-2 rounded-lg"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
