<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\EvaluasiDetail;
use App\Models\Guru;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluasiController extends Controller
{
    public function index()
    {
        // Load with guru and penilai relation
        $evaluasis = Evaluasi::with(['guru', 'penilai'])->orderBy('periode', 'desc')->get();
        return view('admin.evaluasi.index', compact('evaluasis'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        
        if($gurus->isEmpty() || $kriterias->isEmpty()) {
            return redirect()->route('admin.evaluasi.index')
                ->with('error', 'Pastikan data Guru dan Minimal 1 Kriteria sudah terisi sebelum membuat Evaluasi!');
        }

        return view('admin.evaluasi.create', compact('gurus', 'kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
            'nilai'   => 'required|array', // Associative array: ['kriteria_id' => 'nilai', ...]
            'catatan' => 'nullable|string',
        ]);

        $periode = $request->tahun_ajaran . ' - ' . $request->semester;

        // Cek apakah guru di periode ini sudah dievaluasi oleh penilai ini
        $isExist = Evaluasi::where('guru_id', $request->guru_id)
                           ->where('periode', $periode)
                           ->where('penilai_id', auth()->id())
                           ->first();
                           
        if ($isExist) {
            return back()->with('error', 'Guru ini sudah memiliki nilai evaluasi dari Anda pada periode tersebut! Silakan edit data yang sudah ada.')->withInput();
        }

        DB::transaction(function () use ($request, $periode) {
            $evaluasi = Evaluasi::create([
                'guru_id' => $request->guru_id,
                'penilai_id' => auth()->id(),
                'periode' => $periode,
                'catatan' => $request->catatan,
            ]);

            foreach ($request->nilai as $kriteria_id => $nilai) {
                EvaluasiDetail::create([
                    'evaluasi_id' => $evaluasi->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai'       => $nilai
                ]);
            }
        });

        return redirect()->route('admin.evaluasi.index')->with('success', 'Nilai Penilaian Guru berhasil disimpan!');
    }

    public function edit($id)
    {
        $evaluasi = Evaluasi::with('details')->findOrFail($id);
        $gurus = Guru::all();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.evaluasi.edit', compact('evaluasi', 'gurus', 'kriterias'));
    }

    public function update(Request $request, $id)
    {
        $evaluasi = Evaluasi::findOrFail($id);

        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
            'nilai'   => 'required|array',
            'catatan' => 'nullable|string',
        ]);

        $periode = $request->tahun_ajaran . ' - ' . $request->semester;

        // Cek duplicate selain current ID
        $isExist = Evaluasi::where('guru_id', $request->guru_id)
                           ->where('periode', $periode)
                           ->where('penilai_id', auth()->id())
                           ->where('id', '!=', $id)
                           ->first();
        if ($isExist) {
            return back()->with('error', 'Guru pada periode ini sudah terdaftar oleh Anda! Gunakan periode berbeda.')->withInput();
        }

        DB::transaction(function () use ($request, $evaluasi, $periode) {
            $evaluasi->update([
                'guru_id' => $request->guru_id,
                'penilai_id' => auth()->id(),
                'periode' => $periode,
                'catatan' => $request->catatan,
            ]);

            // Sync details
            foreach ($request->nilai as $kriteria_id => $nilai) {
                // Update or Create
                EvaluasiDetail::updateOrCreate(
                    ['evaluasi_id' => $evaluasi->id, 'kriteria_id' => $kriteria_id],
                    ['nilai' => $nilai]
                );
            }
            // Cleanup any deleted kriteria details
            $evaluasi->details()->whereNotIn('kriteria_id', array_keys($request->nilai))->delete();
        });

        return redirect()->route('admin.evaluasi.index')->with('success', 'Data Evaluasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Evaluasi::findOrFail($id)->delete(); // Akan ter-cascade sesuai migration
        return redirect()->route('admin.evaluasi.index')->with('success', 'Data Evaluasi berhasil dihapus!');
    }
}
