@extends('master')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ url('admin/transactions') }}">Data Transaksi</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Order ID: {{ $transaction->midtrans_order_id ?? $transaction->id }}</h2>
                <p class="section-lead">Informasi detail pembelian ebook oleh pelanggan.</p>

                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Transaksi</h4>
                        <div class="card-header-action">
                            <a href="{{ url('admin/transactions') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Data Pelanggan</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="150">Nama</th>
                                        <td>: {{ $transaction->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: {{ $transaction->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>: {{ $transaction->user->phone ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Status Pembayaran</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="150">Status</th>
                                        <td>: 
                                            @php
                                                $badges = [
                                                    'pending' => 'badge-warning',
                                                    'paid'    => 'badge-success',
                                                    'failed'  => 'badge-danger',
                                                    'expired' => 'badge-secondary',
                                                ];
                                            @endphp
                                            <span class="badge {{ $badges[$transaction->payment_status] ?? 'badge-dark' }}">
                                                {{ ucfirst($transaction->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Transaksi</th>
                                        <td>: {{ $transaction->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Voucher</th>
                                        <td>: {{ $transaction->voucher_code ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Item Ebook</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Judul Ebook</th>
                                                <th>Penulis</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaction->items as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $item->ebook->title }}</strong></td>
                                                    <td>{{ $item->ebook->author }}</td>
                                                    <td class="text-center">{{ $item->qty }}</td>
                                                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Total Bruto</th>
                                                <th class="text-right">Rp {{ number_format($transaction->items->sum('subtotal'), 0, ',', '.') }}</th>
                                            </tr>
                                            @if ($transaction->discount_amount > 0)
                                            <tr>
                                                <th colspan="5" class="text-right text-danger">Potongan Diskon</th>
                                                <th class="text-right text-danger">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</th>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th colspan="5" class="text-right">Total Bayar</th>
                                                <th class="text-right text-primary" style="font-size: 1.2rem;">
                                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if($transaction->notes)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Catatan:</h6>
                                <p class="text-muted">{{ $transaction->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection