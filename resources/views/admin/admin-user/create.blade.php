@extends('layouts.admin')

@section('title', 'Tambah Admin - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Akun Admin Baru</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Registrasi Admin (Tim Penilai)</h6>
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

        <form action="{{ route('admin.admin-user.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama lengkap admin">
                </div>
                <div class="col-md-6 form-group">
                    <label>Email Login <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@tkalazkar.sch.id">
                </div>
                <div class="col-md-6 form-group">
                    <label>Password Akun <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                </div>
            </div>
            
            <a href="{{ route('admin.admin-user.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Akun Admin</button>
        </form>
    </div>
</div>
@endsection
