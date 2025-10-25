<x-app-layout>

    <x-slot name="title">Ubah Artikel</x-slot>

    <section>
        <div class="p-4 bg-white border border-gray-300 rounded-lg shadow ">
            <form action="{{ route('dashboard.article.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('dashboard.articles._form')

                <div class="mt-4 flex justify-end gap-2">
                    <x-buttons.primary-button href="{{ route('dashboard.article.index') }}"
                        class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                    <x-buttons.primary-button type="submit">Perbarui Artikel</x-buttons.primary-button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>
