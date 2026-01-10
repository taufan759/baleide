@extends('master')
@section('title', 'Masuk ke Baleide')
@section('content')
    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <div class="col-lg-4 col-md-12 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3">
                    <img src="{{ asset('assets/img/logo-black.png') }}" alt="logo" width="100"
                        class="mb-5 mt-2 rounded">
                    
                    <h4 class="text-dark font-weight-normal">Selamat Datang di <span class="font-weight-bold">Baleide</span></h4>
                    <p class="text-muted">Belajar lebih mudah, kapan saja, di mana saja. Temukan ilmu baru dan kembangkan potensi terbaikmu.</p>
                    
                    @error('message')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$message}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @enderror

                    <form method="POST" action="{{ url('login') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                required autofocus value="{{ old('email') }}" placeholder="Masukkan Email Terdaftar">
                            <div class="invalid-feedback">
                                Silakan masukkan email Anda yang valid
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Kata Sandi</label>
                            </div>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                                    required placeholder="Masukkan Password Anda">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="icon_box" style="cursor: pointer;">
                                        <i class="fa-sharp fa-solid fa-eye-slash lg mt-1" id="show_hide_password"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback">
                                    Silakan masukkan password Anda
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="/" class="btn btn-outline-danger btn-lg">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                                Masuk Sekarang
                                <i class="fas fa-sign-in-alt"></i>
                            </button>
                        </div>

                        <div class="mt-5 text-center">
                            Belum punya akun? <a href="{{ url('register') }}">Daftar di sini</a>
                        </div>
                    </form>

                    <div class="text-center mt-5 text-small">
                        Copyright &copy; 2026 Baleide.id <br>
                        Semua hak dilindungi.
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8 bg-white col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom d-none d-lg-block d-xl-block"
                data-background="{{ asset('assets/img/banner-1.png') }}">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 display-4 font-weight-bold">Mulai Perjalanan Belajarmu</h1>
                            <h5 class="font-weight-normal text-muted-transparent">Bandung, Indonesia</h5>
                        </div>
                        Dikembangkan oleh <a class="text-light bb" target="_blank" href="#">Baleide Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('#icon_box').click(function(){
            if ($('#password').attr('type') == 'text'){
                $('#password').attr('type', 'password');
                $('#show_hide_password').removeClass('fa-eye').addClass('fa-eye-slash');
            } else if($('#password').attr('type') == 'password'){
                $('#password').attr('type', 'text');
                $('#show_hide_password').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endsection