<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SPK MOORA - Portal Guru">
    
    <title>@yield('title', 'Ruang Guru') - TK Al Azkar</title>

    <!-- FontAwesome -->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Custom Guru Theme CSS -->
    <link href="{{ asset('css/guru-theme.css') }}" rel="stylesheet">
    
    <!-- Add some extra styles for SweetAlert etc if needed -->
    @stack('styles')
</head>

<body>

    <!-- Mobile Topbar -->
    <div class="guru-topbar-mobile">
        <div class="guru-brand mb-0" style="margin-bottom: 0;">
            <i class="fas fa-school"></i>
            <span>TK Al Azkar</span>
        </div>
        <button class="guru-hamburger" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <nav class="guru-sidebar" id="guruSidebar">
        <div class="guru-sidebar-inner">
            <a class="guru-brand" href="{{ route('guru.dashboard') }}">
                <i class="fas fa-school"></i>
                <span>TK Al Azkar</span>
            </a>

            <ul class="guru-nav">
                <li class="guru-nav-item">
                    <a class="guru-nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="guru-nav-item">
                    <a class="guru-nav-link {{ request()->routeIs('guru.riwayat') ? 'active' : '' }}" href="{{ route('guru.riwayat') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Riwayat Penilaian</span>
                    </a>
                </li>
                <li class="guru-nav-item">
                    <a class="guru-nav-link {{ request()->routeIs('guru.settings') ? 'active' : '' }}" href="{{ route('guru.settings') }}">
                        <i class="fas fa-user-cog"></i>
                        <span>Pengaturan Akun</span>
                    </a>
                </li>
            </ul>

            <div style="margin-top: auto;">
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a href="#" class="guru-nav-link text-danger" onclick="document.getElementById('logout-form').submit(); return false;" style="color: #ef4444 !important;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="guru-main-content">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            document.getElementById('guruSidebar').classList.toggle('show');
        }

        // Dropdown/Accordion mechanics for Vanilla JS
        document.addEventListener('DOMContentLoaded', function() {
            const accItems = document.querySelectorAll('.guru-accordion-item');
            accItems.forEach(item => {
                const header = item.querySelector('.guru-accordion-header');
                header.addEventListener('click', () => {
                    // Toggle active class
                    const isActive = item.classList.contains('active');
                    
                    // Close all first if you want exclusive accordion. Or comment out to allow multiple open.
                    accItems.forEach(i => i.classList.remove('active'));
                    
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
