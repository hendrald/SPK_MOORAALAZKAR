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
        // Load with guru relation
        $evaluasis = Evaluasi::with('guru')->orderBy('periode', 'desc')->get();
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
            'periode' => 'required',
            'nilai'   => 'required|array', // Associative array: ['kriteria_id' => 'nilai', ...]
        ]);

        // Cek apakah guru di periode ini sudah dievaluasi
        $isExist = Evaluasi::where('guru_id', $request->guru_id)
                           ->where('periode', $request->periode)
                           ->first();
                           
        if ($isExist) {
            return back()->with('error', 'Guru ini sudah memiliki nilai evaluasi pada periode tersebut! Silakan edit data yang sudah ada.')->withInput();
        }

        DB::transaction(function () use ($request) {
            $evaluasi = Evaluasi::create([
                'guru_id' => $request->guru_id,
                'periode' => $request->periode
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
            'periode' => 'required',
            'nilai'   => 'required|array',
        ]);

        // Cek duplicate selain current ID
        $isExist = Evaluasi::where('guru_id', $request->guru_id)
                           ->where('periode', $request->periode)
                           ->where('id', '!=', $id)
                           ->first();
        if ($isExist) {
            return back()->with('error', 'Guru pada periode ini sudah terdaftar! Gunakan periode berbeda.');
        }

        DB::transaction(function () use ($request, $evaluasi) {
            $evaluasi->update([
                'guru_id' => $request->guru_id,
                'periode' => $request->periode
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
