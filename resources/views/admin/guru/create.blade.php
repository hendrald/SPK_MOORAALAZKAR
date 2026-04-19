@extends('layouts.admin')

@section('title', 'Tambah Guru - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Data Guru Baru</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran Guru</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>NIP (Opsional)</label>
                    <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Email Login <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Password Akun <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="col-md-6 form-group">
                    <label>No. Telepon (Opsional)</label>
                    <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Foto Profil (Opsional, max 2MB)</label>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                </div>
            </div>
            
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Profil & Akun</button>
        </form>
    </div>
</div>
@endsection
