@extends('layouts.admin')

@section('title', 'Data Guru - SPK MOORA')

@push('css')
<link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-2 text-gray-800">Master Data Guru</h1>
<p class="mb-4">Data nama seluruh guru di TK Al Azkar beserta kredensial akun mereka yang digunakan untuk proses evaluasi dan login ke dalam sistem.</p>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Guru Terdaftar</h6>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Guru</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>NIP</th>
                        <th>Profil & Nama Lengkap</th>
                        <th>Email Login</th>
                        <th>No. Telepon</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $index => $guru)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guru->nip ?? '-' }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($guru->foto)
                                    <img src="{{ Storage::url($guru->foto) }}" alt="Foto" class="rounded-circle mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mr-2 text-white" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <span>{{ $guru->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td>{{ $guru->user->email }}</td>
                        <td>{{ $guru->no_telp ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus guru ini beserta riwayat nilainya?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
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
