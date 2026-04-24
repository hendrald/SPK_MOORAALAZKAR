@extends('layouts.guru')

@section('title', 'Pengaturan Akun')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Pengaturan Akun</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem;">Perbarui kata sandi dan unggah foto profil terbaru Anda di sini.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
    
    <!-- Left Column: Photo Upload Card -->
    <div class="glass-panel" style="padding: 2.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <div style="background: var(--primary-color); color: white; width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-camera" style="font-size: 0.9rem;"></i>
            </div>
            Foto Profil
        </h3>

        @if(session('success_foto'))
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success_foto') }}
            </div>
        @endif
        @if($errors->has('foto'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('foto') }}
            </div>
        @endif

        <form action="{{ route('guru.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Hidden input to indicate this is a photo update submission -->
            <input type="hidden" name="update_type" value="photo">
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; background: #f1f5f9; position: relative;">
                    @php
                        $guru = \App\Models\Guru::where('user_id', auth()->user()->id)->first();
                    @endphp
                    @if($guru && $guru->foto)
                        <img id="previewImage" src="{{ asset('storage/' . $guru->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img id="previewImage" src="{{ asset('sbadmin/img/undraw_profile.svg') }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main);">Pilih File Foto Baru</label>
                <input type="file" name="foto" id="fotoInput" class="modern-input" accept="image/*" required style="padding: 8px;">
                <small style="display: block; margin-top: 0.5rem; color: var(--text-muted);">Maksimal 2MB. Format: JPG, PNG, GIF.</small>
            </div>

            <button type="submit" class="btn-modern btn-primary-modern" style="width: 100%;">
                <i class="fas fa-upload text-white"></i> Unggah & Simpan Foto
            </button>
        </form>
    </div>

    <!-- Right Column: Password Card -->
    <div class="glass-panel" style="padding: 2.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <div style="background: var(--secondary-color); color: white; width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-lock" style="font-size: 0.9rem;"></i>
            </div>
            Ubah Kata Sandi
        </h3>

        @if(session('success_password'))
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success_password') }}
            </div>
        @endif
        @if(session('error_password'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error_password') }}
            </div>
        @endif
        @if($errors->has('new_password') || $errors->has('current_password'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @if($errors->has('current_password')) <li>{{ $errors->first('current_password') }}</li> @endif
                    @if($errors->has('new_password')) <li>{{ $errors->first('new_password') }}</li> @endif
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="update_type" value="password">
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main);">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" class="modern-input" required placeholder="Masukkan sandi lama...">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main);">Kata Sandi Baru</label>
                <input type="password" name="new_password" class="modern-input" required placeholder="Minimal 6 karakter...">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main);">Ulangi Kata Sandi Baru</label>
                <input type="password" name="new_password_confirmation" class="modern-input" required placeholder="Ketik ulang sandi baru...">
            </div>
            
            <button type="submit" class="btn-modern" style="width: 100%; background: linear-gradient(135deg, var(--secondary-color) 0%, #be185d 100%); color: white; box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);">
                <i class="fas fa-save"></i> Perbarui Kata Sandi
            </button>
        </form>
    </div>

</div>

@push('scripts')
<script>
    // Image Preview Feature
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush
@endsection
