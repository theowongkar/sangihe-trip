<nav class="bg-[#115e6d] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-2 py-4">
            {{-- Logo --}}
            <div class="flex flex-1">
                <a href="{{ route('home') }}" class="flex items-center justify-start gap-x-2">
                    <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Aplikasi" class="w-10 h-10" />
                    <h3 class="font-bold text-xl md:text-2xl">SangiheTrip</h3>
                </a>
            </div>

            {{-- Search Form --}}
            <ul class="flex justify-center gap-4">
                <li><a href="{{ route('home') }}" class="font-medium">Beranda</a></li>
                <li><a href="#" class="font-medium">Produk</a></li>
                <li><a href="#" class="font-medium">Perjalanan</a></li>
                <li><a href="#" class="font-medium">Artikel</a></li>
            </ul>

            {{-- Navigasi User --}}
            <div class="flex flex-1 justify-end">
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" aria-label="User Button"
                            class="p-2 rounded-full cursor-pointer hover:bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                        </button>

                        <div x-show="open" x-cloak @click.outside="open = false" x-transition
                            class="absolute right-1/2 translate-x-1/2 lg:right-0 lg:translate-x-0 w-48 mt-2 bg-white border border-gray-300 rounded-lg shadow overflow-hidden z-50">
                            <div class="block px-4 py-2 leading-none border-b border-gray-500">
                                <h3 class="text-black font-semibold line-clamp-1">{{ auth()->user()->name }}</h3>
                                <p class="text-sm text-gray-800">{{ auth()->user()->role }}</p>
                            </div>

                            <a href="#" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">Profil
                                Saya</a>

                            <form action="#" method="POST">
                                @csrf

                                <button type="submit"
                                    class="block w-full px-4 py-2 text-sm text-start text-red-600 cursor-pointer hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="#" aria-label="User Button" class="p-2 rounded-full hover:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
