@extends('layouts.admin')

@section('title', 'Pilih Periode - SPK MOORA')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Perhitungan Hasil MOORA</h1>

<div class="row">
    <div class="col-xl-6 col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pilih Periode Evaluasi</h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                <p>Mesin SPK berbasis MOORA akan memproses seluruh data input obeservasi pada periode yang Anda pilih untuk memberikan pemeringkatan akhir.</p>
                <form action="{{ route('admin.moora.hitung') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Bulan / Tahun Evaluasi</label>
                        <select name="periode" class="form-control" required>
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periodes as $p)
                                <option value="{{ $p->periode }}">{{ date('F Y', strtotime($p->periode . '-01')) }} ({{$p->periode}})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-calculator"></i> Proses Perhitungan MOORA</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
