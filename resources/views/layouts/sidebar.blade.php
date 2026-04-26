<ul class="navbar-nav bg-gradient-alazkar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo.png') }}" alt="Logo TK Al Azkar" style="max-height: 40px; border-radius: 4px; object-fit: contain;">
        </div>
        <div class="sidebar-brand-text mx-3">TK Al Azkar <sup>SPK</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        @if(Auth::user()->role === 'admin')
            <a class="nav-link" href="{{ route('admin.dashboard') ?? url('/admin/dashboard') }}">
        @else
            <a class="nav-link" href="{{ route('guru.dashboard') }}">
        @endif
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if(Auth::user()->role === 'admin')
    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Data Guru -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.guru.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Data Guru</span></a>
    </li>

    <!-- Nav Item - Data Kriteria -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.kriteria.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Data Kriteria</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Evaluasi
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.evaluasi.index') }}">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Input Nilai Observasi</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.moora.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Hasil Akhir (MOORA)</span></a>
    </li>
    @elseif(Auth::user()->role === 'guru')
    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Guru
    </div>

    <!-- Nav Item - Pengaturan Akun -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('guru.settings') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan Akun</span></a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
