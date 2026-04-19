<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Evaluasi;
use Illuminate\Http\Request;

class MooraController extends Controller
{
    /**
     * Menjalankan algoritma MOORA berdasarkan periode tertentu.
     */
    public function index()
    {
        $periodes = Evaluasi::select('periode')->distinct()->orderBy('periode', 'desc')->get();
        return view('admin.moora.index', compact('periodes'));
    }

    public function hitungMoora(Request $request)
    {
        $periode = $request->periode;
        if (!$periode) {
            return back()->with('error', 'Silakan pilih periode terlebih dahulu.');
        }

        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();
        if ($kriterias->isEmpty()) {
            return back()->with('error', 'Perhitungan tidak dapat dilakukan karena data Kriteria masih kosong.');
        }

        $totalBobot = $kriterias->sum('bobot');
        if (round($totalBobot, 2) != 1) {
            return back()->with('error', "Perhitungan dibatalkan! Total bobot Kriteria saat ini adalah $totalBobot. Total wajib 1 (100%) agar MOORA valid. Silakan sesuaikan.");
        }

        // Ambil evaluasi berdasarkan periode
        $evaluasis = Evaluasi::with(['guru', 'details'])->where('periode', $periode)->get();

        if ($evaluasis->isEmpty()) {
            return back()->with('error', 'Data evaluasi untuk periode ini belum tersedia.');
        }

        // 1. Matriks Keputusan (X)
        $matriksX = [];
        foreach ($evaluasis as $evaluasi) {
            foreach ($kriterias as $kriteria) {
                // Cari nilai detail per kriteria
                $detail = $evaluasi->details->firstWhere('kriteria_id', $kriteria->id);
                $matriksX[$evaluasi->id][$kriteria->id] = $detail ? $detail->nilai : 0;
            }
        }

        // 2. Normalisasi Matriks (X*)
        // Cari pembagi (akar dari sum(nilai^2)) per kriteria
        $pembagi_kriteria = [];
        foreach ($kriterias as $kriteria) {
            $sum_kuadrat = 0;
            foreach ($evaluasis as $evaluasi) {
                $nilai_x = $matriksX[$evaluasi->id][$kriteria->id];
                $sum_kuadrat += pow($nilai_x, 2);
            }
            $pembagi_kriteria[$kriteria->id] = sqrt($sum_kuadrat);
        }

        $matriksNormalisasi = [];
        foreach ($evaluasis as $evaluasi) {
            foreach ($kriterias as $kriteria) {
                $nilai_x = $matriksX[$evaluasi->id][$kriteria->id];
                $pembagi = $pembagi_kriteria[$kriteria->id] == 0 ? 1 : $pembagi_kriteria[$kriteria->id];
                $matriksNormalisasi[$evaluasi->id][$kriteria->id] = $nilai_x / $pembagi;
            }
        }

        // 3. Optimasi (Pembobotan) & 4. Perankingan (Yi)
        $hasilAkhir = [];
        foreach ($evaluasis as $evaluasi) {
            $sumBenefit = 0;
            $sumCost = 0;

            foreach ($kriterias as $kriteria) {
                // Kalikan nilai normalisasi dengan bobot kriteria
                $nilaiBobot = $matriksNormalisasi[$evaluasi->id][$kriteria->id] * $kriteria->bobot;

                // Pisahkan Cost dan Benefit
                if ($kriteria->jenis === 'Benefit') {
                    $sumBenefit += $nilaiBobot;
                } else {
                    $sumCost += $nilaiBobot;
                }
            }

            // Hitung Nilai Akhir (Yi) = Sum Benefit - Sum Cost
            $nilai_yi = $sumBenefit - $sumCost;

            $hasilAkhir[] = [
                'guru'     => $evaluasi->guru->nama_lengkap,
                'nip'      => $evaluasi->guru->nip,
                'foto'     => $evaluasi->guru->foto,
                'nilai_yi' => $nilai_yi
            ];
        }

        // Sorting dari Yi terbesar ke terkecil (Descending)
        usort($hasilAkhir, function ($a, $b) {
            return $b['nilai_yi'] <=> $a['nilai_yi'];
        });

        // Jika Request membedakan untuk cetak PDF
        if ($request->action === 'cetak') {
            return view('admin.moora.cetak', compact('periode', 'hasilAkhir'));
        }

        // Jika Request membedakan untuk Export Excel (CSV Format for Native Compatibility)
        if ($request->action === 'excel') {
            $fileName = "Hasil_MOORA_{$periode}.csv";
            
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            
            $columns = array('Peringkat', 'NIP', 'Nama Lengkap Guru', 'Nilai Akhir (Yi)');

            $callback = function() use($hasilAkhir, $columns) {
                $file = fopen('php://output', 'w');
                // Output Excel BOM for UTF-8 visibility in MS Excel
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, $columns, ';'); // Gunakan separator ; agar langsung jadi kolom di Excel versi Indonesia/Eropa

                foreach ($hasilAkhir as $index => $row) {
                    fputcsv($file, array(
                        $index + 1,
                        $row['nip'] ? $row['nip'] : '-',
                        $row['guru'],
                        number_format($row['nilai_yi'], 4, ',', '.') // Format angka excel
                    ), ';');
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Hasil passing ke view Admin
        return view('admin.moora.hasil', compact('periode', 'hasilAkhir', 'kriterias', 'matriksX', 'matriksNormalisasi', 'evaluasis'));
    }
}
