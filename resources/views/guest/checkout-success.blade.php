@extends('guest')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container section-padding text-center">
    <div class="py-5">
        <div class="mb-4">
            <i class="fas fa-check-circle fa-5x text-success"></i>
        </div>
        <h2 class="mb-3">Terima Kasih!</h2>
        <p class="lead">Pembayaran Anda untuk Order <strong>#{{ $transaction->midtrans_order_id }}</strong> telah kami terima.</p>
        
        <div class="card mx-auto mt-4" style="max-width: 600px;">
            <div class="card-body text-start">
                <h5 class="card-title border-bottom pb-2">Detail Pesanan</h5>
                <table class="table table-borderless">
                    @foreach($transaction->items as $item)
                    <tr>
                        <td>{{ $item->ebook->title }}</td>
                        <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="border-top">
                        <strong>
                            <td>Total Bayar</td>
                            <td class="text-end text-primary">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        </strong>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ url('/ebook') }}" class="theme-btn">Beli E-book Lainnya</a>
            <a href="{{ url('/dashboard') }}" class="theme-btn" style="background-color: #333;">Lihat Koleksi Saya</a>
        </div>
    </div>
</div>
@endsection