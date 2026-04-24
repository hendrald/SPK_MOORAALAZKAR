@extends('layouts.admin')

@section('title', 'Edit Evaluasi - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Nilai Observasi</h1>

<div class="card shadow mb-4 border-left-warning">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-warning">Perbarui Penilaian: {{ $evaluasi->guru->nama_lengkap }}</h6>
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
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.evaluasi.update', $evaluasi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Pilih Guru <span class="text-danger">*</span></label>
                    <select name="guru_id" class="form-control" required readonly style="pointer-events: none; background: #e9ecef;">
                        <!-- To prevent changing guru mid-evaluation -->
                        <option value="{{ $evaluasi->guru_id }}">{{ $evaluasi->guru->nama_lengkap }} ({{ $evaluasi->guru->nip ?? '-' }})</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Periode Penilaian <span class="text-danger">*</span></label>
                    <input type="month" name="periode" class="form-control" value="{{ old('periode', $evaluasi->periode) }}" required>
                </div>
            </div>

            <hr class="mt-4 mb-4">
            <h5 class="font-weight-bold mb-4 text-gray-700">Skor Input Tersimpan (C1-Cn)</h5>

            <div class="row">
                @foreach($kriterias as $kriteria)
                @php
                    // Retrieve stored value for this specific criteria
                    $storedValue = $evaluasi->details->where('kriteria_id', $kriteria->id)->first();
                    $nilai = $storedValue ? $storedValue->nilai : 0;
                @endphp
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
                    <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}]" class="form-control border-left-warning" value="{{ old('nilai.'.$kriteria->id, $nilai) }}" required>
                </div>
                @endforeach
            </div>

            <hr class="mt-4 mb-4">
            <h5 class="font-weight-bold mb-3 text-gray-700">Catatan Penilaian (Opsional)</h5>
            <div class="form-group">
                <textarea name="catatan" rows="3" class="form-control" placeholder="Tulis catatan, saran, atau apresiasi untuk guru terkait...">{{ old('catatan', $evaluasi->catatan) }}</textarea>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.evaluasi.index') }}" class="btn btn-secondary">Batalkan</a>
                <button type="submit" class="btn btn-warning text-dark"><i class="fas fa-edit"></i> Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
