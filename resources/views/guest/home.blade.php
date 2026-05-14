@extends('guest')

@section('title', 'Beranda')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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