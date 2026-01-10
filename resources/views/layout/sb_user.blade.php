<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Selamat Membaca</div>
                <div class="dropdown-divider"></div>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/dashboard') }}">BALEIDE</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/dashboard') }}">BL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Utama</li>
            <li {{ $sb == 'Dashboard' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Koleksi</li>
            <li {{ $sb == 'MyBooks' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('dashboard/my-books') }}">
                    <i class="fas fa-book-open"></i> <span>Buku Saya</span>
                </a>
            </li>

            <li class="menu-header">Aktivitas</li>
            <li {{ $sb == 'Transaction' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('dashboard/transactions') }}">
                    <i class="fas fa-shopping-bag"></i> <span>Riwayat Pesanan</span>
                </a>
            </li>
            
            <li {{ $sb == 'Profile' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('dashboard/profile') }}">
                    <i class="fas fa-user-circle"></i> <span>Profil Saya</span>
                </a>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="{{ url('/ebook') }}"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-shopping-cart"></i> Jelajahi Toko
            </a>
        </div>
    </aside>
</div>