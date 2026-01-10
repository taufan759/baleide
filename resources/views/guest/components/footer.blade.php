<footer class="footer-section footer-bg">
    <div class="footer-widgets-wrapper">
        <div class="plane-shape float-bob-y">
            <img src="{{ asset('client/assets/img/plane-shape.png')}}" alt="img">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/logo-baleide-white.webp')}}" alt="logo-baleide" style="max-height: 50px;">
                            </a>
                        </div>
                        <div class="footer-content">
                            <p>
                                Baleide adalah platform e-book digital terpercaya. Temukan berbagai koleksi buku terbaik dalam format digital untuk menunjang wawasan dan hobi membaca Anda kapan saja.
                            </p>
                            <div class="social-icon d-flex align-items-center">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 ps-lg-5 wow fadeInUp" data-wow-delay=".4s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h3>Layanan</h3>
                        </div>
                        <ul class="list-area">
                            <li>
                                <a href="{{ url('ebook') }}">
                                    <i class="fa-solid fa-chevrons-right"></i>
                                    Koleksi Buku
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('kontak') }}">
                                    <i class="fa-solid fa-chevrons-right"></i>
                                    Hubungi Kami
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('profil') }}">
                                    <i class="fa-solid fa-chevrons-right"></i>
                                    Akun Saya
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-solid fa-chevrons-right"></i>
                                    Syarat & Ketentuan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 ps-lg-5 wow fadeInUp" data-wow-delay=".6s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h3>Kategori</h3>
                        </div>
                        <ul class="list-area">
                            @foreach($categories->take(4) as $cat)
                            <li>
                                <a href="{{ url('category/' . $cat->slug) }}">
                                    <i class="fa-solid fa-chevrons-right"></i>
                                    {{ $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                    <div class="single-footer-widget">
                        <div class="widget-head">
                            <h3>Newsletter</h3>
                        </div>
                        <div class="footer-content">
                            <p>Dapatkan update buku terbaru dan promo menarik langsung di email Anda.</p>
                            <div class="footer-input">
                                <input type="email" id="email2" placeholder="Alamat Email">
                                <button class="newsletter-btn" type="submit">
                                    <i class="fa-regular fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-wrapper text-center">
                <p class="wow fadeInLeft" data-wow-delay=".3s">
                    © Hak Cipta {{ date('Y') }} oleh <a href="{{ url('/') }}">Baleide</a>
                </p>
            </div>
        </div>
    </div>
</footer>