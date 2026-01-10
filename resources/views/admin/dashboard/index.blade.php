@extends('master')

@section('title', 'Dashboard Admin - Baleide')

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
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Pelanggan</h4>
                                </div>
                                <div class="card-body">
                                    {{ $userCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Koleksi Ebook</h4>
                                </div>
                                <div class="card-body">
                                    {{ $ebookCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Transaksi Hari Ini</h4>
                                </div>
                                <div class="card-body">
                                    {{ $transactionToday }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Pendapatan Hari Ini</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($incomeToday, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ebook Terbaru yang Diunggah</h4>
                                <div class="card-header-action">
                                    <a href="{{ url('admin/manage-master/ebook') }}" class="btn btn-primary">Kelola Semua Ebook <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    @forelse ($latestEbooks as $ebook)
                                        <li class="media">
                                            @php
                                                $firstPhoto = $ebook->photos->first();
                                                $imageUrl = $firstPhoto 
                                                            ? asset($firstPhoto->photo) 
                                                            : asset('assets/img/default-ebook.png');
                                            @endphp
                                            
                                            <img class="mr-3 rounded shadow-sm" 
                                                 width="55" 
                                                 height="80" 
                                                 style="object-fit: cover; border: 1px solid #f0f0f0;"
                                                 src="{{ $imageUrl }}"
                                                 alt="{{ $ebook->title }}"
                                                 onerror="this.onerror=null;this.src='https://via.placeholder.com/150x200?text=No+Image';">
                                            
                                            <div class="media-body">
                                                <div class="float-right text-muted small">
                                                    {{ $ebook->created_at->diffForHumans() }}
                                                </div>
                                                <div class="media-title mb-1">{{ $ebook->title }}</div>
                                                <div class="text-small text-muted mb-1">
                                                    Penulis: <span class="text-dark font-weight-600">{{ $ebook->author }}</span> | 
                                                    Kategori: <span class="badge badge-light">{{ $ebook->category->name ?? 'Umum' }}</span>
                                                </div>
                                                <div class="font-weight-bold text-success">
                                                    Rp {{ number_format($ebook->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <div class="text-center p-4">
                                            <p class="text-muted">Belum ada data ebook yang diunggah.</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection