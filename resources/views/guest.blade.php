<!DOCTYPE html>
<html lang="id">
<!--<< Header Area >>-->

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('meta')
    <!--<< Favcion >>-->
    <link rel="shortcut icon" href="{{ asset('client/assets/img/favicon.png') }}">
    <!--<< Bootstrap min.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.min.css') }}">
    <!--<< All Min Css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/all.min.css') }}">
    <!--<< Animate.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/animate.css') }}">
    <!--<< Magnific Popup.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/magnific-popup.css') }}">
    <!--<< MeanMenu.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/meanmenu.css') }}">
    <!--<< Swiper Bundle.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/swiper-bundle.min.css') }}">
    <!--<< Nice Select.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/nice-select.css') }}">
    <!--<< Icomoon.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/icomoon.css') }}">
    <!--<< Main.css >>-->
    <link rel="stylesheet" href="{{ asset('client/assets/css/main.css') }}">
</head>
<style>
    .cart-icon {
        position: relative;
        display: inline-block; 
    }
    .cart-badge {
        position: absolute;
        top: -5px;
        left: -1px; 
        background-color: #036280;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: bold;
        line-height: 1;
        min-width: 18px;
        text-align: center;
        z-index: 1;
    }
</style>
@stack('styles')

<body>

    <!-- Back To Top start -->
    <button id="back-top" class="back-to-top">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    @include('guest.components.header')

    @yield('content')


    @include('guest.components.footer')

    @stack('scripts')

    <!--<< All JS Plugins >>-->
    <script src="{{ asset('client/assets/js/jquery-3.7.1.min.js') }}"></script>
    <!--<< Viewport Js >>-->
    <script src="{{ asset('client/assets/js/viewport.jquery.js') }}"></script>
    <!--<< Bootstrap Js >>-->
    <script src="{{ asset('client/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--<< Nice Select Js >>-->
    <script src="{{ asset('client/assets/js/jquery.nice-select.min.js') }}"></script>
    <!--<< Waypoints Js >>-->
    <script src="{{ asset('client/assets/js/jquery.waypoints.js') }}"></script>
    <!--<< Counterup Js >>-->
    <script src="{{ asset('client/assets/js/jquery.counterup.min.js') }}"></script>
    <!--<< Swiper Slider Js >>-->
    <script src="{{ asset('client/assets/js/swiper-bundle.min.js') }}"></script>
    <!--<< MeanMenu Js >>-->
    <script src="{{ asset('client/assets/js/jquery.meanmenu.min.js') }}"></script>
    <!--<< Magnific Popup Js >>-->
    <script src="{{ asset('client/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!--<< Wow Animation Js >>-->
    <script src="{{ asset('client/assets/js/wow.min.js') }}"></script>
    <!-- Gsap -->
    <script src="{{ asset('client/assets/js/gsap.min.js') }}"></script>
    <!--<< Main.js >>-->
    <script src="{{ asset('client/assets/js/main.js') }}"></script>
</body>

<script>
    function updateCartBadge() {
        const cart = JSON.parse(localStorage.getItem('ebook_cart')) || [];
        const countElements = document.querySelectorAll('#cart-count');
        
        countElements.forEach(el => {
            el.innerText = cart.length;
            el.style.display = cart.length > 0 ? 'block' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', updateCartBadge);

    window.addToCart = function(bookId, bookTitle) {
        let cart = JSON.parse(localStorage.getItem('ebook_cart')) || [];
        if (!cart.includes(bookId)) {
            cart.push(bookId);
            localStorage.setItem('ebook_cart', JSON.stringify(cart));
            
            updateCartBadge(); 
            
            toastr.success(bookTitle + ' added to cart!');
        } else {
            toastr.info('Ebook is already in the cart.');
        }
    }
</script>


<script>
    function updateRealtimeClock() {
        const clockElement = document.getElementById('realtime-clock');
        const now = new Date();

        const hariIndo = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 
            'Kamis', 'Jumat', 'Sabtu'
        ];
        
        const namaHari = hariIndo[now.getDay()];
        
        const jam = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        const detik = String(now.getSeconds()).padStart(2, '0');
        
        clockElement.innerHTML = `${namaHari}: ${jam}:${menit}:${detik} WIB`;
    }

    setInterval(updateRealtimeClock, 1000);
    updateRealtimeClock();
</script>

</html>
