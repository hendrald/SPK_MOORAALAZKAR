<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Hasil Keputusan MOORA - {{ $periode }}</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; color: #000; line-height: 1.5; padding: 20px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2 { margin: 0; font-size: 18pt; text-transform: uppercase; font-weight: bold; }
        .kop-surat h4 { margin: 5px 0 0; font-size: 14pt; }
        .kop-surat p { margin: 5px 0 0; font-size: 10pt; }
        
        .isi-surat { margin-bottom: 20px; }
        .isi-surat .judul-laporan { text-align: center; text-decoration: underline; font-weight: bold; margin-bottom: 20px; font-size: 14pt; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px 12px; text-align: center; }
        th { background-color: #f0f0f0; }

        .winner-row { background-color: #e0fge0; font-weight: bold; }
        
        .tanda-tangan { float: right; width: 250px; text-align: center; margin-top: 40px; }
        .tanda-tangan p.nama-kepsek { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">Pilih Opsi: [Save as PDF] atau [Cetak Printer]</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">Tutup</button>
    </div>

    <div class="kop-surat">
        <h2>TAMAN KANAK-KANAK (TK) AL AZKAR</h2>
        <h4>KECAMATAN SETU - KABUPATEN BEKASI</h4>
        <p>Alamat: Jl. Setu Indah No. 123, Kelurahan Setu, Bekasi, Jawa Barat. Kodepos: 17320</p>
    </div>

    <div class="isi-surat">
        <div class="judul-laporan">LAPORAN HASIL PENILAIAN KINERJA GURU</div>
        <p>Berdasarkan hasil analisis sistem pendukung keputusan menggunakan metode <i>Multi-Objective Optimization on the basis of Ratio Analysis</i> (MOORA) pada periode evaluasi <b>{{ date('F Y', strtotime($periode . '-01')) }}</b>, dengan ini diterbitkan daftar peringkat keseluruhan guru TK Al Azkar sebagai berikut:</p>
        
        <table>
            <thead>
                <tr>
                    <th width="10%">Peringkat</th>
                    <th width="20%">NIP</th>
                    <th width="45%">Profil & Nama Guru</th>
                    <th width="25%">Nilai Akhir (Yi)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilAkhir as $index => $row)
                <tr class="{{ $index == 0 ? 'winner-row' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row['nip'] ?? '-' }}</td>
                    <td style="text-align: left; vertical-align: middle;">
                        @if(!empty($row['foto']))
                            <img src="{{ asset('storage/' . $row['foto']) }}" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; vertical-align: middle; margin-right: 10px;">
                        @endif
                        {{ $row['guru'] }}
                    </td>
                    <td><b>{{ number_format($row['nilai_yi'], 4) }}</b></td>
                </tr>
                @endforeach
            </tbody>
        </table>

         <p>Rincian peringkat pertama (1) dinobatkan kepada Saudara/i <b>{{ $hasilAkhir[0]['guru'] }}</b>. Rekapitulasi nilai ini telah divalidasi dan ditandatangani serta dapat menjadi rujukan pengambilan keputusan yayasan.</p>
    </div>

    <div class="tanda-tangan">
        <p>Bekasi, {{ date('d F Y') }}<br>Kepala Sekolah TK Al Azkar</p>
        <p class="nama-kepsek">Hj. Maimunah, S.Pd., PAUD.</p>
        <p style="margin:0;">NIP. 19780512 200501 2 001</p>
    </div>

</body>
</html>
