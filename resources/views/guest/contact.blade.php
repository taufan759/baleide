@extends('guest')

@section('title', 'Hubungi Kami - Baleide')

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
                <h1>Hubungi Kami</h1>
                <div class="page-header">
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li>Kontak</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section fix section-padding">
        <div class="container">
            <div class="contact-wrapper">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4">
                        <div class="contact-left-items">
                            <div class="contact-info-area-2">
                                <div class="contact-info-items mb-4">
                                    <div class="icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="content">
                                        <p>Email & Phone</p>
                                        <h3>
                                            <a href="mailto:admin@baleide.id">admin@baleide.id</a>
                                        </h3>
                                    </div>
                                </div>
                                <div class="contact-info-items mb-4">
                                    <div class="icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div class="content">
                                        <p>Mail Support</p>
                                        <h3>
                                            <a href="mailto:mail@baleide.com">mail@baleide.com</a>
                                        </h3>
                                    </div>
                                </div>
                                <div class="contact-info-items border-none">
                                    <div class="icon">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div class="content">
                                        <p>Lokasi</p>
                                        <h3>
                                           Kab Bandung, Jawa Barat
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="video-image">
                                <img src="https://t3.ftcdn.net/jpg/05/44/33/68/360_F_544336800_s1PpnveXi7JcrRs49344wdf4416yQrDb.jpg" alt="img">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="contact-content">
                            <h2>Siap untuk Memulai?</h2>
                            <p>
                                Ada pertanyaan mengenai e-book atau butuh bantuan teknis? Tim kami siap membantu Anda di jam kerja.
                            </p>
                            <form action="{{ route('contact.send') }}" id="contact-form" method="POST" class="contact-form-items">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="form-clt">
                                            <span>Nama Lengkap*</span>
                                            <input type="text" name="name" id="name" placeholder="Nama Anda" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                        <div class="form-clt">
                                            <span>Email*</span>
                                            <input type="email" name="email" id="email" placeholder="Email Anda" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 wow fadeInUp" data-wow-delay=".7s">
                                        <div class="form-clt">
                                            <span>Tulis Pesan*</span>
                                            <textarea name="message" id="message" placeholder="Tulis Pesan"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 wow fadeInUp" data-wow-delay=".9s">
                                        <button type="submit" class="theme-btn">
                                            Kirim Pesan <i class="fa-solid fa-arrow-right-long"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="map-section">
        <div class="map-items">
            <div class="googpemap">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1014680.5888217037!2d107.45817300000002!3d-6.572557000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68efff9c2d1449%3A0xf51f143fb696182b!2sNanjung%20Industrial%20Park!5e0!3m2!1sen!2sus!4v1768014830409!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection