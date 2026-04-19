@extends('layouts.admin')

@section('title', 'Data Evaluasi Guru - SPK MOORA')

@push('css')
<link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-2 text-gray-800">Data Observasi / Evaluasi Guru</h1>
<p class="mb-4">Tabel hasil _input_ penilaian yang didapatkan masing-masing guru pada suatu periode. Data ini yang akan diproses oleh mesin MOORA untuk diranking.</p>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Rekap Hasil Evaluasi</h6>
        <a href="{{ route('admin.evaluasi.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Input Nilai Baru</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Periode</th>
                        <th>Nama Guru</th>
                        <th>Jumlah Parameter Dinilai</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluasis as $index => $eva)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge-info">{{ $eva->periode }}</span></td>
                        <td><b>{{ $eva->guru->nama_lengkap }}</b></td>
                        <td>{{ $eva->details()->count() }} Kriteria</td>
                        <td>
                            <a href="{{ route('admin.evaluasi.edit', $eva->id) }}" class="btn btn-warning btn-sm" title="Edit Rincian"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.evaluasi.destroy', $eva->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus seluruh nilai evaluasi guru ini pada periode {{ $eva->periode }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data nilai observasi sejauh ini.</td>
                    </tr>
                    @endforelse
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
