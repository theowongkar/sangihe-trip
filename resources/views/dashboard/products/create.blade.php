<x-app-layout>

    <x-slot name="title">Tambah Produk</x-slot>

    <section>
        <div class="p-5 bg-white border border-gray-300 rounded-lg shadow">
            <form action="{{ route('dashboard.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-forms.select name="status" label="Status" :options="['Draf' => 'Draf', 'Terbit' => 'Terbit', 'Arsip' => 'Arsip']" :selected="old('status')" />
                    <x-forms.select name="product_category_id" label="Kategori Produk" :options="$productCategories->pluck('name', 'id')->toArray()"
                        :selected="old('product_category_id')" />
                    <x-forms.input name="name" label="Nama Produk" />
                    <x-forms.textarea name="description" label="Deskripsi" />
                    <x-forms.input type="number" name="price" label="Harga" />
                    <x-forms.input name="owner_name" label="Nama Pemilik" />
                    <x-forms.input name="owner_phone" label="Telepon Pemilik" />
                    <x-forms.textarea name="address" label="Alamat" />
                    <x-forms.input name="gmaps_link" label="Link Google Maps" />

                    {{-- Facility checkboxes --}}
                    <div class="col-span-1 md:col-span-2">
                        @php
                            $availableFacilities = ['WiFi', 'Toilet', 'Parkir', 'Akses Jalan Memadai'];
                            $selectedFacilities = old('facility', []);
                        @endphp

                        <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($availableFacilities as $f)
                                <label
                                    class="inline-flex items-center space-x-2 bg-white border border-gray-200 rounded-md px-3 py-2">
                                    <input type="checkbox" name="facility[]" value="{{ $f }}"
                                        {{ in_array($f, $selectedFacilities) ? 'checked' : '' }}
                                        class="form-checkbox h-4 w-4 text-indigo-600" />
                                    <span class="text-sm">{{ $f }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Images upload --}}
                <div class="mt-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Gambar Produk (boleh lebih dari
                        1)</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="block w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" />
                </div>

                {{-- Operating hours --}}
                <div class="mt-6" x-data>
                    <h3 class="block mb-3 text-sm font-medium text-gray-700">Jam Operasional</h3>

                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    @endphp

                    @foreach ($days as $day)
                        @php
                            $oldOpen = old("hours.$day.open_time", '00:00');
                            $oldClose = old("hours.$day.close_time", '00:00');
                            $oldOpenStatus = old("hours.$day.is_open", false);
                        @endphp

                        <div class="mb-3" x-data="{ open: {{ $oldOpenStatus ? 'true' : 'false' }} ?? false }">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-3">
                                {{-- Nama hari --}}
                                <div class="w-full sm:w-28 font-medium text-gray-700">{{ $day }}</div>

                                {{-- Input jam buka & tutup --}}
                                <div class="flex flex-col sm:flex-row gap-2 w-full">
                                    <input type="time" name="hours[{{ $day }}][open_time]"
                                        x-bind:disabled="!open"
                                        x-bind:value="open ? '{{ $oldOpen }}' : '00:00'"
                                        class="w-full sm:w-1/2 border border-gray-300 rounded px-2 py-1 focus:border-blue-500 focus:ring-blue-500">
                                    <input type="time" name="hours[{{ $day }}][close_time]"
                                        x-bind:disabled="!open"
                                        x-bind:value="open ? '{{ $oldClose }}' : '00:00'"
                                        class="w-full sm:w-1/2 border border-gray-300 rounded px-2 py-1 focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                {{-- Checkbox buka --}}
                                <label class="flex items-center gap-1 text-sm whitespace-nowrap">
                                    <input type="checkbox" name="hours[{{ $day }}][is_open]" value="1"
                                        x-model="open"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    Buka
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <x-buttons.primary-button href="{{ route('dashboard.product.index') }}"
                        class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                    <x-buttons.primary-button type="submit">Simpan Produk</x-buttons.primary-button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>
