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

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/application-logo.svg') }}" type="image/x-icon">

    {{-- Judul Halaman --}}
    <title>Sangihe Trip - {{ $title }}</title>

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

<body class="font-sans antialiased">

    <div class="flex flex-col min-h-screen">
        {{-- Navigasi --}}
        @include('components.layouts.partials.guest-navigation')

        {{-- Layout Utama --}}
        <main class="flex-1 bg-gray-50">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        @include('components.layouts.partials.guest-footer')
    </div>

</body>

</html>
