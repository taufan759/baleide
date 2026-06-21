@extends('master')

@section('title', 'Laporan Aktivitas Saya')

@push('styles')
<style>
    .filter-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
    }
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .chart-wrapper {
        position: relative;
        height: 300px;
    }
    @media (max-width: 576px) {
        .chart-wrapper { height: 250px; }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-chart-line"></i> Laporan Aktivitas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Laporan</div>
            </div>
        </div>

        <div class="section-body">
            {{-- Filter Section --}}
            <div class="card filter-card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('user.reports.index') }}" id="filterForm">
                        <div class="row align-items-end">
                            <div class="col-md-3 mb-3">
                                <label class="text-white"><i class="fas fa-filter"></i> Jenis Laporan</label>
                                <select name="type" class="form-control" onchange="this.form.submit()">
                                    <option value="all" {{ $filters['type'] === 'all' ? 'selected' : '' }}>Semua Data</option>
                                    <option value="spending" {{ $filters['type'] === 'spending' ? 'selected' : '' }}>Pengeluaran</option>
                                    <option value="transaction" {{ $filters['type'] === 'transaction' ? 'selected' : '' }}>Transaksi</option>
                                    <option value="category" {{ $filters['type'] === 'category' ? 'selected' : '' }}>Per Kategori</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white"><i class="fas fa-calendar"></i> Periode</label>
                                <select name="period" class="form-control" onchange="this.form.submit()">
                                    <option value="1month" {{ $filters['period'] === '1month' ? 'selected' : '' }}>1 Bulan</option>
                                    <option value="3months" {{ $filters['period'] === '3months' ? 'selected' : '' }}>3 Bulan</option>
                                    <option value="6months" {{ $filters['period'] === '6months' ? 'selected' : '' }}>6 Bulan</option>
                                    <option value="1year" {{ $filters['period'] === '1year' ? 'selected' : '' }}>1 Tahun</option>
                                    <option value="all" {{ $filters['period'] === 'all' ? 'selected' : '' }}>Semua</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white"><i class="fas fa-tags"></i> Kategori Buku</label>
                                <select name="category_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $filters['category_id'] == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('user.reports.export', request()->query()) }}" class="btn btn-light btn-block" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Statistik Cards --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 stat-card">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Transaksi</h4>
                            </div>
                            <div class="card-body">
                                {{ $stats['total_transactions'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 stat-card">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pengeluaran</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($stats['total_spending'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 stat-card">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Buku Dibeli</h4>
                            </div>
                            <div class="card-body">
                                {{ $stats['total_books'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 stat-card">
                        <div class="card-icon bg-info">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Rata-rata Transaksi</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($stats['avg_transaction'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik Section --}}
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-line"></i> Grafik Pengeluaran</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <canvas id="spendingChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-pie"></i> Breakdown Kategori</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-bar"></i> Jumlah Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <canvas id="transactionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-book-open"></i> Jumlah Buku Dibeli</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <canvas id="bookChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Breakdown Detail --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-list"></i> Breakdown Per Kategori</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori</th>
                                            <th>Jumlah Buku</th>
                                            <th>Total Harga</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; $totalBooks = $categoryBreakdown->sum('count'); @endphp
                                        @forelse($categoryBreakdown as $category => $data)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td><strong>{{ $category }}</strong></td>
                                                <td>{{ $data['count'] }} buku</td>
                                                <td>Rp {{ number_format($data['total_price'], 0, ',', '.') }}</td>
                                                <td>
                                                    @php $percentage = $totalBooks > 0 ? round(($data['count'] / $totalBooks) * 100, 1) : 0; @endphp
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%">
                                                            {{ $percentage }}%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Belum ada data transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Transaksi --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-history"></i> Riwayat Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>ID Transaksi</th>
                                            <th>Item</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $trx)
                                            <tr>
                                                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                                <td><code>#{{ $trx->id }}</code></td>
                                                <td>{{ $trx->items->count() }} buku</td>
                                                <td><strong>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</strong></td>
                                                <td>
                                                    <span class="badge badge-success">Berhasil</span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/dashboard/transactions/' . $trx->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
    const chartData = {!! json_encode($chartData) !!};

    // Grafik Pengeluaran
    new Chart(document.getElementById('spendingChart'), {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Pengeluaran (Rp)',
                data: chartData.spending,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#10b981',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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

    // Grafik Kategori (Pie)
    const categoryData = {!! json_encode($categoryBreakdown) !!};
    const categoryLabels = Object.keys(categoryData);
    const categoryCounts = Object.values(categoryData).map(d => d.count);
    
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryCounts,
                backgroundColor: [
                    '#6366f1', '#10b981', '#f59e0b', '#ef4444',
                    '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6'
                ],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });

    // Grafik Jumlah Transaksi
    new Chart(document.getElementById('transactionChart'), {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: chartData.transaction_count,
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: '#6366f1',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Grafik Jumlah Buku
    new Chart(document.getElementById('bookChart'), {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Jumlah Buku',
                data: chartData.book_count,
                backgroundColor: 'rgba(245, 158, 11, 0.7)',
                borderColor: '#f59e0b',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
