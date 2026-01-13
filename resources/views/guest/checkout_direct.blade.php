@extends('guest')

@section('title', 'Review Pesanan')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
<div class="container section-padding">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Ringkasan Pesanan</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        @php
                            $cover = $ebook->photos->first();
                            $imgUrl = $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png');
                        @endphp
                        
                        <img src="{{ $imgUrl }}" alt="{{ $ebook->title }}" style="width: 80px; height: 120px; object-fit: cover; border-radius: 5px;" class="me-3">
                        
                        <div>
                            <h5 class="mb-1">{{ $ebook->title }}</h5>
                            <p class="text-muted mb-0">Penulis: {{ $ebook->author }}</p>
                            <h6 class="text-primary mt-2">Rp {{ number_format($ebook->price, 0, ',', '.') }}</h6>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kode Voucher</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="voucher-code" placeholder="Masukkan kode promo">
                            <button class="btn btn-outline-primary" type="button" id="apply-voucher" onclick="applyVoucher()">Cari</button>
                        </div>
                        <small id="voucher-message" class="d-block mt-1"></small>
                    </div>

                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Normal</span>
                            <span>Rp <span id="display-price">{{ number_format($ebook->price, 0, ',', '.') }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-success d-none" id="discount-row">
                            <span>Diskon Voucher</span>
                            <span>- Rp <span id="display-discount">0</span></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Bayar</span>
                            <span>Rp <span id="display-total">{{ number_format($ebook->price, 0, ',', '.') }}</span></span>
                        </div>
                    </div>

                    <button id="pay-button" class="theme-btn w-100 mt-4 text-center">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ config('midtrans.url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    toastr.options = { 
        "closeButton": true, 
        "progressBar": true, 
        "positionClass": "toast-top-right", 
        "timeOut": "3000" 
    };

    let ebookPrice = {{ $ebook->price }};
    let currentTotal = ebookPrice;
    let appliedVoucherCode = null;
    const ebookId = "{{ $ebook->id }}";

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    async function applyVoucher() {
        const codeInput = document.getElementById('voucher-code');
        const code = codeInput.value.trim();
        const btnEl = document.getElementById('apply-voucher');

        if (appliedVoucherCode) {
            appliedVoucherCode = null;
            currentTotal = ebookPrice;
            
            document.getElementById('discount-row').classList.add('d-none');
            document.getElementById('display-total').innerText = formatRupiah(currentTotal);
            
            codeInput.value = '';
            codeInput.disabled = false;
            btnEl.innerText = 'Cari';
            btnEl.classList.remove('btn-outline-danger');
            btnEl.classList.add('btn-outline-primary');
            
            toastr.info("Voucher dihapus");
            return;
        }

        if (!code) return toastr.error("Masukkan kode voucher");

        try {
            const response = await fetch("{{ route('voucher.check') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code, subtotal: ebookPrice })
            });

            const result = await response.json();

            if (result.success) {
                appliedVoucherCode = result.voucher.code;
                let discountVal = parseFloat(result.voucher.discount_amount);
                
                currentTotal = ebookPrice - discountVal;
                if(currentTotal < 0) currentTotal = 0;

                document.getElementById('display-discount').innerText = formatRupiah(discountVal);
                document.getElementById('display-total').innerText = formatRupiah(currentTotal);
                document.getElementById('discount-row').classList.remove('d-none');
                
                codeInput.disabled = true;
                btnEl.innerText = 'Hapus';
                btnEl.classList.remove('btn-outline-primary');
                btnEl.classList.add('btn-outline-danger');
                
                toastr.success(result.message);
            } else {
                toastr.error(result.message);
            }
        } catch (error) {
            console.error(error);
            toastr.error("Gagal memvalidasi voucher");
        }
    }

    document.getElementById('pay-button').onclick = async function() {
        Swal.fire({
            title: 'Memproses Pesanan',
            text: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await fetch("{{ route('checkout.processDirect') }}", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json", 
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                },
                body: JSON.stringify({ 
                    ebook_id: ebookId,
                    voucher_code: appliedVoucherCode 
                })
            });

            const result = await response.json();
            Swal.close();

            if (result.success) {
                if (result.is_free === true) {
                    toastr.success(result.message);
                    setTimeout(() => {
                        window.location.href = "/checkout-success?order=" + result.order_id;
                    }, 1000);
                } else if (result.snap_token) {
                    window.snap.pay(result.snap_token, {
                        onSuccess: function(res) {
                            fetch("/midtrans/callback", {
                                method: "POST",
                                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                                body: JSON.stringify({ order_id: res.order_id, transaction_status: res.transaction_status, transaction_id: res.transaction_id })
                            }).then(() => {
                                window.location.href = "/checkout-success?order=" + res.order_id;
                            });
                        },
                        onPending: function(res) { window.location.href = "/dashboard"; },
                        onError: function(res) { toastr.error("Pembayaran gagal"); },
                        onClose: function() { toastr.warning("Pembayaran belum diselesaikan"); }
                    });
                }
            } else {
                toastr.error(result.message || "Gagal memproses transaksi");
            }
        } catch (error) {
            Swal.close();
            console.error(error);
            toastr.error("Terjadi kesalahan sistem");
        }
    };
</script>
@endpush