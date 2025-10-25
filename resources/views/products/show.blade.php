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
                <div class="md:col-span-2 space-y-8">
                    <div class="p-5 space-y-3 border border-gray-300 rounded-lg shadow">
                        {{-- Konten --}}
                        <div>
                            <h2 class="text-lg font-medium">{{ $product->name }}</h2>
                            <p>{{ $product->description }}</p>
                        </div>

                        {{-- Informasi Tambahan --}}
                        <div class="flex flex-col space-y-2">
                            <span class="inline-flex items-center gap-2"><x-icons.tags-fill /> Rp.
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <p class="inline-flex items-center gap-2"><x-icons.person-box /> {{ $product->owner_name }}
                            </p>
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

                    {{-- Rating & Ulasan --}}
                    <div class="p-5 space-y-3 border border-gray-300 rounded-lg shadow">
                        <h2 class="text-lg font-medium">Rating & Ulasan</h2>

                        <div class="flex items-center gap-2 text-gray-800 text-base sm:text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.948a1 1 0 00.95.69h4.149c.969 0 1.371 1.24.588 1.81l-3.36 2.443a1 1 0 00-.364 1.118l1.286 3.949c.3.921-.755 1.688-1.54 1.118l-3.36-2.442a1 1 0 00-1.176 0l-3.36 2.442c-.785.57-1.84-.197-1.54-1.118l1.286-3.949a1 1 0 00-.364-1.118L2.075 9.375c-.783-.57-.38-1.81.588-1.81h4.149a1 1 0 00.95-.69l1.287-3.948z" />
                            </svg>
                            <span class="font-semibold text-gray-900">
                                {{ number_format($product->averageRating() ?? 0, 1) }}
                            </span>
                            <span class="text-gray-500 font-medium">
                                ({{ $reviews->total() ?? $product->reviews()->count() }} Ulasan)
                            </span>
                        </div>

                        <x-alerts.flash-message />

                        @auth
                            <form action="{{ route('product-review.upsert', $product) }}" method="POST" class="space-y-2">
                                @csrf
                                <x-forms.select label="Rating" name="rating" :options="[
                                    1 => '1 - Kurang',
                                    2 => '2 - Cukup',
                                    3 => '3 - Baik',
                                    4 => '4 - Sangat Baik',
                                    5 => '5 - Sangat Memuaskan',
                                ]" :selected="old('rating', optional($userReview)->rating)" />
                                <x-forms.textarea label="Ulasan" name="comment" :value="old('comment', optional($userReview)->comment)" />
                                <x-buttons.primary-button type="submit" class="w-full">
                                    {{ $userReview ? 'Ubah' : 'Simpan' }}
                                </x-buttons.primary-button>
                            </form>
                        @else
                            <p class="text-sm text-gray-600">Silakan <a href="{{ route('login') }}"
                                    class="text-blue-600">login</a> untuk memberikan ulasan.</p>
                        @endauth

                        @forelse ($reviews as $review)
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4 hover:shadow-md transition-all duration-300">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-base">
                                            {{ $review->user->name }}
                                        </h3>
                                        <time class="text-sm text-gray-500">
                                            {{ $review->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        {{-- Bintang rating --}}
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#facc15"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#facc15"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.48 3.5a.75.75 0 011.04 0l2.24 2.27 2.88.42a.75.75 0 01.42 1.28l-2.08 2.03.49 2.86a.75.75 0 01-1.09.79L12 12.7l-2.58 1.35a.75.75 0 01-1.09-.79l.49-2.86-2.08-2.03a.75.75 0 01.42-1.28l2.88-.42L11.48 3.5z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#d1d5db"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.48 3.5a.75.75 0 011.04 0l2.24 2.27 2.88.42a.75.75 0 01.42 1.28l-2.08 2.03.49 2.86a.75.75 0 01-1.09.79L12 12.7l-2.58 1.35a.75.75 0 01-1.09-.79l.49-2.86-2.08-2.03a.75.75 0 01.42-1.28l2.88-.42L11.48 3.5z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ $review->comment }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-6 italic">Belum ada ulasan</p>
                        @endforelse

                        <div class="mt-5">
                            {{ $reviews->links('vendor.pagination.custom') }}
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
