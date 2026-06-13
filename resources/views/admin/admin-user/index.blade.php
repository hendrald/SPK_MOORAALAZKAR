@extends('layouts.admin')

@section('title', 'Kelola Admin - SPK MOORA')

@push('css')
<link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Manajemen Akun Admin (Tim Penilai)</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Akun Admin</h6>
        <a href="{{ route('admin.admin-user.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Admin</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Email Login</th>
                        <th>Peran (Role)</th>
                        <th>Tanggal Terdaftar</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $index => $admin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><b>{{ $admin->name }}</b></td>
                        <td>{{ $admin->email }}</td>
                        <td><span class="badge badge-success"><i class="fas fa-user-shield"></i> {{ ucfirst($admin->role) }}</span></td>
                        <td>{{ $admin->created_at ? $admin->created_at->format('d F Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.admin-user.edit', $admin->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            
                            @if($admin->id !== auth()->id())
                            <form action="{{ route('admin.admin-user.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akun admin ini? Tindakan ini akan menghapus semua penilaian yang pernah diinput oleh admin ini.')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                            @else
                            <button class="btn btn-danger btn-sm disabled" title="Tidak bisa menghapus diri sendiri" disabled><i class="fas fa-trash"></i></button>
                            @endif
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
