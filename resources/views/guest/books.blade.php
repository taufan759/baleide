@extends('guest')

@section('title', 'Katalog Ebook')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .news-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }
        .custom-search {
            position: relative;
            width: 300px;
        }
        .custom-search input {
            width: 100%;
            padding: 12px 20px;
            padding-right: 50px;
            border-radius: 50px;
            border: 1px solid #eee;
            outline: none;
            transition: all 0.3s;
        }
        .custom-search input:focus {
            border-color: #E2793D;
        }
        .custom-search button {
            position: absolute;
            right: 5px;
            top: 5px;
            width: 40px;
            height: 40px;
            background: #E2793D;
            border: none;
            border-radius: 50%;
            color: white;
        }
        .news-content h3 {
            min-height: 54px;
        }
        .price-text {
            font-size: 1.2rem;
            color: #E2793D;
            font-weight: 700;
            display: block;
            margin-bottom: 15px;
        }
        .btn-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb-wrapper">
        <div class="book1">
            <img src="{{ asset('assets/img/shape.png') }}" alt="book">
        </div>
        <div class="book2">
            <img src="{{ asset('client/assets/img/hero/book2.png') }}" alt="book">
        </div>
        <div class="container">
            <div class="page-heading">
                <h1>Katalog Ebook</h1>
                <div class="page-header">
                    <ul class="breadcrumb-items">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li>Ebook</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="news-section fix section-padding">
        <div class="container">
            <div class="search-container">
                <form action="{{ url('ebook') }}" method="GET" class="custom-search">
                    <input type="text" name="search" placeholder="Cari buku..." value="{{ request('search') }}">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <div class="row g-4">
                @forelse($books as $book)
                <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="news-card-items style-2 mt-0">
                        <div class="news-image">
                            @php
                                $cover = $book->photos->first();
                                $imgUrl = $cover && file_exists(public_path($cover->photo)) ? asset($cover->photo) : asset('client/assets/img/news/05.jpg');
                            @endphp
                            <img src="{{ $imgUrl }}" alt="{{ $book->title }}">
                            <img src="{{ $imgUrl }}" alt="{{ $book->title }}">
                            <div class="post-box">
                                {{ $book->category->name }}
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="price-text">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            <h3><a href="{{ url('ebook/' . $book->slug) }}">{{ Str::limit($book->title, 50) }}</a></h3>
                            
                            <div class="btn-flex">
                                <a href="{{ url('ebook/' . $book->slug) }}" class="theme-btn-2">
                                    Read More <i class="fa-regular fa-arrow-right-long"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="addToCart('{{ $book->id }}', '{{ $book->title }}')" class="theme-btn">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('client/assets/img/empty.png') }}" alt="not found" style="max-width: 200px;">
                    <h4 class="mt-3">Buku tidak tersedia</h4>
                </div>
                @endforelse
            </div>

            <div class="page-nav-wrap text-center wow fadeInUp mt-5" data-wow-delay=".3s">
                {{ $books->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
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
                toastr.success(bookTitle + ' berhasil ditambahkan!');
            } else {
                toastr.info('Ebook sudah ada di keranjang.');
            }
        }
    </script>
@endpush