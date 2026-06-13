<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Evaluasi;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PerbandinganController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->user()->role;
        $periodes = Evaluasi::select('periode')->distinct()->orderBy('periode', 'desc')->pluck('periode');

        $p1 = $request->input('period1');
        $p2 = $request->input('period2');

        $comparisonData = [];
        $criteriaComparison = [];
        $summaryGuru = null;

        if ($p1 && $p2) {
            if ($p1 === $p2) {
                return back()->with('error', 'Silakan pilih dua periode yang berbeda untuk dibandingkan.');
            }

            // Calculate MOORA for both periods
            $results1 = $this->calculateMooraForPeriod($p1);
            $results2 = $this->calculateMooraForPeriod($p2);

            if ($role === 'admin') {
                $gurus = Guru::all();
                foreach ($gurus as $guru) {
                    $res1 = $results1[$guru->id] ?? null;
                    $res2 = $results2[$guru->id] ?? null;

                    if ($res1 || $res2) {
                        $comparisonData[] = [
                            'guru' => $guru->nama_lengkap,
                            'nip' => $guru->nip,
                            'p1' => $res1,
                            'p2' => $res2,
                            // Rank difference: positive means rank number got smaller (improved), e.g., Rank 5 -> Rank 2 = +3
                            'trend_rank' => ($res1 && $res2) ? ($res1['rank'] - $res2['rank']) : null,
                            'trend_yi' => ($res1 && $res2) ? ($res2['nilai_yi'] - $res1['nilai_yi']) : null,
                        ];
                    }
                }
                
                // Sort by Period 2 rank (if exists), otherwise Period 1, otherwise name
                usort($comparisonData, function($a, $b) {
                    $rankA = $a['p2']['rank'] ?? 999;
                    $rankB = $b['p2']['rank'] ?? 999;
                    return $rankA <=> $rankB;
                });

            } else {
                // Guru role
                $guru = Guru::where('user_id', auth()->id())->first();
                if ($guru) {
                    $summaryGuru = [
                        'guru' => $guru->nama_lengkap,
                        'nip' => $guru->nip,
                        'p1' => $results1[$guru->id] ?? null,
                        'p2' => $results2[$guru->id] ?? null,
                    ];

                    $kriterias = Kriteria::orderBy('kode_kriteria')->get();
                    
                    // Fetch all details for this teacher in Period 1 and Period 2
                    $details1 = \App\Models\EvaluasiDetail::whereIn('evaluasi_id', function($q) use ($guru, $p1) {
                        $q->select('id')->from('evaluasis')->where('guru_id', $guru->id)->where('periode', $p1);
                    })->get()->groupBy('kriteria_id');
                    
                    $details2 = \App\Models\EvaluasiDetail::whereIn('evaluasi_id', function($q) use ($guru, $p2) {
                        $q->select('id')->from('evaluasis')->where('guru_id', $guru->id)->where('periode', $p2);
                    })->get()->groupBy('kriteria_id');

                    foreach ($kriterias as $k) {
                        $score1 = isset($details1[$k->id]) ? $details1[$k->id]->avg('nilai') : null;
                        $score2 = isset($details2[$k->id]) ? $details2[$k->id]->avg('nilai') : null;
                        $criteriaComparison[] = [
                            'kode' => $k->kode_kriteria,
                            'nama' => $k->nama_kriteria,
                            'jenis' => $k->jenis,
                            'bobot' => $k->bobot,
                            'score1' => $score1,
                            'score2' => $score2,
                            'diff' => ($score1 !== null && $score2 !== null) ? ($score2 - $score1) : null
                        ];
                    }
                }
            }
        }

        $viewName = ($role === 'admin') ? 'admin.perbandingan.index' : 'guru.perbandingan';
        return view($viewName, compact('periodes', 'p1', 'p2', 'comparisonData', 'criteriaComparison', 'summaryGuru'));
    }

    private function calculateMooraForPeriod($periode)
    {
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();
        if ($kriterias->isEmpty()) return [];
        
        $evaluasis = Evaluasi::with(['guru', 'details'])->where('periode', $periode)->get();
        if ($evaluasis->isEmpty()) return [];

        $groupedEvaluasis = $evaluasis->groupBy('penilai_id');
        $scoresByGuru = [];

        foreach ($groupedEvaluasis as $penilaiId => $evalGroup) {
            $matriksX = [];
            foreach ($evalGroup as $ev) {
                foreach ($kriterias as $kriteria) {
                    $detail = $ev->details->firstWhere('kriteria_id', $kriteria->id);
                    $matriksX[$ev->id][$kriteria->id] = $detail ? $detail->nilai : 0;
                }
            }

            $pembagi_kriteria = [];
            foreach ($kriterias as $kriteria) {
                $sum_kuadrat = 0;
                foreach ($evalGroup as $ev) {
                    $sum_kuadrat += pow($matriksX[$ev->id][$kriteria->id], 2);
                }
                $pembagi_kriteria[$kriteria->id] = sqrt($sum_kuadrat) ?: 1;
            }

            foreach ($evalGroup as $ev) {
                $sumBenefit = 0; $sumCost = 0;
                foreach ($kriterias as $kriteria) {
                    $nilaiBobot = ($matriksX[$ev->id][$kriteria->id] / $pembagi_kriteria[$kriteria->id]) * ($kriteria->bobot / 100);
                    if ($kriteria->jenis === 'Benefit') $sumBenefit += $nilaiBobot;
                    else $sumCost += $nilaiBobot;
                }
                $scoresByGuru[$ev->guru_id][] = $sumBenefit - $sumCost;
            }
        }

        $results = [];
        $uniqueGuruIds = $evaluasis->pluck('guru_id')->unique();
        foreach ($uniqueGuruIds as $guruId) {
            $scores = $scoresByGuru[$guruId] ?? [];
            $averageYi = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
            $guruModel = $evaluasis->firstWhere('guru_id', $guruId)->guru;
            $results[] = [
                'guru_id' => $guruId,
                'guru' => $guruModel->nama_lengkap,
                'nip' => $guruModel->nip,
                'nilai_yi' => $averageYi
            ];
        }

        // Rank them
        usort($results, fn($a, $b) => $b['nilai_yi'] <=> $a['nilai_yi']);
        
        $keyedResults = [];
        foreach ($results as $index => $row) {
            $keyedResults[$row['guru_id']] = [
                'rank' => $index + 1,
                'nilai_yi' => $row['nilai_yi'],
                'guru' => $row['guru'],
                'nip' => $row['nip']
            ];
        }

        return $keyedResults;
    }
}
