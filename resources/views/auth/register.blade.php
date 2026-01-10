@extends('master')
@section('title', 'Daftar Akun Baleide')
@section('content')
    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <div class="col-lg-4 col-md-12 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3">
                    <img src="{{ asset('assets/img/logo-black.png') }}" alt="logo" width="100"
                        class="mb-5 mt-2 rounded">
                    
                    <h4 class="text-dark font-weight-normal">Bergabung dengan <span class="font-weight-bold">Baleide</span></h4>
                    <p class="text-muted">Langkah awal untuk mengembangkan potensi terbaikmu bersama kami.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('register') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control" name="name" 
                                required autofocus value="{{ old('name') }}" placeholder="Contoh: Budi Santoso">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" 
                                required value="{{ old('email') }}" placeholder="nama@email.com">
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon (WhatsApp)</label>
                            <input id="phone" type="text" class="form-control" name="phone" 
                                required value="{{ old('phone') }}" placeholder="08xxxxxxxxx">
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="password" class="d-block">Kata Sandi</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="password_confirmation" class="d-block">Konfirmasi Sandi</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                                <label class="custom-control-label" for="agree">Saya setuju dengan syarat dan ketentuan</label>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg btn-block icon-right">
                                Daftar Sekarang
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            Sudah punya akun? <a href="{{ url('login') }}">Masuk di sini</a>
                        </div>
                    </form>

                    <div class="text-center mt-5 text-small">
                        © 2026 Baleide.id. Semua hak dilindungi.
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8 bg-white col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom d-none d-lg-block d-xl-block"
                data-background="{{ asset('assets/img/banner-1.png') }}">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 display-4 font-weight-bold">Wujudkan Impianmu</h1>
                            <h5 class="font-weight-normal text-muted-transparent">Temukan ribuan ebook berkualitas hanya di Baleide.</h5>
                        </div>
                        Dikembangkan oleh <a class="text-light bb" target="_blank" href="#">Baleide Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection