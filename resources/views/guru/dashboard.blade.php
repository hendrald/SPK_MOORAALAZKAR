@extends('layouts.guru')

@section('title', 'Beranda')

@section('content')
<div style="margin-bottom: 2rem; max-width: 800px; margin-left: auto; margin-right: auto; text-align: center;">
    <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Halo, {{ explode(' ', $guru->nama_lengkap ?? Auth::user()->name)[0] }}!</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Selamat datang di Portal Guru TK Al Azkar. Di sini Anda dapat melihat rekam jejak performa observasi Anda.</p>
</div>

<div style="display: flex; justify-content: center; align-items: center;">
    <!-- Profile Card -->
    <div class="glass-panel" style="padding: 3rem; text-align: center; width: 100%; max-width: 450px;">
        <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 1.5rem auto;">
            @if($guru && $guru->foto)
                <img src="{{ asset('storage/' . $guru->foto) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid rgba(255,255,255,0.2); box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            @else
                <img src="{{ asset('img/logo.png') }}" alt="Default Profile" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%; border: 4px solid rgba(255,255,255,0.2); box-shadow: 0 4px 20px rgba(0,0,0,0.3); background: white;">
            @endif
        </div>
        
        <h2 style="font-size: 1.6rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $guru->nama_lengkap ?? Auth::user()->name }}</h2>
        <p style="color: var(--primary-color); font-weight: 500; margin-bottom: 2rem;">NIP: {{ $guru->nip ?? 'Belum Diatur' }}</p>
        
        <div style="display: flex; flex-direction: column; gap: 12px; text-align: left; background: rgba(15, 23, 42, 0.4); padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: rgba(255,255,255,0.1); width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #818cf8; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <i class="fas fa-envelope"></i>
                </div>
                <div style="overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                    <small style="display: block; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Email Account</small>
                    <span style="font-weight: 600;">{{ Auth::user()->email }}</span>
                </div>
            </div>
            @if($guru)
            <div style="display: flex; align-items: center; gap: 12px; margin-top: 5px;">
                <div style="background: rgba(255,255,255,0.1); width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--secondary-color); box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <small style="display: block; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">No. Telepon</small>
                    <span style="font-weight: 600;">{{ $guru->no_telp ?? '-' }}</span>
                </div>
            </div>
            @endif
        </div>
        
        <div style="display: flex; gap: 10px; margin-top: 2rem;">
            <a href="{{ route('guru.riwayat') }}" class="btn-modern btn-primary-modern" style="flex: 1; padding: 12px;">
                <i class="fas fa-chart-bar"></i> Lihat Rapor
            </a>
            <a href="{{ route('guru.settings') }}" class="btn-modern btn-outline-modern" style="width: 50px; padding: 12px; box-sizing: border-box;" title="Edit Profil">
                <i class="fas fa-user-edit"></i>
            </a>
        </div>
    </div>
</div>
@endsection
