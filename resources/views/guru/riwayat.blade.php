@extends('layouts.guru')

@section('title', 'Riwayat Penilaian')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Riwayat Penilaian</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem;">Pilih tahun dan bulan pada kotak di bawah ini untuk melihat rincian hasil observasi Anda.</p>
</div>

<!-- Picker Box -->
<div class="glass-panel" style="padding: 1.5rem 2rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
    <div style="display: flex; align-items: center; gap: 15px; color: var(--primary-color); font-weight: 600;">
        <i class="fas fa-filter" style="font-size: 1.25rem;"></i> Filter Periode:
    </div>
    
    <form action="{{ route('guru.riwayat') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-grow: 1; min-width: 250px;">
        <select name="periode" class="modern-input" style="max-width: 300px; padding: 10px 16px; cursor: pointer; appearance: auto;" required>
            <option value="">-- Pilih Bulan & Tahun --</option>
            @foreach($periods as $p)
                <option value="{{ $p }}" {{ $selectedPeriod == $p ? 'selected' : '' }}>
                    {{ date('F Y', strtotime($p . '-01')) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-modern btn-primary-modern" style="padding: 10px 20px;">
            <i class="fas fa-search"></i> Tampilkan
        </button>
    </form>
</div>

<!-- Evaluation Content -->
@if($selectedPeriod)
    @if($evaluasi)
    <div class="glass-panel" style="padding: 2.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 4px;">Hasil Observasi Periode {{ date('F Y', strtotime($selectedPeriod . '-01')) }}</h2>
                <p style="color: var(--text-muted); margin: 0;">Berikut adalah rincian skor indikator dari kepala sekolah.</p>
            </div>
            <a href="{{ route('guru.cetak_rapor', $selectedPeriod) }}" target="_blank" class="btn-modern btn-outline-modern">
                <i class="fas fa-print"></i> Cetak Dokumen Rapor
            </a>
        </div>

        <div style="background: white; border-radius: 1rem; overflow: hidden; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width: 10%; text-align: center;">No/Kode</th>
                        <th>Kriteria Penilaian</th>
                        <th style="width: 25%; text-align: center;">Skor Diperoleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluasi->details as $d)
                    <tr>
                        <td style="font-weight: 700; color: var(--primary-color); text-align: center;">{{ $d->kriteria->kode_kriteria }}</td>
                        <td>
                            <div style="font-weight: 600; font-size: 1.05rem;">{{ $d->kriteria->nama_kriteria }}</div>
                            @if($d->kriteria->jenis == 'Benefit')
                                <span class="guru-badge guru-badge-benefit" style="margin-top: 6px; display: inline-block;">Benefit (+)</span>
                            @else
                                <span class="guru-badge guru-badge-cost" style="margin-top: 6px; display: inline-block;">Cost (-)</span>
                            @endif
                        </td>
                        <td style="text-align: center; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
                            {{ $d->nilai }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($evaluasi->catatan)
        <div style="margin-top: 2rem; background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.2); border-left: 5px solid var(--primary-color); border-radius: 1rem; padding: 1.5rem;">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary-color); margin-top: 0; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-comment-dots" style="font-size: 1.25rem;"></i> Pesan / Catatan Evaluasi Kepala Sekolah:
            </h4>
            <p style="margin: 0; white-space: pre-line; color: var(--text-main); font-size: 1.05rem; line-height: 1.7;">{{ $evaluasi->catatan }}</p>
        </div>
        @endif
    </div>
    @else
    <div class="glass-panel" style="padding: 4rem 2rem; text-align: center;">
        <i class="fas fa-exclamation-circle" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1.5rem;"></i>
        <h3 style="font-size: 1.25rem; font-weight: 700;">Data Tidak Ditemukan</h3>
        <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto;">Maaf, sepertinya tidak ada data evaluasi untuk Anda pada periode yang dipilih.</p>
    </div>
    @endif
@else
    <!-- Initial blank state before selection -->
    <div class="glass-panel" style="padding: 5rem 2rem; text-align: center; background: rgba(255,255,255,0.4);">
        <img src="{{ asset('sbadmin/img/undraw_posting_photo.svg') }}" alt="Pilih Periode" style="width: 200px; opacity: 0.8; margin-bottom: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">Menunggu Pilihan Anda</h3>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 500px; margin: 0 auto;">Gunakan form di atas untuk memilih bulan dan tahun evaluasi yang ingin Anda tinjau nilainya.</p>
    </div>
@endif

@endsection
