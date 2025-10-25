<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Metadata --}}
    <meta name="description"
        content="Aplikasi Rencana Perjalanan Wisata Kepulauan Sangihe. Sistem berbasis web yang membantu wisatawan membuat dan mengatur itinerary wisata secara mudah dan efisien.">
    <meta name="keywords" content="Sangihe Trip, promosi umkm, media promosi">
    <meta name="author" content="Silvana Landeng">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="Sangihe Trip - {{ $title }}">
    <meta property="og:description" content="Aplikasi Rencana Perjalanan Wisata Kepulauan Sangihe.">
    <meta property="og:image" content="{{ asset('img/application-logo.svg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/application-logo.svg') }}" type="image/x-icon">

    {{-- Judul Halaman --}}
    <title>Dashboard SangiheTrip</title>

    {{-- Framework Frontend --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Tambahan --}}
    @stack('scripts')

    {{-- Default CSS --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="antialiased">

    <div x-data="{ sidebarOpen: false }" class="relative h-screen flex overflow-hidden" x-cloak>

        {{-- Navigasi --}}
        @include('components.layouts.partials.app-navigation')

        {{-- Layout Utama --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header --}}
            @include('components.layouts.partials.app-header')

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-5 bg-gray-200">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>

</html>
