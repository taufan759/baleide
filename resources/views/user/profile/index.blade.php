@extends('master')

@section('title', 'Profil Saya - Baleide')

@section('content')
<style>
    .profile-header-bg {
        height: 130px;
        background: #2c3e50; 
        background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
        position: relative;
    }
    
    .profile-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
    }

    .profile-avatar-wrapper {
        margin-top: -65px;
        position: relative;
        z-index: 2;
    }

    .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 6px solid #fff;
        object-fit: cover;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-section-title {
        font-size: 17px;
        font-weight: 800;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 25px;
        border-left: 4px solid #2c3e50;
        padding-left: 15px;
    }

    .btn-save {
        background: #2c3e50;
        color: #fff;
        border-radius: 50px;
        padding: 10px 30px;
        font-weight: 700;
        transition: all 0.3s;
        border: none;
    }

    .btn-save:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        color: #000000;
    }

    .custom-input {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        padding: 12px 15px;
        height: auto;
    }

    .custom-input:focus {
        border-color: #4ca1af;
        box-shadow: 0 0 0 0.2rem rgba(76, 161, 175, 0.1);
    }

    .card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Akun</h1>
        </div>

        <div class="section-body">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible show fade shadow-sm">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="profile-card text-center mb-4">
                        <div class="profile-header-bg"></div>
                        <div class="profile-avatar-wrapper">
                            @php
                                $avatarUrl = $user->avatar 
                                    ? asset('assets/avatar/' . $user->avatar) 
                                    : asset('assets/img/avatar/avatar-1.png');
                            @endphp
                            <img src="{{ $avatarUrl }}" class="profile-avatar" alt="Avatar">
                        </div>
                        <div class="p-4">
                            <h4 class="font-weight-bold mb-1" style="color: #2c3e50;">{{ $user->name }}</h4>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                            <hr>
                            <p class="small text-muted mb-0">Member sejak {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <form method="post" action="{{ url('dashboard/profile/password') }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <span class="form-section-title">Keamanan Akun</span>
                                <div class="form-group">
                                    <label class="font-weight-600">Password Saat Ini</label>
                                    <input type="password" name="current_password" class="form-control custom-input @error('current_password') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-600">Password Baru</label>
                                    <input type="password" name="password" class="form-control custom-input @error('password') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-600">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control custom-input" required>
                                </div>
                                <button type="submit" class="btn btn-save btn-block">Ganti Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ url('dashboard/profile/update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <span class="form-section-title">Informasi Pribadi</span>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control custom-input" value="{{ old('name', $user->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Nomor Telepon</label>
                                            <input type="text" name="phone" class="form-control custom-input" value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-600">Alamat Email</label>
                                    <input type="email" name="email" class="form-control custom-input" value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-600">Alamat Lengkap</label>
                                    <textarea name="address" class="form-control custom-input" rows="4" style="min-height: 120px;">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-600">Foto Profil Baru</label>
                                    <div class="custom-file">
                                        <input type="file" name="avatar" class="custom-file-input" id="avatarFile">
                                        <label class="custom-file-label" for="avatarFile">Pilih file...</label>
                                    </div>
                                    <small class="text-muted mt-2 d-block">Maksimal 2MB (Format: JPG atau PNG)</small>
                                </div>

                                <div class="text-right mt-4">
                                    <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Update label file input
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("avatarFile").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endsection