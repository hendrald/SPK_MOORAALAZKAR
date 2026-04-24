<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Evaluasi;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', auth()->user()->id)->first();
        return view('guru.dashboard', compact('guru'));
    }

    public function riwayat(Request $request)
    {
        $guru = Guru::where('user_id', auth()->user()->id)->first();
        if (!$guru) {
            return view('guru.riwayat', ['guru' => null, 'periods' => [], 'selectedPeriod' => null, 'evaluasi' => null]);
        }

        // Get all periods for this teacher to populate dropdown
        $periods = Evaluasi::where('guru_id', $guru->id)->orderBy('periode', 'desc')->pluck('periode');

        $selectedPeriod = $request->input('periode');
        $evaluasi = null;

        if ($selectedPeriod) {
            $evaluasi = Evaluasi::where('guru_id', $guru->id)
                ->where('periode', $selectedPeriod)
                ->with('details.kriteria')
                ->first();
        }

        return view('guru.riwayat', compact('guru', 'periods', 'selectedPeriod', 'evaluasi'));
    }

    public function settings()
    {
        return view('guru.settings');
    }

    public function updateSettings(Request $request)
    {
        $updateType = $request->input('update_type');

        if ($updateType === 'photo') {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $guru = Guru::where('user_id', auth()->user()->id)->first();
            if (!$guru) {
                return back()->withErrors(['foto' => 'Data guru tidak ditemukan.']);
            }

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($guru->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($guru->foto)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($guru->foto);
                }
                
                $fotoPath = $request->file('foto')->store('guru_fotos', 'public');
                $guru->foto = $fotoPath;
                $guru->save();

                return back()->with('success_foto', 'Foto Profil berhasil diperbarui!');
            }
            return back()->withErrors(['foto' => 'Gagal mengunggah foto.']);
        }

        if ($updateType === 'password') {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error_password', 'Kombinasi password saat ini tidak sesuai!');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('success_password', 'Password berhasil diperbarui!');
        }

        return back();
    }

    public function cetakRapor($periode)
    {
        $guru = Guru::where('user_id', auth()->user()->id)->firstOrFail();
        $evaluasi = Evaluasi::where('guru_id', $guru->id)->where('periode', $periode)->with('details.kriteria')->firstOrFail();

        // Calculate MOORA score for this specific period just so the report has the final score
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();
        $semuaEvaluasi = Evaluasi::with('details')->where('periode', $periode)->get();

        $matriksX = [];
        foreach ($semuaEvaluasi as $ev) {
            foreach ($kriterias as $kriteria) {
                $detail = $ev->details->firstWhere('kriteria_id', $kriteria->id);
                $matriksX[$ev->id][$kriteria->id] = $detail ? $detail->nilai : 0;
            }
        }

        $pembagi_kriteria = [];
        foreach ($kriterias as $kriteria) {
            $sum_kuadrat = 0;
            foreach ($semuaEvaluasi as $ev) {
                $sum_kuadrat += pow($matriksX[$ev->id][$kriteria->id], 2);
            }
            $pembagi_kriteria[$kriteria->id] = sqrt($sum_kuadrat) ?: 1;
        }

        $sumBenefit = 0;
        $sumCost = 0;
        foreach ($kriterias as $kriteria) {
            $nilai_x = isset($matriksX[$evaluasi->id][$kriteria->id]) ? $matriksX[$evaluasi->id][$kriteria->id] : 0;
            $nilaiBobot = ($nilai_x / $pembagi_kriteria[$kriteria->id]) * $kriteria->bobot;
            if ($kriteria->jenis === 'Benefit') {
                $sumBenefit += $nilaiBobot;
            } else {
                $sumCost += $nilaiBobot;
            }
        }
        $nilai_yi = $sumBenefit - $sumCost;

        return view('guru.cetak_rapor', compact('guru', 'evaluasi', 'nilai_yi'));
    }
}
