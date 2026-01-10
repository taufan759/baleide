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
</style>
@endpush

@section('content')
    <div class="breadcrumb-wrapper">
        <div class="book1">
            <img src="https://baleide.id/wp-content/uploads/2025/05/Vector-orange1.png" alt="book">
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
                        <div class="table-responsive cart-total">
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
<script type="text/javascript" src="{{ config('midtrans.url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };

    function formatRupiah(number) {
        return 'Rp ' + new Number(number).toLocaleString('id-ID');
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
            document.getElementById('cart-subtotal').innerText = formatRupiah(total);
            document.getElementById('cart-total').innerText = formatRupiah(total);
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

        try {
            const response = await fetch("{{ url('checkout') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ ebook_ids: cartIds })
            });

            if (response.ok) {
                const result = await response.json();
                window.snap.pay(result.snap_token, {
                    onSuccess: function(res) {
                        localStorage.removeItem("ebook_cart");
                        fetch("/midtrans/callback", {
                            method: "POST",
                            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                            body: JSON.stringify({ order_id: res.order_id, transaction_status: res.transaction_status,transaction_id: res.transaction_id })
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
            }
        } catch (error) {
            console.error(error);
            toastr.error("Terjadi kesalahan sistem");
        }
    }

    document.addEventListener('DOMContentLoaded', loadCart);
</script>
@endpush