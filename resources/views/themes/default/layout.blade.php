<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic SEO Tags -->
    <title>{{ $seo->meta_title ?? config('app.name') }}</title>
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero { background: #f8f9fa; padding: 100px 0; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Ratannam Gold</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Collections</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ date('Y') }} Ratannam Gold. All rights reserved.</p>
    </footer>
</body>
</html>
