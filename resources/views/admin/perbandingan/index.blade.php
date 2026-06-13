@extends('layouts.admin')

@section('title', 'Perbandingan Periode - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Perbandingan Nilai Antar Periode</h1>

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Periode Pembanding</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.perbandingan') }}" method="GET" class="form-inline">
            <div class="form-group mr-3">
                <label for="period1" class="mr-2">Periode 1 (Lama):</label>
                <select name="period1" id="period1" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periodes as $p)
                        <option value="{{ $p }}" {{ $p1 == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mr-3">
                <label for="period2" class="mr-2">Periode 2 (Baru):</label>
                <select name="period2" id="period2" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periodes as $p)
                        <option value="{{ $p }}" {{ $p2 == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-exchange-alt mr-1"></i> Bandingkan</button>
        </form>
    </div>
</div>

@if($p1 && $p2)
<div class="card shadow mb-4 border-left-primary">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Analisis Perbandingan: {{ $p1 }} vs {{ $p2 }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-primary text-white text-center">
                        <th rowspan="2" class="align-middle" width="5%">No</th>
                        <th rowspan="2" class="align-middle" style="text-align: left;">Nama Guru</th>
                        <th colspan="2" class="border-bottom-0">{{ $p1 }}</th>
                        <th colspan="2" class="border-bottom-0">{{ $p2 }}</th>
                        <th colspan="2" class="border-bottom-0">Perubahan / Tren</th>
                    </tr>
                    <tr class="bg-primary text-white text-center" style="font-size: 0.9rem;">
                        <th>Peringkat</th>
                        <th>Skor Yi</th>
                        <th>Peringkat</th>
                        <th>Skor Yi</th>
                        <th>Peringkat</th>
                        <th>Skor Yi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comparisonData as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><b>{{ $row['guru'] }}</b><br><small class="text-muted">NIP: {{ $row['nip'] ?? '-' }}</small></td>
                        
                        <!-- Periode 1 -->
                        <td class="text-center">
                            @if($row['p1'])
                                <span class="badge badge-secondary" style="font-size: 0.9rem;">#{{ $row['p1']['rank'] }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center font-weight-bold">
                            {{ $row['p1'] ? number_format($row['p1']['nilai_yi'], 4) : '-' }}
                        </td>

                        <!-- Periode 2 -->
                        <td class="text-center">
                            @if($row['p2'])
                                <span class="badge badge-info" style="font-size: 0.9rem;">#{{ $row['p2']['rank'] }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center font-weight-bold text-gray-900">
                            {{ $row['p2'] ? number_format($row['p2']['nilai_yi'], 4) : '-' }}
                        </td>

                        <!-- Tren Peringkat -->
                        <td class="text-center">
                            @if($row['trend_rank'] !== null)
                                @if($row['trend_rank'] > 0)
                                    <span class="text-success font-weight-bold"><i class="fas fa-caret-up"></i> Naik {{ $row['trend_rank'] }} Posisi</span>
                                @elseif($row['trend_rank'] < 0)
                                    <span class="text-danger font-weight-bold"><i class="fas fa-caret-down"></i> Turun {{ abs($row['trend_rank']) }} Posisi</span>
                                @else
                                    <span class="text-secondary font-weight-bold"><i class="fas fa-minus"></i> Tetap</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <!-- Tren Skor Yi -->
                        <td class="text-center">
                            @if($row['trend_yi'] !== null)
                                @if($row['trend_yi'] > 0)
                                    <span class="text-success font-weight-bold">+{{ number_format($row['trend_yi'], 4) }}</span>
                                @elseif($row['trend_yi'] < 0)
                                    <span class="text-danger font-weight-bold">{{ number_format($row['trend_yi'], 4) }}</span>
                                @else
                                    <span class="text-secondary">0.0000</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Tidak ada data guru yang dievaluasi pada kedua periode tersebut.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
