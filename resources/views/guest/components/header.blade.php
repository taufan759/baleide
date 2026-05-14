 <!-- Offcanvas Area start  -->
<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a>
                            <img src="{{ asset('assets/img/logo-black.png')}}" alt="logo-img">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <p class="text d-none d-xl-block">
                    Belajar lebih mudah, kapan saja, di mana saja. Temukan ilmu baru dan kembangkan potensi terbaikmu.
                </p>
                <div class="mobile-menu fix mb-3"></div>
                <div class="offcanvas__contact">
                    <h4>Info Kontak Kami</h4>
                    <ul>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon">
                                <i class="fal fa-map-marker-alt"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a target="_blank" href="#">Nanjung Industrial Park Kab Bandung, Jawa Barat</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="mailto:mail@baleide.com"><span
                                        class="mailto:mail@baleide.com">mail@baleide.com</span></a>
                            </div>
                        </li>
                    </ul>
                    <div class="header-button mt-4">
                        <a href="/contact" class="theme-btn text-center">
                            Hubungi Kami <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </div>

                    <div class="header-button mt-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="theme-btn text-center" style="background-color: #012E4A;">
                                <i class="fa-solid fa-gauge"></i> Dashboard Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="theme-btn text-center" style="background-color: #012E4A;">
                                <i class="fa-solid fa-right-to-bracket"></i> Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div>

<div class="header-top-1">
    <div class="container">
        <div class="header-top-wrapper">
            <ul class="contact-list">
                <li>
                    <i class="fa-regular fa-phone"></i>
                    <a href="tel:+6289653600997">+62 896-5360-0997</a>
                </li>
                <li>
                    <i class="far fa-envelope"></i>
                    <a href="mailto:mail@baleide.com">mail@baleide.com</a>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <span id="realtime-clock">Memuat waktu...</span>
                </li>
            </ul>
            <ul class="list">
                @auth
                    <li><i class="fa-light fa-gauge"></i>
                        <a href="{{ url('/dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                @else
                    <li><i class="fa-light fa-user"></i>
                        <a href="{{ route('login') }}">
                            Masuk
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</div>

<header class="header-1 sticky-header">
    <div class="mega-menu-wrapper">
        <div class="header-main">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-10 col-xl-8 col-xxl-10">
                        <div class="header-left">
                            <div class="logo">
                                <a href="{{ url('/') }}" class="header-logo">
                                    <img src="{{ asset('assets/img/logo-baleide-white.webp')}}" alt="logo-img">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav>
                                        <ul>
                                            <li>
                                                <a href="{{ url('/') }}">Beranda</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/ebook') }}">E-Book</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/artikel') }}">Artikel</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/contact') }}">Kontak</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 col-xl-4 col-xxl-2">
                        <div class="header-right">
                            <div class="menu-cart">
                               <a href="{{ url('/cart') }}" class="cart-icon">
                                    <i class="fa-regular fa-cart-shopping"></i>
                                    <span class="cart-badge" id="cart-count">0</span>
                                </a>
                                <div class="header-humbager ml-30">
                                    <a class="sidebar__toggle" href="javascript:void(0)">
                                        <div class="bar-icon-2">
                                            <img src="{{ asset('client/assets/img/icon/icon-13.svg')}}" alt="img">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<header class="header-1">
    <div class="mega-menu-wrapper">
        <div class="header-main">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-10 col-xl-8 col-xxl-10">
                        <div class="header-left">
                            <div class="logo">
                                <a href="{{ url('/') }}" class="header-logo">
                                    <img src="{{ asset('assets/img/logo-baleide-white.webp')}}" alt="logo-img">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li>
                                                <a href="{{ url('/') }}">Beranda</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/ebook') }}">E-Book</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/artikel') }}">Artikel</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/contact') }}">Kontak</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 col-xl-4 col-xxl-2">
                        <div class="header-right">
                            <div class="menu-cart">
                                <a href="{{ url('/cart') }}" class="cart-icon">
                                    <i class="fa-regular fa-cart-shopping"></i>
                                    <span class="cart-badge" id="cart-count">0</span>
                                </a>
                                <div class="header-humbager ml-30">
                                    <a class="sidebar__toggle" href="javascript:void(0)">
                                        <div class="bar-icon-2">
                                            <img src="{{ asset('client/assets/img/icon/icon-13.svg')}}" alt="img">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>