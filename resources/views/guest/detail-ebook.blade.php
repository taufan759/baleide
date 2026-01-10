@extends('guest')

@section('title', $book->title)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .shop-details-thumb img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <section class="shop-details-section fix section-padding">
        <div class="container">
            <div class="shop-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="shop-details-image">
                            <div class="tab-content">
                                @foreach ($book->photos as $key => $photo)
                                    <div id="thumb{{ $key + 1 }}"
                                        class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}">
                                        <div class="shop-details-thumb">
                                            <img src="{{ asset($photo->photo) }}" alt="{{ $book->title }}">
                                        </div>
                                    </div>
                                @endforeach
                                @if ($book->photos->isEmpty())
                                    <div id="thumb1" class="tab-pane fade show active">
                                        <div class="shop-details-thumb">
                                            <img src="{{ asset('assets/img/default-ebook.png') }}"
                                                alt="{{ $book->title }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <ul class="nav">
                                @foreach ($book->photos as $key => $photo)
                                    <li class="nav-item">
                                        <a href="#thumb{{ $key + 1 }}" data-bs-toggle="tab"
                                            class="nav-link {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset($photo->photo) }}" alt="thumb"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="shop-details-content">
                            <div class="title-wrapper">
                                <h2>{{ $book->title }}</h2>
                                <h5>Tersedia dalam format Digital.</h5>
                            </div>

                            <p>{{ Str::limit($book->description, 250) }}</p>

                            <div class="price-list">
                                <h3>Rp {{ number_format($book->price, 0, ',', '.') }}</h3>
                            </div>

                            <div class="cart-wrapper">
                                <button type="button" class="theme-btn style-2" id="btnQuickBuy">
                                    Beli Cepat
                                </button>

                                <a href="javascript:void(0)" class="theme-btn"
                                    onclick="addToCart('{{ $book->id }}', '{{ $book->title }}')">
                                    <i class="fa-solid fa-basket-shopping"></i> Add To Cart
                                </a>
                            </div>

                            <div class="category-box">
                                <div class="category-list">
                                    <ul>
                                        <li><span>SKU:</span> {{ $book->isbn ?? '-' }}</li>
                                        <li><span>Category:</span> {{ $book->category->name }}</li>
                                    </ul>
                                    <ul>
                                        <li><span>Format:</span> {{ strtoupper($book->file_format) }}</li>
                                        <li><span>Total page:</span> {{ $book->total_pages }}</li>
                                    </ul>
                                    <ul>
                                        <li><span>Publisher:</span> Baleide</li>
                                        <li><span>Publish Years:</span> {{ $book->created_at->format('Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="single-tab section-padding pb-0">
                    <ul class="nav mb-5" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#description" data-bs-toggle="tab" class="nav-link ps-0 active" role="tab">
                                <h6>Description</h6>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#additional" data-bs-toggle="tab" class="nav-link" role="tab">
                                <h6>Additional Information</h6>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="description" class="tab-pane fade show active" role="tabpanel">
                            <div class="description-items">
                                <p>{!! nl2br(e($book->description)) !!}</p>
                            </div>
                        </div>
                        <div id="additional" class="tab-pane fade" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Availability</td>
                                            <td>{{ $book->stock > 0 ? 'Available' : 'Out of Stock' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Author</td>
                                            <td>{{ $book->author }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Page</td>
                                            <td>{{ $book->total_pages }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-section section-padding fix pt-0">
        <div class="container">
            <div class="section-title-area">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">Rekomendasi Buku</h2>
                </div>
                <a href="{{ url('ebook') }}" class="theme-btn transparent-btn wow fadeInUp" data-wow-delay=".5s">
                    Lihat Semua <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
            <div class="swiper book-slider">
                <div class="swiper-wrapper">
                    @foreach($recommendations as $bookItem)
                    <div class="swiper-slide">
                        <div class="shop-box-items style-2">
                            <div class="book-thumb center">
                                @php
                                    $coverItem = $bookItem->photos->first();
                                    $imgUrlItem = $coverItem ? asset($coverItem->photo) : asset('assets/img/default-ebook.png');
                                @endphp
                                
                                <a href="{{ url('ebook/' . $bookItem->slug) }}">
                                    <img src="{{ $imgUrlItem }}" alt="{{ $bookItem->title }}">
                                </a>
                                
                                <ul class="shop-icon d-grid justify-content-center align-items-center">
                                    <li>
                                        <a href="{{ url('ebook/' . $bookItem->slug) }}"><i class="far fa-eye"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="addToCart('{{ $bookItem->id }}', '{{ $bookItem->title }}')">
                                            <i class="fa-solid fa-basket-shopping"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-content">
                                <h5>{{ $bookItem->category->name }}</h5>
                                
                                <h3><a href="{{ url('ebook/' . $bookItem->slug) }}">{{ Str::limit($bookItem->title, 40) }}</a></h3>
                                
                                <ul class="price-list">
                                    <li>Rp {{ number_format($bookItem->price, 0, ',', '.') }}</li>
                                </ul>

                                <ul class="author-post">
                                    <li class="authot-list">
                                        <span class="icon">
                                            <i class="fa-regular fa-file-pdf text-danger"></i>
                                        </span>
                                        <span class="content ml-2">Format: {{ strtoupper($bookItem->file_format) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-button">
                                <a href="javascript:void(0)" onclick="addToCart('{{ $bookItem->id }}', '{{ $bookItem->title }}')" class="theme-btn">
                                    <i class="fa-solid fa-basket-shopping"></i> Tambah Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
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
                toastr.success(bookTitle + ' berhasil ditambahkan ke keranjang!');
            } else {
                toastr.info('Ebook ini sudah ada di dalam keranjang.');
            }
        }

        document.getElementById('btnQuickBuy').addEventListener('click', function() {
            window.location.href = "{{ url('checkout') }}/" + "{{ $book->slug }}";
        });
    </script>
@endpush