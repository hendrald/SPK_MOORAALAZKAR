@extends('layouts.admin')

@section('title', 'Data Kriteria - SPK MOORA')

@push('css')
<link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Master Data Kriteria</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@php
    $totalBobot = $kriterias->sum('bobot');
@endphp

@if($totalBobot != 100)
<div class="alert alert-warning shadow-sm border-left-warning">
    <i class="fas fa-exclamation-triangle"></i> <strong>Peringatan!</strong> Total bobot kriteria saat ini adalah <strong>{{ $totalBobot }}</strong>.
    Untuk dapat melakukan perhitungan SPK MOORA, total keseluruhan bobot kriteria wajib mencapai <strong>100</strong>.
</div>
@else
<div class="alert alert-info shadow-sm border-left-info">
    <i class="fas fa-check-circle"></i> <strong>Status Bobot Valid:</strong> Total keseluruhan bobot kriteria telah genap <strong>100</strong>. Sistem siap melakukan kalkulasi.
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Parameter Kriteria (C1-Cn)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Kriteria Singkat</th>
                        <th>Sifat (Jenis)</th>
                        <th>Bobot (0.x - 1.0)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriterias as $index => $kriteria)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge-primary">{{ $kriteria->kode_kriteria }}</span></td>
                        <td>{{ $kriteria->nama_kriteria }}</td>
                        <td>
                            @if($kriteria->jenis == 'Benefit')
                                <span class="badge badge-success"><i class="fas fa-arrow-up"></i> Benefit</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-arrow-down"></i> Cost</span>
                            @endif
                        </td>
                        <td><b>{{ $kriteria->bobot }}</b></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
