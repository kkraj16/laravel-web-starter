<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo->meta_title ?? config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/system/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uploads/system/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('uploads/system/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    
    @if(!request()->routeIs('products.show'))
    <!-- Dynamic SEO Tags -->
    <meta name="description" content="{{ $seo->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $seo->meta_keywords ?? '' }}">
    <link rel="canonical" href="{{ $seo->canonical_url ?? url()->current() }}">
    <meta name="robots" content="{{ $seo->robots ?? 'index, follow' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo->og_title ?? ($seo->meta_title ?? config('app.name')) }}">
    <meta property="og:description" content="{{ $seo->og_description ?? ($seo->meta_description ?? '') }}">
    <meta property="og:image" content="{{ $seo->og_image ? asset($seo->og_image) : asset('uploads/system/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $seo->og_title ?? ($seo->meta_title ?? config('app.name')) }}">
    <meta property="twitter:description" content="{{ $seo->og_description ?? ($seo->meta_description ?? '') }}">
    <meta property="twitter:image" content="{{ $seo->og_image ? asset($seo->og_image) : asset('uploads/system/logo.png') }}">
    @endif
    <!-- Alpine.js Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Bootstrap Icons (for generic icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- QR Code Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white flex flex-col min-h-screen">
    
    <x-frontend.top-bar />
    
    <x-frontend.header />

    <main class="flex-grow">
        @yield('content')
    </main>


    <x-frontend.footer />

    <!-- WhatsApp Inquiry Modal Container -->
    <div id="whatsapp-modal-container"></div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Product Inquiry Modal Script -->
    <link rel="stylesheet" href="{{ asset('css/product-inquiry-modal.css') }}">
    <script src="{{ asset('js/product-inquiry-modal.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
