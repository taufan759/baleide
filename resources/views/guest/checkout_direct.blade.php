@extends('guest')

@section('title', 'Checkout Langsung')

@section('content')
<div class="container section-padding">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h3>Menyiapkan Pembayaran...</h3>
            <p>Anda akan membeli: <strong>{{ $ebook->title }}</strong></p>
            <div class="spinner-border text-primary" role="status"></div>
            <button id="pay-button" class="theme-btn mt-4 d-none">Bayar Sekarang</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ config('midtrans.url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        
        // Langsung panggil Snap saat halaman siap
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(res) {
                fetch("{{ route('midtrans.callback') }}", {
                    method: "POST",
                    headers: { 
                        "Content-Type": "application/json", 
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                    },
                    body: JSON.stringify({ 
                        order_id: res.order_id, 
                        transaction_status: res.transaction_status,
                        transaction_id: res.transaction_id 
                    })
                }).then(() => {
                    window.location.href = "/checkout-success?order=" + res.order_id;
                });
            },
            onPending: function(res) { window.location.href = "/dashboard"; },
            onError: function(res) { window.location.href = "/ebook"; },
            onClose: function() { 
                // Jika user tutup popup, tampilkan tombol bayar manual agar tidak bingung
                payButton.classList.remove('d-none');
            }
        });

        payButton.onclick = function() {
            window.snap.pay('{{ $snapToken }}');
        };
    });
</script>
@endpush