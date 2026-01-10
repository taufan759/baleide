@extends('master')

@section('title', 'Dashboard User - Baleide')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">{{ $today }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Buku Saya</h4>
                                </div>
                                <div class="card-body">
                                    {{ $myBooksCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Ebook</h4>
                                </div>
                                <div class="card-body">
                                    {{ $ebookCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Belanja</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($mySpending, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Koleksi Buku Saya</h4>
                                <div class="card-header-action">
                                    <a href="{{ url('/dashboard/my-books') }}" class="btn btn-primary">Lihat Semua</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @forelse ($myCollections as $book)
                                        <div class="col-6 col-sm-3 mb-4">
                                            @php
                                                $cover = $book->photos->first();
                                                $imgUrl = $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png');
                                            @endphp
                                            <div class="text-center">
                                                <a href="{{ url('/ebook/' . $book->slug) }}">
                                                    <img src="{{ $imgUrl }}" class="img-fluid rounded shadow-sm mb-2" style="height: 160px; object-fit: cover; width: 100%;">
                                                </a>
                                                <div class="font-weight-600 text-small text-truncate">
                                                    <a href="{{ url('/ebook/' . $book->slug) }}" class="text-dark">
                                                        {{ $book->title }}
                                                    </a>
                                                </div>
                                                <a href="{{ url('/dashboard/my-books/' . $book->slug) }}" class="btn btn-sm btn-outline-primary btn-block mt-2">Baca Sekarang</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-4">
                                            <p class="text-muted">Anda belum memiliki koleksi buku.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ebook Terbaru</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    @foreach ($latestEbooks as $ebook)
                                        <li class="media">
                                            @php
                                                $latestCover = $ebook->photos->first();
                                                $latestImg = $latestCover ? asset($latestCover->photo) : asset('assets/img/default-ebook.png');
                                            @endphp
                                            <a href="{{ url('/ebook/' . $ebook->slug) }}">
                                                <img class="mr-3 rounded" width="45" src="{{ $latestImg }}" alt="thumb" style="height: 60px; object-fit: cover;">
                                            </a>
                                            <div class="media-body">
                                                <div class="media-title text-small font-weight-bold">
                                                    <a href="{{ url('/ebook/' . $ebook->slug) }}" class="text-dark">
                                                        {{ $ebook->title }}
                                                    </a>
                                                </div>
                                                <div class="text-success font-weight-600 text-small">Rp {{ number_format($ebook->price, 0, ',', '.') }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="text-center pt-1">
                                    <a href="{{ url('/ebook') }}" class="btn btn-primary btn-sm btn-block">Jelajahi Toko</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection