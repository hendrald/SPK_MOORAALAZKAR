@extends('layouts.admin')

@section('title', 'Ruang Guru - SPK MOORA')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ruang Guru</h1>
</div>

<div class="row">
    <!-- Profil Card -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
            </div>
            <div class="card-body text-center">
                <img class="img-profile rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;" src="{{ asset('sbadmin/img/undraw_profile.svg') }}">
                <h5 class="font-weight-bold">{{ $guru->nama_lengkap ?? Auth::user()->name }}</h5>
                <p class="text-muted mb-1">NIP: {{ $guru->nip ?? '-' }}</p>
                <p class="text-muted"><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</p>
                @if($guru)
                <hr>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="font-weight-bold h5 mb-0">{{ $evaluasis->count() }}</div>
                        <small class="text-muted">Total Evaluasi</small>
                    </div>
                    <div class="col-6">
                        <div class="font-weight-bold h5 mb-0">{{ $guru->no_telp ?? '-' }}</div>
                        <small class="text-muted">No. Telepon</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Riwayat Nilai -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Transparansi Riwayat Nilai Observasi</h6>
            </div>
            <div class="card-body">
                @if(!$guru || $evaluasis->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('sbadmin/img/undraw_posting_photo.svg') }}" style="width: 150px; opacity: 0.5" class="mb-4">
                    <p class="text-muted">Halo! Pihak sekolah belum memberikan nilai observasi untuk Anda pada periode apapun.</p>
                </div>
                @else
                <div class="accordion" id="accordionEvaluasi">
                    @foreach($evaluasis as $index => $eva)
                    <div class="card border-0 mb-2">
                        <div class="card-header bg-light rounded" id="heading{{$index}}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-dark text-decoration-none font-weight-bold d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse{{$index}}">
                                    <span><i class="fas fa-calendar-alt text-primary mr-2"></i> Periode: {{ date('F Y', strtotime($eva->periode . '-01')) }}</span>
                                    <i class="fas fa-chevron-down text-muted" style="font-size: 12px;"></i>
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{$index}}" class="collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{$index}}" data-parent="#accordionEvaluasi">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th width="10%">Kriteria</th>
                                                <th>Nama Indikator / Kriteria</th>
                                                <th width="20%">Skor Didapat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eva->details as $d)
                                            <tr>
                                                <td class="font-weight-bold text-center">{{ $d->kriteria->kode_kriteria }}</td>
                                                <td>{{ $d->kriteria->nama_kriteria }}
                                                    @if($d->kriteria->jenis == 'Benefit')
                                                    <span class="badge badge-success ml-2">Benefit</span>
                                                    @else
                                                    <span class="badge badge-danger ml-2">Cost</span>
                                                    @endif
                                                </td>
                                                <td class="text-center font-weight-bold text-dark">{{ $d->nilai }}</td>
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
