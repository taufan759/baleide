<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="theme-color" content="#625AFA">
<meta name="google" content="notranslate">
<meta translate="no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('meta_title', 'Baleide - Digital E-book Platform')</title>

{{-- SEO Meta Tags --}}
<meta name="description" content="@yield('meta_description', 'Baleide - Platform E-book modern untuk akses buku digital terlengkap, manajemen pustaka, dan pengalaman membaca yang nyaman.')">
<meta name="keywords" content="@yield('meta_keywords', 'baleide, ebook platform, buku digital, perpustakaan digital, baca buku online')">
<meta name="author" content="@yield('meta_author', 'Baleide')">
<meta name="robots" content="index, follow">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('meta_title', 'Baleide - Platform E-book Digital & Pustaka Online')">
<meta property="og:description" content="@yield('meta_description', 'Nikmati akses ribuan koleksi e-book berkualitas dalam satu platform yang mudah digunakan hanya di Baleide.')">
<meta property="og:image" content="@yield('meta_image', asset('assets/img/logo-black.png'))">
<meta property="og:url" content="{{ request()->fullUrl() }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title', 'Baleide - Platform E-book Digital & Pustaka Online')">
<meta name="twitter:description" content="@yield('meta_description', 'Akses ribuan buku digital dengan mudah dan nyaman melalui platform Baleide.')">
<meta name="twitter:image" content="@yield('meta_image', asset('assets/img/logo-black.png'))">

{{-- Favicon --}}
<link rel="icon" href="{{ asset('assets/img/logo-black.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/img/logo-black.png') }}">