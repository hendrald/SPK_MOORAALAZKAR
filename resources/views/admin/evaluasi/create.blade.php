@extends('layouts.admin')

@section('title', 'Input Evaluasi - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Formulir Input Nilai Observasi</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Penilaian Kinerja Guru (Angka Real)</h6>
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

        <form action="{{ route('admin.evaluasi.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Pilih Guru <span class="text-danger">*</span></label>
                    <select name="guru_id" class="form-control" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama_lengkap }} ({{ $guru->nip ?? 'Tanpa NIP' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Periode Penilaian <span class="text-danger">*</span></label>
                    <input type="month" name="periode" class="form-control" value="{{ old('periode', date('Y-m')) }}" required>
                    <small class="text-muted">Format: Bulan & Tahun (Contoh: April 2026)</small>
                </div>
            </div>

            <hr class="mt-4 mb-4">
            <h5 class="font-weight-bold mb-4 text-gray-700">Input Parameter C1-Cn</h5>

            <div class="row">
                @foreach($kriterias as $kriteria)
                <div class="col-md-4 form-group">
                    <label title="{{ $kriteria->nama_kriteria }}">
                        <b>{{ $kriteria->kode_kriteria }}</b>
                        @if($kriteria->jenis == 'Benefit')
                            <span class="text-success">(+)</span>
                        @else
                            <span class="text-danger">(-)</span>
                        @endif
                    </label>
                    <small class="d-block text-muted mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $kriteria->nama_kriteria }}</small>
                    <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" class="form-control border-left-primary" value="{{ old('nilai.'.$kriteria->id) }}" placeholder="Skor..." required>
                </div>
                @endforeach
            </div>

            <hr class="mt-4 mb-4">
            <h5 class="font-weight-bold mb-3 text-gray-700">Catatan Penilaian (Opsional)</h5>
            <div class="form-group">
                <textarea name="catatan" rows="3" class="form-control" placeholder="Tulis catatan, saran, atau apresiasi untuk guru terkait...">{{ old('catatan') }}</textarea>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.evaluasi.index') }}" class="btn btn-secondary">Batalkan</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Hasil Observasi</button>
            </div>
        </form>
    </div>
</div>
@endsection
