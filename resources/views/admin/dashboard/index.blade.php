@extends('master')

@section('title', 'Dashboard Admin - Baleide')

@push('styles')
<style>
    .chart-card { border-radius: 10px; }
    .chart-card .card-header { border-bottom: 1px solid #f0f0f0; }
</style>
@endpush

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

                {{-- Grafik --}}
                <div class="row">
                    {{-- Grafik Pendapatan 7 Hari --}}
                    <div class="col-lg-8 col-md-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4>Pendapatan 3 Bulan Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Grafik Ebook per Kategori --}}
                    <div class="col-lg-4 col-md-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4>Ebook per Kategori</h4>
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <canvas id="categoryChart" height="200" style="max-width:260px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Grafik Jumlah Transaksi 7 Hari --}}
                    <div class="col-lg-6 col-md-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4>Jumlah Transaksi 3 Bulan Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="transactionChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Ebook Terbaru --}}
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ebook Terbaru Diunggah</h4>
                                <div class="card-header-action">
                                    <a href="{{ url('admin/manage-master/ebook') }}" class="btn btn-primary btn-sm">
                                        Kelola Semua <i class="fas fa-chevron-right"></i>
                                    </a>
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
                                                 width="45"
                                                 height="65"
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const revenueLabels    = {!! $revenueLabels !!};
    const revenueData      = {!! $revenueChart !!};
    const transactionData  = {!! $transactionChart !!};
    const categoryLabels   = {!! $categoryLabels !!};
    const categoryData     = {!! $categoryData !!};

    // Grafik Pendapatan
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // Grafik Transaksi
    new Chart(document.getElementById('transactionChart'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: transactionData,
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                borderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Grafik Kategori
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: [
                    '#6366f1','#10b981','#f59e0b','#ef4444',
                    '#3b82f6','#8b5cf6','#ec4899','#14b8a6'
                ],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12 } }
            }
        }
    });
</script>
@endpush
