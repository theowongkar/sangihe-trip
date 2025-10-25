<x-app-layout>

    <x-slot name="title">Tambah Artikel</x-slot>

    <section>
        <div class="p-5 bg-white border border-gray-300 rounded-lg shadow">
            <form action="{{ route('dashboard.article.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('dashboard.articles._form')

                <div class="mt-4 flex justify-end gap-2">
                    <x-buttons.primary-button href="{{ route('dashboard.article.index') }}"
                        class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                    <x-buttons.primary-button type="submit">Simpan Artikel</x-buttons.primary-button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>
