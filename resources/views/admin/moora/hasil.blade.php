@extends('layouts.admin')

@section('title', 'Hasil Akhir SPK - MOORA')

@push('css')
<style>
    .winner-row { background-color: rgba(27, 122, 67, 0.15) !important; font-weight: bold; }
    .winner-row td:first-child::before {
        content: "\f091";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #f6c23e;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Akhir Keputusan MOORA</h1>
    <div>
        <form action="{{ route('admin.moora.hitung') }}" method="POST" target="_blank" class="d-inline">
            @csrf
            <input type="hidden" name="periode" value="{{ $periode }}">
            <input type="hidden" name="action" value="cetak">
            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan (PDF)</button>
        </form>
        <form action="{{ route('admin.moora.hitung') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="periode" value="{{ $periode }}">
            <input type="hidden" name="action" value="excel">
            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ml-2"><i
                class="fas fa-file-excel fa-sm text-white-50"></i> Export CSV/Excel</button>
        </form>
    </div>
</div>

<p>Periode Evaluasi: <b>{{ date('F Y', strtotime($periode . '-01')) }}</b></p>

<!-- MATRIKS AWAL (X) -->
<div class="card shadow mb-4">
    <a href="#collapseMatriksX" class="d-block card-header py-3" data-toggle="collapse"
        role="button" aria-expanded="false" aria-controls="collapseMatriksX">
        <h6 class="m-0 font-weight-bold text-primary">1. Matriks Keputusan (X)</h6>
    </a>
    <div class="collapse" id="collapseMatriksX">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th>Nama Guru</th>
                            @foreach($kriterias as $k)
                            <th>{{ $k->kode_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluasis as $evaluasi)
                        <tr>
                            <td>{{ $evaluasi->guru->nama_lengkap }}</td>
                            @foreach($kriterias as $k)
                            <td>{{ $matriksX[$evaluasi->id][$k->id] }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MATRIKS NORMALISASI (X*) -->
<div class="card shadow mb-4">
    <a href="#collapseMatriksN" class="d-block card-header py-3" data-toggle="collapse"
        role="button" aria-expanded="false" aria-controls="collapseMatriksN">
        <h6 class="m-0 font-weight-bold text-primary">2. Matriks Normalisasi (X*)</h6>
    </a>
    <div class="collapse" id="collapseMatriksN">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th>Nama Guru</th>
                            @foreach($kriterias as $k)
                            <th>{{ $k->kode_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluasis as $evaluasi)
                        <tr>
                            <td>{{ $evaluasi->guru->nama_lengkap }}</td>
                            @foreach($kriterias as $k)
                            <td>{{ number_format($matriksNormalisasi[$evaluasi->id][$k->id], 4) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- HASIL AKHIR (YI) DAN RANKING -->
<div class="card shadow mb-4 border-bottom-primary">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">3. Nilai Akhir & Pemeringkatan (Yi)</h6>
    </div>
    <div class="card-body">
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <b>Keputusan:</b> Berdasarkan perhitungan Multi-Objective Optimization on the basis of Ratio Analysis (MOORA), guru dengan peringkat terbaik pada periode ini jatuh kepada <b>{{ $hasilAkhir[0]['guru'] }}</b>.
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-primary text-white">
                        <th width="10%" class="text-center">Peringkat</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>Nilai Yi Akhir (Benefit - Cost)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasilAkhir as $index => $row)
                    <tr class="{{ $index == 0 ? 'winner-row' : '' }}">
                        <td class="text-center"><h3>{{ $index + 1 }}</h3></td>
                        <td>{{ $row['nip'] ?? '-' }}</td>
                        <td>{{ $row['guru'] }}</td>
                        <td><h4 class="{{ $index == 0 ? 'text-success' : 'text-gray-800' }} font-weight-bold">{{ number_format($row['nilai_yi'], 4) }}</h4></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('admin.moora.index') }}" class="btn btn-outline-primary px-4"><i class="fas fa-arrow-left mr-1"></i> Kembali Pilih Periode</a>
        </div>
    </div>
</div>

@endsection
