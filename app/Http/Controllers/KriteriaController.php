<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|min:1|max:100'
        ]);

        $sumBobot = Kriteria::sum('bobot');
        if ($sumBobot + $request->bobot > 100) {
            $sisa = 100 - $sumBobot;
            return back()->withInput()->withErrors(['bobot' => 'Total seluruh bobot melebihi 100. Sisa kuota bobot saat ini hanya: ' . $sisa]);
        }

        Kriteria::create($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria,' . $kriteria->id,
            'nama_kriteria' => 'required',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|min:1|max:100'
        ]);

        $sumBobot = Kriteria::where('id', '!=', $id)->sum('bobot');
        if ($sumBobot + $request->bobot > 100) {
            $sisa = 100 - $sumBobot;
            return back()->withInput()->withErrors(['bobot' => 'Total seluruh bobot melebihi 100. Sisa kuota bobot saat ini hanya: ' . $sisa]);
        }

        $kriteria->update($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kriteria::findOrFail($id)->delete();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
