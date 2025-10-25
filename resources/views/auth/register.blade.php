<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Register</x-slot>

    {{-- Bagian Register --}}
    <section>
        {{-- Flash Message --}}
        <x-alerts.flash-message />

        {{-- Konten Utama --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8">
            <div
                class="flex flex-col w-full max-w-sm mx-auto p-5 border border-gray-300 rounded-lg shadow overflow-hidden">
                {{-- Judul Card --}}
                <h1 class="mb-5 text-xl font-bold">Register</h1>

                {{-- Form Register --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    <x-forms.input type="text" name="name" value="{{ old('name') }}" placeholder="Username" />
                    <x-forms.input type="text" name="phone" value="{{ old('phone') }}" placeholder="No. Telp" />
                    <x-forms.input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                    <x-forms.input type="password" name="password" placeholder="Password" />
                    <x-forms.input type="password" name="password_confirmation" placeholder="Konfirmasi Password" />

                    <x-buttons.primary-button type="submit" class="w-full">Daftar</x-buttons.primary-button>
                </form>

                {{-- Login --}}
                <p class="mt-5 text-center">Sudah punya akun? <a href="{{ route('login') }}"
                        class="text-blue-600 hover:underline">login sekarang!</a></p>
            </div>
        </div>
    </section>

</x-guest-layout>
