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
        if (round($totalBobot, 2) != 100) {
            return back()->with('error', "Perhitungan dibatalkan! Total bobot Kriteria saat ini adalah $totalBobot. Total wajib 100 (100%) agar MOORA valid. Silakan sesuaikan.");
        }

        // Ambil evaluasi berdasarkan periode
        $evaluasis = Evaluasi::with(['guru', 'details', 'penilai'])->where('periode', $periode)->get();

        if ($evaluasis->isEmpty()) {
            return back()->with('error', 'Data evaluasi untuk periode ini belum tersedia.');
        }

        // Group by penilai (evaluator)
        $groupedEvaluasis = $evaluasis->groupBy('penilai_id');
        $scoresByGuru = [];
        $penilaiResults = [];

        foreach ($groupedEvaluasis as $penilaiId => $evalGroup) {
            $penilai = $evalGroup->first()->penilai ?? (object)['name' => 'System'];

            // 1. Matriks Keputusan (X) untuk penilai ini
            $matriksX = [];
            foreach ($evalGroup as $evaluasi) {
                foreach ($kriterias as $kriteria) {
                    $detail = $evaluasi->details->firstWhere('kriteria_id', $kriteria->id);
                    $matriksX[$evaluasi->id][$kriteria->id] = $detail ? $detail->nilai : 0;
                }
            }

            // 2. Normalisasi Matriks (X*) untuk penilai ini
            $pembagi_kriteria = [];
            foreach ($kriterias as $kriteria) {
                $sum_kuadrat = 0;
                foreach ($evalGroup as $evaluasi) {
                    $nilai_x = $matriksX[$evaluasi->id][$kriteria->id];
                    $sum_kuadrat += pow($nilai_x, 2);
                }
                $pembagi_kriteria[$kriteria->id] = sqrt($sum_kuadrat) ?: 1;
            }

            $matriksNormalisasi = [];
            foreach ($evalGroup as $evaluasi) {
                foreach ($kriterias as $kriteria) {
                    $nilai_x = $matriksX[$evaluasi->id][$kriteria->id];
                    $pembagi = $pembagi_kriteria[$kriteria->id] == 0 ? 1 : $pembagi_kriteria[$kriteria->id];
                    $matriksNormalisasi[$evaluasi->id][$kriteria->id] = $nilai_x / $pembagi;
                }
            }

            // 3. Optimasi (Pembobotan) & Yi untuk penilai ini
            $hasilPenilai = [];
            foreach ($evalGroup as $evaluasi) {
                $sumBenefit = 0;
                $sumCost = 0;

                foreach ($kriterias as $kriteria) {
                    // Bagi bobot dengan 100 karena bobot adalah persentase (1-100)
                    $nilaiBobot = $matriksNormalisasi[$evaluasi->id][$kriteria->id] * ($kriteria->bobot / 100);

                    if ($kriteria->jenis === 'Benefit') {
                        $sumBenefit += $nilaiBobot;
                    } else {
                        $sumCost += $nilaiBobot;
                    }
                }

                $nilai_yi = $sumBenefit - $sumCost;
                $hasilPenilai[$evaluasi->guru_id] = $nilai_yi;
                $scoresByGuru[$evaluasi->guru_id][$penilaiId] = $nilai_yi;
            }

            $penilaiResults[$penilaiId] = [
                'penilai' => $penilai,
                'evaluasis' => $evalGroup,
                'matriksX' => $matriksX,
                'matriksNormalisasi' => $matriksNormalisasi,
                'hasilPenilai' => $hasilPenilai,
            ];
        }

        // 4. Kalkulasi Rata-rata Yi dan Perankingan Akhir
        $hasilAkhir = [];
        $uniqueGuruIds = $evaluasis->pluck('guru_id')->unique();
        
        foreach ($uniqueGuruIds as $guruId) {
            $scores = $scoresByGuru[$guruId] ?? [];
            $averageYi = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
            
            $firstEval = $evaluasis->firstWhere('guru_id', $guruId);
            $guruModel = $firstEval->guru;

            $hasilAkhir[] = [
                'guru_id'  => $guruId,
                'guru'     => $guruModel->nama_lengkap,
                'nip'      => $guruModel->nip,
                'foto'     => $guruModel->foto,
                'nilai_yi' => $averageYi,
                'scores'   => $scores
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

        // Jika Request membedakan untuk Export Excel (CSV Format)
        if ($request->action === 'excel') {
            $fileName = "Hasil_MOORA_{$periode}.csv";
            
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            
            $columns = array('Peringkat', 'NIP', 'Nama Lengkap Guru', 'Nilai Akhir Rata-rata (Yi)');

            $callback = function() use($hasilAkhir, $columns) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, $columns, ';');

                foreach ($hasilAkhir as $index => $row) {
                    fputcsv($file, array(
                        $index + 1,
                        $row['nip'] ? $row['nip'] : '-',
                        $row['guru'],
                        number_format($row['nilai_yi'], 4, ',', '.')
                    ), ';');
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return view('admin.moora.hasil', compact('periode', 'hasilAkhir', 'kriterias', 'penilaiResults'));
    }
}
