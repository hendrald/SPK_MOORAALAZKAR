@extends('layouts.admin')

@section('title', 'Edit Kriteria - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Kriteria Evaluasi</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Update Parameter: {{ $kriteria->kode_kriteria }}</h6>
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

        <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Kode Kriteria (Contoh: C11) <span class="text-danger">*</span></label>
                    <input type="text" name="kode_kriteria" class="form-control" value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Nama Kriteria / Topik Penilaian <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kriteria" class="form-control" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Jenis (Sifat Parameter) <span class="text-danger">*</span></label>
                    <select name="jenis" class="form-control" required>
                        <option value="Benefit" {{ old('jenis', $kriteria->jenis) == 'Benefit' ? 'selected' : '' }}>Benefit (+ Menguntungkan)</option>
                        <option value="Cost" {{ old('jenis', $kriteria->jenis) == 'Cost' ? 'selected' : '' }}>Cost (- Merugikan)</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Nilai Bobot (Skala 1-100, cth: 15) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="bobot" class="form-control @error('bobot') is-invalid @enderror" value="{{ old('bobot', $kriteria->bobot) }}" required>
                    @error('bobot')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
