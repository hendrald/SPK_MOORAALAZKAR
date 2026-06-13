@extends('layouts.guru')

@section('title', 'Perbandingan Kinerja Saya')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Perbandingan Kinerja Saya</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem;">Bandingkan hasil evaluasi Anda antar semester untuk melacak peningkatan kompetensi dan aspek yang perlu ditingkatkan.</p>
</div>

@if(session('error'))
<div style="background: rgba(241, 127, 114, 0.15); border: 2px solid var(--secondary-color); color: #c0392b; border-radius: 1.5rem; padding: 1rem 1.5rem; margin-bottom: 2rem; font-weight: 600;">
    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
</div>
@endif

<!-- Form Filter Periode -->
<div class="glass-panel" style="padding: 1.5rem 2rem; margin-bottom: 2rem;">
    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-color); margin-top: 0; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-filter"></i> Pilih Periode Pembanding
    </h3>
    <form action="{{ route('guru.perbandingan') }}" method="GET" style="display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px;">
            <label for="period1" style="font-weight: 700; color: var(--primary-color); display: block; margin-bottom: 8px; font-size: 0.95rem;">Periode 1 (Lama):</label>
            <select name="period1" id="period1" class="modern-input" style="padding: 10px 16px; cursor: pointer; appearance: auto;" required>
                <option value="">-- Pilih Periode --</option>
                @foreach($periodes as $p)
                    <option value="{{ $p }}" {{ $p1 == $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        
        <div style="flex: 1; min-width: 200px;">
            <label for="period2" style="font-weight: 700; color: var(--primary-color); display: block; margin-bottom: 8px; font-size: 0.95rem;">Periode 2 (Baru):</label>
            <select name="period2" id="period2" class="modern-input" style="padding: 10px 16px; cursor: pointer; appearance: auto;" required>
                <option value="">-- Pilih Periode --</option>
                @foreach($periodes as $p)
                    <option value="{{ $p }}" {{ $p2 == $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div style="flex: 0 0 auto;">
            <button type="submit" class="btn-modern btn-primary-modern" style="padding: 11px 24px;">
                <i class="fas fa-exchange-alt"></i> Bandingkan
            </button>
        </div>
    </form>
</div>

@if($p1 && $p2 && $summaryGuru)
<!-- Ringkasan Perbandingan -->
<div style="display: flex; gap: 20px; margin-bottom: 2rem; flex-wrap: wrap;">
    <!-- Rank Card -->
    <div class="glass-panel" style="flex: 1; min-width: 280px; display: flex; align-items: center; justify-content: space-between; border-left: 6px solid var(--accent-color); padding: 1.5rem 2rem;">
        <div>
            <div style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Peringkat Anda</div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 1.6rem; font-weight: 800; color: var(--text-main);">
                    @php
                        $rank1 = $summaryGuru['p1']['rank'] ?? null;
                        $rank2 = $summaryGuru['p2']['rank'] ?? null;
                    @endphp
                    {{ $rank1 ? '#' . $rank1 : '-' }} 
                    <i class="fas fa-arrow-right mx-2 text-muted" style="font-size: 1.1rem; vertical-align: middle;"></i> 
                    {{ $rank2 ? '#' . $rank2 : '-' }}
                </span>
                @if($rank1 && $rank2)
                    @php
                        $diffRank = $rank1 - $rank2;
                    @endphp
                    @if($diffRank > 0)
                        <span class="guru-badge guru-badge-benefit" style="padding: 4px 10px; font-size: 0.8rem; margin: 0;"><i class="fas fa-caret-up"></i> Naik {{ $diffRank }}</span>
                    @elseif($diffRank < 0)
                        <span class="guru-badge guru-badge-cost" style="padding: 4px 10px; font-size: 0.8rem; margin: 0;"><i class="fas fa-caret-down"></i> Turun {{ abs($diffRank) }}</span>
                    @else
                        <span class="guru-badge" style="padding: 4px 10px; font-size: 0.8rem; background: #e5e7eb; color: #6b7280; border: 1px solid #d1d5db; margin: 0;">Tetap</span>
                    @endif
                @endif
            </div>
        </div>
        <i class="fas fa-trophy text-gray-300" style="color: #cbd5e1; font-size: 2.2rem;"></i>
    </div>

    <!-- Yi Score Card -->
    <div class="glass-panel" style="flex: 1; min-width: 280px; display: flex; align-items: center; justify-content: space-between; border-left: 6px solid var(--secondary-color); padding: 1.5rem 2rem;">
        <div>
            <div style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Skor Akhir Kinerja (Yi)</div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 1.6rem; font-weight: 800; color: var(--text-main);">
                    @php
                        $yi1 = $summaryGuru['p1']['nilai_yi'] ?? null;
                        $yi2 = $summaryGuru['p2']['nilai_yi'] ?? null;
                    @endphp
                    {{ $yi1 !== null ? number_format($yi1, 4) : '-' }} 
                    <i class="fas fa-arrow-right mx-2 text-muted" style="font-size: 1.1rem; vertical-align: middle;"></i> 
                    {{ $yi2 !== null ? number_format($yi2, 4) : '-' }}
                </span>
                @if($yi1 !== null && $yi2 !== null)
                    @php $diffYi = $yi2 - $yi1; @endphp
                    @if($diffYi > 0)
                        <span style="color: #2d6a4f; font-weight: 800; font-size: 0.95rem;">(+{{ number_format($diffYi, 4) }})</span>
                    @elseif($diffYi < 0)
                        <span style="color: var(--secondary-color); font-weight: 800; font-size: 0.95rem;">({{ number_format($diffYi, 4) }})</span>
                    @endif
                @endif
            </div>
        </div>
        <i class="fas fa-chart-line text-gray-300" style="color: #cbd5e1; font-size: 2.2rem;"></i>
    </div>
</div>

<!-- Perbandingan Per Kriteria -->
<div class="glass-panel" style="padding: 2.5rem;">
    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 4px; color: var(--primary-color);">Rincian Evaluasi Kompetensi Per Kriteria</h3>
    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Menganalisis performa Anda kriteria demi kriteria antara kedua semester.</p>

    <div style="background: #ffffff; border-radius: 1.5rem; overflow-x: auto; border: 2px dashed #e5e7eb; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <table class="guru-table">
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">Kode</th>
                    <th>Kriteria Penilaian</th>
                    <th style="width: 12%; text-align: center;">Jenis</th>
                    <th style="width: 10%; text-align: center;">Bobot</th>
                    <th style="width: 18%; text-align: center;">{{ $p1 }}</th>
                    <th style="width: 18%; text-align: center;">{{ $p2 }}</th>
                    <th style="width: 18%; text-align: center;">Perkembangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteriaComparison as $row)
                <tr>
                    <td style="font-weight: 700; color: var(--primary-color); text-align: center;">{{ $row['kode'] }}</td>
                    <td>
                        <div style="font-weight: 600; font-size: 1.05rem;">{{ $row['nama'] }}</div>
                    </td>
                    <td style="text-align: center;">
                        @if($row['jenis'] == 'Benefit')
                            <span class="guru-badge guru-badge-benefit">Benefit</span>
                        @else
                            <span class="guru-badge guru-badge-cost">Cost</span>
                        @endif
                    </td>
                    <td style="text-align: center; font-weight: 600; color: var(--text-muted);">{{ $row['bobot'] }}%</td>
                    
                    <!-- Nilai Periode 1 -->
                    <td style="text-align: center; font-size: 1.15rem; font-weight: 700; color: var(--text-muted);">
                        {{ $row['score1'] !== null ? number_format($row['score1'], 1) : '-' }}
                    </td>

                    <!-- Nilai Periode 2 -->
                    <td style="text-align: center; font-size: 1.15rem; font-weight: 800; color: var(--text-main);">
                        {{ $row['score2'] !== null ? number_format($row['score2'], 1) : '-' }}
                    </td>

                    <!-- Perubahan Nilai -->
                    <td style="text-align: center; font-weight: 800;">
                        @if($row['diff'] !== null)
                            @if($row['diff'] > 0)
                                <span style="color: #2d6a4f;"><i class="fas fa-arrow-up"></i> +{{ number_format($row['diff'], 1) }}</span>
                            @elseif($row['diff'] < 0)
                                <span style="color: var(--secondary-color);"><i class="fas fa-arrow-down"></i> {{ number_format($row['diff'], 1) }}</span>
                            @else
                                <span style="color: var(--text-muted); font-weight: 600;">-</span>
                            @endif
                        @else
                            <span style="color: var(--text-muted); font-weight: 600;">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
