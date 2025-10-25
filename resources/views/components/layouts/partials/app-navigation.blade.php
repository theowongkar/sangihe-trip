<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-20 transition-opacity scrollbar-custom md:hidden"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
</div>

{{-- Sidebar Utama --}}
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 transform bg-[#115e6d] text-white transition duration-300 md:translate-x-0 md:static md:inset-0 flex flex-col">

    {{-- Header Sidebar --}}
    <div class="flex items-center mb-5 space-x-3 px-4 py-4">
        {{-- Logo Gambar --}}
        <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Aplikasi"
            class="w-10 h-10 object-contain rounded-full">

        {{-- Tulisan --}}
        <div class="leading-tight">
            <h2 class="font-semibold text-2xl">SangiheTrip</h2>
        </div>
    </div>

    {{-- Navigasi Menu --}}
    <nav class="flex-1 overflow-y-auto px-4 space-y-5">
        {{-- Menu --}}
        <div class="space-y-2">
            <h1 class="mb-1 text-xs text-gray-300 font-bold uppercase">Menu</h1>
            <a href="{{ route('dashboard') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-house-door-fill" viewBox="0 0 16 16">
                    <path
                        d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('dashboard.user.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.user.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path
                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                </svg>
                <span>Data User</span>
            </a>

            <a href="{{ route('dashboard.product-category.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.product-category.index') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-tags-fill" viewBox="0 0 16 16">
                    <path
                        d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                    <path
                        d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z" />
                </svg>
                <span>Kategori Produk</span>
            </a>

            <a href="{{ route('dashboard.article.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.article.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-earmark-post" viewBox="0 0 16 16">
                    <path
                        d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                    <path
                        d="M4 6.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5H7a.5.5 0 0 1 0 1H4.5a.5.5 0 0 1-.5-.5" />
                </svg>
                <span>Artikel</span>
            </a>
        </div>
    </nav>
</div>
