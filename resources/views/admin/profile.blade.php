@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengaturan Akun Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Email Aktif</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-gray-800 font-weight-bold"><i class="fas fa-lock text-primary mr-2"></i>Ubah Password (Opsional)</h5>
                    <p class="text-muted small">Kosongkan bagian ini jika Anda tidak ingin mengubah password masuk Anda.</p>

                    <div class="form-group">
                        <label>Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Isi bila ingin mengubah password">
                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Minimal 6 karakter">
                        @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <img class="img-profile rounded-circle mb-3 border border-light shadow-sm" src="{{ asset('sbadmin/img/undraw_profile.svg') }}" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="font-weight-bold">{{ Auth::user()->name }}</h5>
                <span class="badge badge-primary px-3 py-2 text-uppercase">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
