@extends('master')

@section('title', 'Dashboard - Baleide')

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
                {{-- Kartu Statistik --}}
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card card-statistic-1 shadow-sm hover-shadow" style="transition: all 0.3s;">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Buku Saya</h4>
                                </div>
                                <div class="card-body">
                                    <h3>{{ $myBooksCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card card-statistic-1 shadow-sm hover-shadow" style="transition: all 0.3s;">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Transaksi</h4>
                                </div>
                                <div class="card-body">
                                    <h3>{{ $totalTransactions }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card card-statistic-1 shadow-sm hover-shadow" style="transition: all 0.3s;">
                            <div class="card-icon bg-info">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Ebook Tersedia</h4>
                                </div>
                                <div class="card-body">
                                    <h3>{{ $ebookCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="card card-statistic-1 shadow-sm hover-shadow" style="transition: all 0.3s;">
                            <div class="card-icon bg-success">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Belanja</h4>
                                </div>
                                <div class="card-body">
                                    <h3 style="font-size: 18px;">Rp {{ number_format($mySpending, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kategori Favorit --}}
                @if($favoriteCategories->isNotEmpty())
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h4 class="mb-0"><i class="fas fa-heart text-danger"></i> Kategori Favorit Saya</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($favoriteCategories as $category => $count)
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <div class="d-flex align-items-center p-3 border rounded shadow-sm" style="transition: all 0.2s; cursor: pointer;" onmouseover="this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.12)'">
                                                <div class="flex-shrink-0 mr-3">
                                                    <div class="badge badge-primary" style="font-size: 20px; padding: 8px 12px; border-radius: 50%;">
                                                        {{ $count }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 font-weight-600">{{ $category }}</h6>
                                                    <small class="text-muted">{{ $count }} buku dibeli</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Grafik Pengeluaran --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h4 class="mb-0">Riwayat Pengeluaran 6 Bulan Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <div style="position: relative; height: 300px;">
                                    <canvas id="spendingChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Koleksi & Ebook Terbaru --}}
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Koleksi Buku Saya</h4>
                                    <a href="{{ url('/dashboard/my-books') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @forelse ($myCollections as $book)
                                        <div class="col-6 col-sm-4 col-md-3 mb-4">
                                            @php
                                                $cover = $book->photos->first();
                                                $imgUrl = $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png');
                                            @endphp
                                            <div class="text-center">
                                                <a href="{{ url('/ebook/' . $book->slug) }}" class="d-block mb-2" style="overflow: hidden; border-radius: 8px;">
                                                    <img src="{{ $imgUrl }}" class="img-fluid rounded shadow-sm" style="height: 180px; object-fit: cover; width: 100%; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                                </a>
                                                <div class="font-weight-600 text-small text-truncate mb-2">
                                                    <a href="{{ url('/ebook/' . $book->slug) }}" class="text-dark" title="{{ $book->title }}">
                                                        {{ Str::limit($book->title, 25) }}
                                                    </a>
                                                </div>
                                                <a href="{{ url('/dashboard/my-books/' . $book->slug) }}" class="btn btn-sm btn-outline-primary btn-block">Baca Sekarang</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5">
                                            <i class="fas fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                                            <p class="text-muted mt-3 mb-0">Anda belum memiliki koleksi buku.</p>
                                            <a href="{{ url('/ebook') }}" class="btn btn-primary btn-sm mt-3">Mulai Belanja</a>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h4 class="mb-0">Ebook Terbaru</h4>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-unstyled list-unstyled-border mb-0">
                                    @foreach ($latestEbooks as $ebook)
                                        <li class="media p-3 border-bottom" style="transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                                            @php
                                                $latestCover = $ebook->photos->first();
                                                $latestImg = $latestCover ? asset($latestCover->photo) : asset('assets/img/default-ebook.png');
                                            @endphp
                                            <a href="{{ url('/ebook/' . $ebook->slug) }}" class="mr-3">
                                                <img class="rounded" width="50" src="{{ $latestImg }}" alt="thumb" style="height: 70px; object-fit: cover;">
                                            </a>
                                            <div class="media-body">
                                                <div class="media-title text-small font-weight-bold mb-1">
                                                    <a href="{{ url('/ebook/' . $ebook->slug) }}" class="text-dark" title="{{ $ebook->title }}">
                                                        {{ Str::limit($ebook->title, 30) }}
                                                    </a>
                                                </div>
                                                <div class="text-success font-weight-600 text-small">Rp {{ number_format($ebook->price, 0, ',', '.') }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="p-3 border-top">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const spendingLabels = {!! $spendingLabels !!};
    const spendingData   = {!! $spendingData !!};

    new Chart(document.getElementById('spendingChart'), {
        type: 'bar',
        data: {
            labels: spendingLabels,
            datasets: [{
                label: 'Pengeluaran (Rp)',
                data: spendingData,
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 0,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { drawBorder: false },
                    ticks: {
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                },
                x: {
                    grid: { display: false },
                }
            }
        }
    });
</script>
@endpush
