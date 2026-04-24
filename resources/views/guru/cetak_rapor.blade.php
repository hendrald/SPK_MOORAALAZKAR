<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rapor Kinerja Guru - {{ date('F Y', strtotime($evaluasi->periode . '-01')) }}</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom HTML/CSS framework just for printing -->
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .info-table .label {
            font-weight: bold;
            width: 150px;
        }
        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .score-table th, .score-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        .score-table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-box .date {
            margin-bottom: 70px;
        }
        .signature-box .name {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
        .btn-print {
            padding: 10px 20px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .btn-print:hover {
            background-color: #2e59d9;
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Dokumen
    </button>

    <div class="header">
        <h1>TK AL AZKAR</h1>
        <p>Laporan Evaluasi dan Penilaian Kinerja Guru</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Guru</td>
            <td>: {{ $guru->nama_lengkap }}</td>
            <td class="label">Periode Evaluasi</td>
            <td>: {{ date('F Y', strtotime($evaluasi->periode . '-01')) }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td>: {{ $guru->nip ?? '-' }}</td>
            <td class="label">Nilai Akhir (MOORA)</td>
            <td>: <strong>{{ number_format($nilai_yi, 4) }}</strong></td>
        </tr>
    </table>

    <table class="score-table">
        <thead>
            <tr>
                <th width="10%" class="text-center">No</th>
                <th>Kriteria Penilaian</th>
                <th width="20%" class="text-center">Nilai Observasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluasi->details as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $detail->kriteria->nama_kriteria }}</td>
                <td class="text-center">{{ $detail->nilai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($evaluasi->catatan)
    <div style="margin-bottom: 40px; border: 1px solid #000; padding: 15px;">
        <h4 style="margin-top: 0; margin-bottom: 10px;">Catatan Penilaian:</h4>
        <p style="margin: 0; white-space: pre-line; line-height: 1.5;">{{ $evaluasi->catatan }}</p>
    </div>
    @endif

    <div class="footer">
        <div class="signature-box">
            <p class="date">Jakarta, {{ date('d F Y') }}<br>Kepala Sekolah TK Al Azkar</p>
            <p class="name">( ........................................ )</p>
        </div>
    </div>
</body>
</html>
