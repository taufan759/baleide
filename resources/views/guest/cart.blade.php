@extends('guest')

@section('title', 'Keranjang Belanja')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    .remove-icon img {
        width: 15px;
    }
    .cart-wrapper-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
        margin-top: 30px;
    }
    
    /* Voucher Section Styles */
    .voucher-section {
        width: 100%;
    }
    
    .cart-total-sticky {
        position: sticky;
        top: 20px;
    }
    
    .voucher-input-wrapper {
        display: flex;
        width: 100%;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .voucher-input {
        flex: 1;
        min-width: 0;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
        transition: border-color 0.3s ease;
    }
    
    .voucher-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }
    
    .voucher-input:disabled {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    
    .voucher-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        transition: background-color 0.3s ease;
        min-width: 80px;
    }
    
    .voucher-btn:hover {
        background-color: #0056b3;
    }
    
    .voucher-btn:active {
        transform: translateY(1px);
    }
    
    .voucher-message {
        margin-top: 8px;
        font-size: 13px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .voucher-input-wrapper {
            flex-direction: column;
            gap: 10px;
        }
        
        .voucher-input {
            width: 100%;
        }
        
        .voucher-btn {
            width: 100%;
            min-width: auto;
        }
        
        .cart-total {
            margin-top: 20px;
        }
        
        .cart-total table {
            font-size: 14px;
        }
        
        .cart-wrapper-footer {
            flex-direction: column;
            gap: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .voucher-section {
            padding: 0 5px;
        }
        
        .voucher-input {
            font-size: 16px; /* Prevents zoom on iOS */
            padding: 12px;
        }
        
        .voucher-btn {
            padding: 12px 20px;
            font-size: 16px;
        }
        
        .cart-total table th,
        .cart-total table td {
            padding: 8px 12px;
            font-size: 13px;
        }
        
        .sub-price {
            font-size: 14px;
            font-weight: 600;
        }
        
        .theme-btn {
            padding: 12px 20px;
            font-size: 16px;
        }
        
        /* Mobile cart table */
        .table-responsive {
            border: none;
        }
        
        .table th,
        .table td {
            padding: 8px 4px;
            font-size: 12px;
            vertical-align: middle;
        }
        
        .cart-title {
            font-size: 12px !important;
            max-width: 120px !important;
        }
        
        .cart img {
            width: 50px !important;
            height: 65px !important;
        }
        
        .remove-icon img {
            width: 12px;
        }
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb-wrapper">
        <div class="book1">
            <img src="{{ asset('assets/img/shape.png') }}" alt="book">
        </div>
        <div class="book2">
            <img src="{{ asset('client/assets/img/hero/book2.png') }}" alt="book">
        </div>
        <div class="container">
            <div class="page-heading">
                <h1>Keranjang</h1>
                <div class="page-header">
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li>Keranjang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-section section-padding">
        <div class="container">
            <div class="main-cart-wrapper">
                <div class="text-center py-5" id="cart-empty" style="display: none;">
                    <h4>Keranjang Anda kosong</h4>
                    <a href="{{ url('/ebook') }}" class="theme-btn mt-3">Cari E-book</a>
                </div>

                <div class="row g-5" id="cart-content" style="display: none;">
                    <div class="col-xl-9">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-wrapper-footer">
                            <a href="javascript:void(0)" onclick="loadCart()" class="theme-btn">Perbarui Keranjang</a>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Total Keranjang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="d-flex gap-5 align-items-center justify-content-between">
                                                <span class="sub-title">Subtotal:</span>
                                                <span class="sub-price" id="cart-subtotal">Rp 0</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="voucher-section mb-3">
                                                <label class="sub-title mb-2 d-block">Kode Voucher:</label>
                                                <div class="voucher-input-wrapper">
                                                    <input type="text" id="voucher-code" class="voucher-input" placeholder="Masukkan kode voucher">
                                                    <button type="button" id="apply-voucher" class="voucher-btn theme-btn">Cari</button>
                                                </div>
                                                <div id="voucher-message" class="voucher-message"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="discount-row" style="display: none;">
                                        <td>
                                            <span class="d-flex gap-5 align-items-center justify-content-between">
                                                <span class="sub-title">Diskon (<span id="voucher-name"></span>): </span>
                                                <span class="sub-price text-success" id="discount-amount">- Rp 0</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="d-flex gap-5 align-items-center justify-content-between">
                                                <span class="sub-title">Total:</span>
                                                <span class="sub-price sub-price-total" id="cart-total">Rp 0</span>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @auth
                                <button onclick="checkout()" class="theme-btn text-center d-block w-100 border-0">Lanjutkan ke Pembayaran</button>
                            @else
                                <a href="{{ route('login') }}" class="theme-btn text-center d-block" style="background-color: #333;">Login Terlebih Dahulu</a>
                            @endauth
                        </div>
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
    toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };

    let appliedVoucher = null;
    let subtotalAmount = 0;

    function formatRupiah(number) {
        return 'Rp ' + new Number(number).toLocaleString('id-ID');
    }

    function calculateTotal() {
        let total = subtotalAmount;
        
        if (appliedVoucher) {
            let discount = 0;
            if (appliedVoucher.type === 'percentage') {
                discount = (subtotalAmount * appliedVoucher.value) / 100;
                if (appliedVoucher.max_discount && discount > appliedVoucher.max_discount) {
                    discount = appliedVoucher.max_discount;
                }
            } else if (appliedVoucher.type === 'fixed') {
                discount = appliedVoucher.value;
            }
            
            total = Math.max(0, subtotalAmount - discount);
            
            document.getElementById('discount-row').style.display = 'table-row';
            document.getElementById('voucher-name').innerText = appliedVoucher.code;
            document.getElementById('discount-amount').innerText = '- ' + formatRupiah(discount);
        } else {
            document.getElementById('discount-row').style.display = 'none';
        }
        
        document.getElementById('cart-total').innerText = formatRupiah(total);
    }

    async function applyVoucher() {
        const voucherCode = document.getElementById('voucher-code').value.trim();
        const messageDiv = document.getElementById('voucher-message');
        
        if (!voucherCode) {
            showVoucherMessage('Masukkan kode voucher', 'error');
            return;
        }

        try {
            const response = await fetch("{{ route('voucher.check') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    code: voucherCode,
                    subtotal: subtotalAmount 
                })
            });

            const result = await response.json();
            console.log(result);
            

            if (result.success) {
                toastr.success(result.message);
                appliedVoucher = result.voucher;
                showVoucherMessage(result.message, 'success');
                calculateTotal();
                document.getElementById('apply-voucher').innerText = 'Hapus';
                document.getElementById('voucher-code').disabled = true;
            } else {
                toastr.info(result.message);
                showVoucherMessage(result.message, 'error');
                removeVoucher();
            }
        } catch (error) {
            console.error(error);
            showVoucherMessage('Terjadi kesalahan saat memvalidasi voucher', 'error');
        }
    }

    function removeVoucher() {
        appliedVoucher = null;
        document.getElementById('voucher-code').value = '';
        document.getElementById('voucher-code').disabled = false;
        document.getElementById('apply-voucher').innerText = 'Cari';
        document.getElementById('voucher-message').style.display = 'none';
        calculateTotal();
    }

    function showVoucherMessage(message, type) {
        const messageDiv = document.getElementById('voucher-message');
        messageDiv.innerHTML = `<small class="text-${type === 'success' ? 'success' : 'danger'}">${message}</small>`;
        messageDiv.style.display = 'block';
    }

    async function loadCart() {
        const cartIds = JSON.parse(localStorage.getItem('ebook_cart')) || [];
        const contentDiv = document.getElementById('cart-content');
        const emptyDiv = document.getElementById('cart-empty');
        const itemsTable = document.getElementById('cart-items');

        if (cartIds.length === 0) {
            contentDiv.style.display = 'none';
            emptyDiv.style.display = 'block';
            updateCartBadge();
            return;
        }

        try {
            const response = await fetch("{{ route('cart.fetch') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ ids: cartIds })
            });
            
            const ebooks = await response.json();
            let html = '';
            let total = 0;

            ebooks.forEach(item => {
                total += parseFloat(item.price);
                html += `
                    <tr>
                        <td>
                            <span class="d-flex gap-5 align-items-center">
                                <a href="javascript:void(0)" onclick="removeFromCart('${item.id}', '${item.title}')" class="remove-icon">
                                    <img src="{{ asset('client/assets/img/icon/icon-9.svg') }}" alt="hapus">
                                </a>
                                <span class="cart">
                                    <img src="${item.cover_url}" alt="${item.title}" style="width: 70px; height: 90px; object-fit: cover; border-radius: 5px;">
                                </span>
                                <span class="cart-title text-wrap" style="max-width:250px">${item.title}</span>
                            </span>
                        </td>
                        <td><span class="cart-price">${formatRupiah(item.price)}</span></td>
                        <td><span class="qty">1</span></td>
                        <td><span class="subtotal-price">${formatRupiah(item.price)}</span></td>
                    </tr>
                `;
            });

            itemsTable.innerHTML = html;
            subtotalAmount = total;
            document.getElementById('cart-subtotal').innerText = formatRupiah(total);
            calculateTotal();
            contentDiv.style.display = 'flex';
            emptyDiv.style.display = 'none';
            updateCartBadge();
            
        } catch (error) {
            console.error(error);
        }
    }

    function removeFromCart(id, title) {
        let cart = JSON.parse(localStorage.getItem('ebook_cart')) || [];
        cart = cart.filter(itemId => itemId != id);
        localStorage.setItem('ebook_cart', JSON.stringify(cart));
        toastr.warning(title + ' dihapus');
        loadCart();
    }

    function updateCartBadge() {
        const cart = JSON.parse(localStorage.getItem('ebook_cart')) || [];
        const countElements = document.querySelectorAll('#cart-count');
        countElements.forEach(el => {
            el.innerText = cart.length;
            el.style.display = cart.length > 0 ? 'block' : 'none';
        });
    }

    async function checkout() {
        const cartIds = JSON.parse(localStorage.getItem('ebook_cart')) || [];
        if (cartIds.length === 0) return toastr.error("Keranjang kosong");

        const checkoutData = { 
            ebook_ids: cartIds,
            voucher_code: typeof appliedVoucher !== 'undefined' && appliedVoucher ? appliedVoucher.code : null
        };

        Swal.fire({
            title: 'Sedang memproses',
            text: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const response = await fetch("{{ url('checkout') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify(checkoutData)
            });

            const result = await response.json();

            Swal.close();

            if (response.ok) {
                window.snap.pay(result.snap_token, {
                    onSuccess: function(res) {
                        localStorage.removeItem("ebook_cart");
                        fetch("/midtrans/callback", {
                            method: "POST",
                            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                            body: JSON.stringify({ order_id: res.order_id, transaction_status: res.transaction_status, transaction_id: res.transaction_id })
                        }).then(() => {
                            window.location.href = "/checkout-success?order=" + res.order_id;
                        });
                    },
                    onPending: function(res) {
                        toastr.info("Pembayaran tertunda");
                    },
                    onError: function(res) {
                        toastr.error("Pembayaran gagal");
                    }
                });
            } else {
                toastr.error(result.message || "Gagal memproses checkout");
            }
        } catch (error) {
            Swal.close();
            console.error(error);
            toastr.error("Terjadi kesalahan sistem");
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
        
        document.getElementById('apply-voucher').addEventListener('click', function() {
            if (this.innerText === 'Cari') {
                applyVoucher();
            } else {
                removeVoucher();
            }
        });

        document.getElementById('voucher-code').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyVoucher();
            }
        });
    });
</script>
@endpush