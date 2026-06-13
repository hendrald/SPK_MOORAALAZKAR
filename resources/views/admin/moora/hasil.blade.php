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

<p>Periode Evaluasi: <b>{{ $periode }}</b></p>

<!-- HASIL AKHIR (YI) DAN RANKING -->
<div class="card shadow mb-4 border-bottom-primary">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nilai Akhir & Pemeringkatan (Rata-rata Yi)</h6>
    </div>
    <div class="card-body">
        @if(count($hasilAkhir) > 0)
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <b>Keputusan:</b> Berdasarkan hasil rata-rata akumulasi penilaian dari {{ count($penilaiResults) }} Tim Penilai menggunakan metode MOORA, guru dengan kinerja terbaik pada periode <b>{{ $periode }}</b> adalah <b>{{ $hasilAkhir[0]['guru'] }}</b> dengan nilai rata-rata <b>{{ number_format($hasilAkhir[0]['nilai_yi'], 4) }}</b>.
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-primary text-white">
                        <th width="10%" class="text-center">Peringkat</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        @foreach($penilaiResults as $pId => $pRes)
                        <th class="text-center">Yi ({{ $pRes['penilai']->name }})</th>
                        @endforeach
                        <th class="text-center">Rata-rata Yi (Akhir)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasilAkhir as $index => $row)
                    <tr class="{{ $index == 0 ? 'winner-row' : '' }}">
                        <td class="text-center"><h3>{{ $index + 1 }}</h3></td>
                        <td>{{ $row['nip'] ?? '-' }}</td>
                        <td>{{ $row['guru'] }}</td>
                        @foreach($penilaiResults as $pId => $pRes)
                        <td class="text-center text-muted font-italic">
                            {{ isset($row['scores'][$pId]) ? number_format($row['scores'][$pId], 4) : '-' }}
                        </td>
                        @endforeach
                        <td class="text-center">
                            <h4 class="{{ $index == 0 ? 'text-success' : 'text-gray-800' }} font-weight-bold mb-0">
                                {{ number_format($row['nilai_yi'], 4) }}
                            </h4>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- RINCIAN PERHITUNGAN PER PENILAI -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Rincian Perhitungan Per Penilai (Evaluator)</h6>
    </div>
    <div class="card-body">
        <p class="text-muted">Di bawah ini adalah rincian matriks keputusan dan normalisasi yang diinput oleh masing-masing tim penilai secara terpisah sebelum dirata-ratakan.</p>
        
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mb-4" id="penilaiTab" role="tablist">
            @foreach($penilaiResults as $pId => $pRes)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-btn-{{ $pId }}" data-toggle="tab" href="#tab-pane-{{ $pId }}" role="tab" aria-controls="tab-pane-{{ $pId }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    <i class="fas fa-user-edit mr-1"></i> {{ $pRes['penilai']->name }}
                </a>
            </li>
            @endforeach
        </ul>
        
        <!-- Tab Panes -->
        <div class="tab-content" id="penilaiTabContent">
            @foreach($penilaiResults as $pId => $pRes)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-pane-{{ $pId }}" role="tabpanel" aria-labelledby="tab-btn-{{ $pId }}">
                
                <!-- 1. Matriks Keputusan (X) -->
                <div class="card mb-4">
                    <div class="card-header py-2 bg-light">
                        <span class="font-weight-bold text-primary">1. Matriks Keputusan (X) - {{ $pRes['penilai']->name }}</span>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center" style="font-size: 0.85rem;" width="100%">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="text-left">Nama Guru</th>
                                        @foreach($kriterias as $k)
                                        <th>{{ $k->kode_kriteria }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pRes['evaluasis'] as $evaluasi)
                                    <tr>
                                        <td class="text-left font-weight-bold">{{ $evaluasi->guru->nama_lengkap }}</td>
                                        @foreach($kriterias as $k)
                                        <td>{{ $pRes['matriksX'][$evaluasi->id][$k->id] ?? 0 }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 2. Matriks Normalisasi (X*) -->
                <div class="card mb-4">
                    <div class="card-header py-2 bg-light">
                        <span class="font-weight-bold text-primary">2. Matriks Normalisasi Terbobot (X*) - {{ $pRes['penilai']->name }}</span>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center" style="font-size: 0.85rem;" width="100%">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="text-left">Nama Guru</th>
                                        @foreach($kriterias as $k)
                                        <th>{{ $k->kode_kriteria }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pRes['evaluasis'] as $evaluasi)
                                    <tr>
                                        <td class="text-left font-weight-bold">{{ $evaluasi->guru->nama_lengkap }}</td>
                                        @foreach($kriterias as $k)
                                        <td>{{ isset($pRes['matriksNormalisasi'][$evaluasi->id][$k->id]) ? number_format($pRes['matriksNormalisasi'][$evaluasi->id][$k->id], 4) : '0.0000' }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 3. Hasil Yi Individual -->
                <div class="card">
                    <div class="card-header py-2 bg-light">
                        <span class="font-weight-bold text-primary">3. Nilai Yi Penilai Ini - {{ $pRes['penilai']->name }}</span>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive" style="max-width: 500px;">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th>Nama Guru</th>
                                        <th class="text-center">Nilai Yi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pRes['evaluasis'] as $evaluasi)
                                    <tr>
                                        <td>{{ $evaluasi->guru->nama_lengkap }}</td>
                                        <td class="text-center font-weight-bold">{{ number_format($pRes['hasilPenilai'][$evaluasi->guru_id], 4) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.moora.index') }}" class="btn btn-outline-primary px-4"><i class="fas fa-arrow-left mr-1"></i> Kembali Pilih Periode</a>
        </div>
    </div>
</div>

@endsection
