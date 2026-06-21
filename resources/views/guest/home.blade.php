@extends('guest')

@section('title', 'Beranda')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* PWA Install Bubble */
        .pwa-install-bubble {
            position: fixed;
            bottom: 120px;
            right: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 16px;
            max-width: 320px;
            z-index: 9997;
            animation: slideInUp 0.3s ease-out;
            display: none;
        }

        .pwa-install-bubble.show {
            display: block;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pwa-install-bubble-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #999;
            padding: 0;
            width: 24px;
            height: 24px;
        }

        .pwa-install-bubble-content {
            padding-right: 20px;
        }

        .pwa-install-bubble-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .pwa-install-bubble-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .pwa-install-bubble-buttons {
            display: flex;
            gap: 8px;
        }

        .pwa-install-btn {
            padding: 8px 14px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pwa-install-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            flex: 1;
        }

        .pwa-install-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .pwa-install-btn-secondary {
            background: #f0f0f0;
            color: #666;
        }

        .pwa-install-btn-secondary:hover {
            background: #e0e0e0;
        }

        @media (max-width: 480px) {
            .pwa-install-bubble {
                bottom: 100px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="hero-section hero-1 fix">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-8 col-lg-6">
                    <div class="hero-items">
                        <div class="book-shape">
                            <img src="{{ asset('assets/img/shape.png') }}" alt="shape-img">
                        </div>
                        <div class="frame-shape1 float-bob-x">
                            <img src="{{ asset('client/assets/img/hero/frame.png')}}" alt="shape-img">
                        </div>
                        <div class="frame-shape2 float-bob-y">
                            <img src="{{ asset('client/assets/img/hero/frame-2.png')}}" alt="shape-img">
                        </div>
                        <div class="frame-shape3">
                            <img src="{{ asset('client/assets/img/hero/xstar.png')}}" alt="img">
                        </div>
                        <div class="frame-shape4 float-bob-x">
                            <img src="{{ asset('client/assets/img/hero/frame-shape.png')}}" alt="img">
                        </div>
                        <div class="bg-shape1">
                            <img src="{{ asset('client/assets/img/hero/bg-shape.png')}}" alt="img">
                        </div>
                        <div class="bg-shape2">
                            <img src="{{ asset('client/assets/img/hero/bg-shape2.png')}}" alt="shape-img">
                        </div>
                        <div class="hero-content">
                            <h6 class="wow fadeInUp" data-wow-delay=".3s">Baleide</h6>
                            <h1 class="wow fadeInUp" data-wow-delay=".5s">Platform Belajar Online <br> Untuk Skill Nyata</h1>
                            <div class="form-clt wow fadeInUp" data-wow-delay=".9s">
                                <a href="/ebook" class="theme-btn">
                                    Baca Buku Sekarang <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4 col-lg-6">
                    <div class="girl-image">
                        <img class=" float-bob-x" src="{{ asset('assets/img/banner-3.webp') }}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="feature-section fix section-padding">
        <div class="container">
            <div class="feature-wrapper">
                <div class="feature-box-items wow fadeInUp" data-wow-delay=".2s">
                    <div class="icon"><i class="fas fa-file-download"></i></div>
                    <div class="content">
                        <h3>Akses Instan</h3>
                        <p>Langsung baca setelah bayar</p>
                    </div>
                </div>
                <div class="feature-box-items wow fadeInUp" data-wow-delay=".4s">
                    <div class="icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="content">
                        <h3>Pembayaran Aman</h3>
                        <p>Terverifikasi oleh Midtrans</p>
                    </div>
                </div>
                <div class="feature-box-items wow fadeInUp" data-wow-delay=".6s">
                    <div class="icon"><i class="fas fa-book-reader"></i></div>
                    <div class="content">
                        <h3>Kualitas Terbaik</h3>
                        <p>E-book PDF jernih & asli</p>
                    </div>
                </div>
                <div class="feature-box-items wow fadeInUp" data-wow-delay=".8s">
                    <div class="icon"><i class="fas fa-tags"></i></div>
                    <div class="content">
                        <h3>Harga Spesial</h3>
                        <p>Promo menarik setiap hari</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Chatbot CTA Section --}}
    <section class="section-padding pt-0">
        <div class="container">
            <div class="row align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 60px 40px; position: relative; overflow: hidden;">
                <div class="position-absolute" style="top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div class="position-absolute" style="bottom: -80px; left: -80px; width: 250px; height: 250px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                
                <div class="col-lg-7 mb-4 mb-lg-0" style="position: relative; z-index: 2;">
                    <div class="text-white">
                        <h6 class="text-white mb-3 wow fadeInUp" data-wow-delay=".2s" style="font-size: 14px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9;">
                            <i class="fas fa-robot"></i> Fitur Baru!
                        </h6>
                        <h2 class="text-white mb-3 wow fadeInUp" data-wow-delay=".3s" style="font-size: 36px; font-weight: 700;">
                            Bingung Mau Baca Buku Apa?
                        </h2>
                        <p class="text-white mb-4 wow fadeInUp" data-wow-delay=".4s" style="font-size: 18px; opacity: 0.95; line-height: 1.6;">
                            <strong>Halo, Chief!</strong> 👋 Biarkan Asisten AI kami bantu kamu nemuin buku yang <strong>pas dengan mood</strong> dan kebutuhan kamu hari ini.
                        </p>
                        <ul class="text-white mb-0 wow fadeInUp" data-wow-delay=".5s" style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 12px; font-size: 16px;">
                                <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                                Rekomendasi personal berdasarkan mood
                            </li>
                            <li style="margin-bottom: 12px; font-size: 16px;">
                                <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                                Jawaban instant dengan teknologi AI
                            </li>
                            <li style="margin-bottom: 12px; font-size: 16px;">
                                <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                                100% gratis, tanpa perlu daftar
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-5 text-center wow fadeInUp" data-wow-delay=".6s" style="position: relative; z-index: 2;">
                    <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 15px; padding: 30px; border: 2px solid rgba(255,255,255,0.2);">
                        <div style="font-size: 100px; margin-bottom: 20px; line-height: 1;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="100" height="100">
                                <circle cx="32" cy="32" r="30" fill="#E8E8E8"/>
                                <rect x="20" y="24" width="8" height="8" rx="2" fill="#00D4FF"/>
                                <rect x="36" y="24" width="8" height="8" rx="2" fill="#00D4FF"/>
                                <rect x="26" y="40" width="12" height="3" rx="1.5" fill="#333"/>
                                <rect x="28" y="14" width="8" height="6" rx="2" fill="#FF5252"/>
                                <circle cx="16" cy="10" r="3" fill="#666"/>
                                <rect x="16" y="10" width="2" height="8" fill="#666"/>
                                <circle cx="48" cy="10" r="3" fill="#666"/>
                                <rect x="47" y="10" width="2" height="8" fill="#666"/>
                            </svg>
                        </div>
                        <h4 class="text-white mb-3">Asisten Baleide Siap Bantu!</h4>
                        <p class="text-white mb-4" style="opacity: 0.9;">Click tombol chat di kiri bawah atau:</p>
                        <button onclick="toggleChatbot()" class="btn btn-light btn-lg" style="padding: 15px 40px; border-radius: 50px; font-weight: 600; font-size: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); transition: all 0.3s;">
                            <i class="fas fa-comments"></i> Mulai Chat Sekarang
                        </button>
                        <p class="text-white mt-3 mb-0" style="font-size: 13px; opacity: 0.8;">
                            <i class="fas fa-users"></i> Sudah membantu <strong>500+</strong> pembaca
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-section section-padding fix pt-0">
        <div class="container">
            <div class="section-title-area">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Buku Populer</h2>
                </div>
                <a href="{{ url('ebook') }}" class="theme-btn transparent-btn wow fadeInUp" data-wow-delay=".5s">
                    Lihat Semua <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
            <div class="swiper book-slider">
                <div class="swiper-wrapper">
                    @foreach($popularBooks as $book)
                    <div class="swiper-slide">
                        <div class="shop-box-items style-2">
                            <div class="book-thumb center">
                                @php
                                    $cover = $book->photos->first();
                                    $imgUrl = $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png');
                                @endphp
                                <a href="{{ url('ebook/' . $book->slug) }}">
                                    <img src="{{ $imgUrl }}" alt="{{ $book->title }}">
                                </a>
                                <ul class="shop-icon d-grid justify-content-center align-items-center">
                                    <li><a href="{{ url('ebook/' . $book->slug) }}"><i class="far fa-eye"></i></a></li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="addToCart('{{ $book->id }}', '{{ $book->title }}')">
                                            <i class="fa-solid fa-basket-shopping"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-content">
                                <h5>{{ $book->category->name }}</h5>
                                <h3><a href="{{ url('ebook/' . $book->slug) }}">{{ Str::limit($book->title, 40) }}</a></h3>
                                <ul class="price-list">
                                    <li>Rp {{ number_format($book->price, 0, ',', '.') }}</li>
                                </ul>
                                <ul class="author-post">
                                    <li class="authot-list">
                                        <span class="icon"><i class="fa-regular fa-file-pdf text-danger"></i></span>
                                        <span class="content ml-2">Format: {{ strtoupper($book->file_format) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-button">
                                <a href="{{ url('checkout/' . $book->slug) }}" class="theme-btn">
                                    Beli Cepat
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="book-catagories-section fix section-padding">
        <div class="container">
            <div class="book-catagories-wrapper">
                <div class="section-title text-center">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Kategori Populer</h2>
                </div>
                <div class="array-button">
                    <button class="array-prev"><i class="fal fa-arrow-left"></i></button>
                    <button class="array-next"><i class="fal fa-arrow-right"></i></button>
                </div>
                <div class="swiper book-catagories-slider">
                    <div class="swiper-wrapper">
                        @foreach($topBooks as $index => $book)
                            <div class="swiper-slide">
                                <div class="book-catagories-items">
                                    <div class="book-thumb">
                                        @php
                                            $cover = $book->photos->first();
                                            $imgUrl = $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png');
                                        @endphp
                                        <img src="{{ $imgUrl }}" alt="{{ $book->title }}" width="100" class="rounded">
                                        <div class="circle-shape">
                                            <img src="{{ asset('client/assets/img/book-categori/circle-shape.png')}}" alt="shape-img">
                                        </div>
                                    </div>
                                    <div class="number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <h3>
                                        <a href="{{ url('ebook/' . $book->slug) }}">{{ Str::limit($book->title, 25) }}</a>
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

        <section class="top-ratting-book-section fix section-padding section-bg">
        <div class="container">
            <div class="top-ratting-book-wrapper">
                <div class="section-title-area">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">Buku Baru Dirilis</h2>
                    </div>
                    <a href="{{ url('ebook') }}" class="theme-btn transparent-btn wow fadeInUp" data-wow-delay=".5s">
                        Lihat Semua <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
                <div class="row">
                    @foreach($latestBooks as $book)
                    <div class="col-xl-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="top-ratting-box-items">
                            <div class="book-thumb">
                                @php
                                    $cover = $book->photos->first();
                                    $imgUrl = $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png');
                                @endphp
                                <a href="{{ url('ebook/' . $book->slug) }}">
                                    <img src="{{ $imgUrl }}" alt="{{ $book->title }}">
                                </a>
                            </div>
                            <div class="book-content">
                                <div class="title-header">
                                    <div>
                                        <h5>{{ $book->category->name }}</h5>
                                        <h3><a href="{{ url('ebook/' . $book->slug) }}">{{ Str::limit($book->title, 35) }}</a></h3>
                                    </div>
                                    <ul class="shop-icon d-flex justify-content-center align-items-center">
                                        <li><a href="{{ url('ebook/' . $book->slug) }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                                <span class="mt-10">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                <div class="shop-btn">
                                    <a href="javascript:void(0)" onclick="addToCart('{{ $book->id }}', '{{ $book->title }}')" class="theme-btn">
                                        <i class="fa-solid fa-basket-shopping"></i> Tambah ke Keranjang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION ARTIKEL BARU -->
    @if(isset($latestArticles) && $latestArticles->count() > 0)
    <section class="news-section section-padding">
        <div class="container">
            <div class="section-title-area">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Artikel Terbaru</h2>
                </div>
                <a href="{{ url('artikel') }}" class="theme-btn transparent-btn wow fadeInUp" data-wow-delay=".5s">
                    Lihat Semua Artikel <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
            <div class="row">
                @foreach($latestArticles as $article)
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="news-card-items">
                        <div class="news-image">
                            <a href="{{ url('artikel/' . $article->slug) }}">
                                @if($article->thumbnail)
                                <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}" style="height: 250px; object-fit: cover; width: 100%;">
                                @else
                                <img src="{{ asset('assets/img/default-article.png') }}" alt="{{ $article->title }}" style="height: 250px; object-fit: cover; width: 100%;">
                                @endif
                            </a>
                        </div>
                        <div class="news-content">
                            <ul class="post-meta">
                                <li>
                                    <i class="fa-solid fa-user"></i>
                                    {{ $article->author }}
                                </li>
                                <li>
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{ $article->created_at->format('d M Y') }}
                                </li>
                            </ul>
                            <h3>
                                <a href="{{ url('artikel/' . $article->slug) }}">
                                    {{ Str::limit($article->title, 60) }}
                                </a>
                            </h3>
                            <p>
                                {{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}
                            </p>
                            <a href="{{ url('artikel/' . $article->slug) }}" class="link-btn">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- PWA Install Bubble HTML -->
    <div class="pwa-install-bubble" id="pwaInstallBubble">
        <button class="pwa-install-bubble-close" onclick="closePwaPrompt()">✕</button>
        <div class="pwa-install-bubble-content">
            <div class="pwa-install-bubble-title">
                <i class="fas fa-download" style="margin-right: 8px; color: #667eea;"></i>
                Instal Aplikasi
            </div>
            <div class="pwa-install-bubble-text">
                Akses Baleide lebih cepat langsung dari layar utama perangkat kamu!
            </div>
            <div class="pwa-install-bubble-buttons">
                <button class="pwa-install-btn pwa-install-btn-secondary" onclick="closePwaPrompt()">Nanti</button>
                <button class="pwa-install-btn pwa-install-btn-primary" id="pwaInstallBtnBubble">
                    <i class="fas fa-plus"></i> Instal
                </button>
            </div>
        </div>
    </div>

    <script>
        let deferredPrompt = null;
        const pwaBubble = document.getElementById('pwaInstallBubble');
        const pwaInstallBtn = document.getElementById('pwaInstallBtnBubble');
        
        // Only show PWA prompt on production (HTTPS)
        const isProduction = window.location.protocol === 'https:';

        window.addEventListener('beforeinstallprompt', (e) => {
            if (!isProduction) return; // Skip on localhost
            
            e.preventDefault();
            deferredPrompt = e;
            
            // Check localStorage untuk skip
            const hasSkipped = localStorage.getItem('pwaInstallSkipped');
            const skipTime = localStorage.getItem('pwaInstallSkipTime');
            const now = Date.now();
            
            // Show bubble jika belum skip atau sudah 7 hari
            if (!hasSkipped || (skipTime && now - parseInt(skipTime) > 7 * 24 * 60 * 60 * 1000)) {
                setTimeout(() => {
                    pwaBubble.classList.add('show');
                }, 3000);
            }
        });

        pwaInstallBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                
                if (outcome === 'accepted') {
                    localStorage.removeItem('pwaInstallSkipped');
                    localStorage.removeItem('pwaInstallSkipTime');
                }
                
                deferredPrompt = null;
                pwaBubble.classList.remove('show');
            }
        });

        function closePwaPrompt() {
            pwaBubble.classList.remove('show');
            localStorage.setItem('pwaInstallSkipped', 'true');
            localStorage.setItem('pwaInstallSkipTime', Date.now().toString());
        }

        window.addEventListener('appinstalled', () => {
            pwaBubble.classList.remove('show');
        });
    </script>
    
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        window.addToCart = function(bookId, bookTitle) {
            let cart = JSON.parse(localStorage.getItem('ebook_cart')) || [];
            if (!cart.includes(bookId)) {
                cart.push(bookId);
                localStorage.setItem('ebook_cart', JSON.stringify(cart));
                toastr.success(bookTitle + ' berhasil ditambahkan ke keranjang!');
            } else {
                toastr.info('Ebook ini sudah ada di dalam keranjang.');
            }
        }
    </script>
@endpush