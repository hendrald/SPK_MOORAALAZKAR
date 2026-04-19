<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nip' => 'nullable',
            'no_telp' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru_fotos', 'public');
        }

        DB::transaction(function () use ($request, $fotoPath) {
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru'
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'foto' => $fotoPath
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'nip' => 'nullable',
            'no_telp' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $fotoPath = $guru->foto;
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $fotoPath = $request->file('foto')->store('guru_fotos', 'public');
        }

        DB::transaction(function () use ($request, $guru, $fotoPath) {
            $user = $guru->user;
            $user->name = $request->nama_lengkap;
            $user->email = $request->email;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $guru->update([
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'foto' => $fotoPath
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        DB::transaction(function () use ($guru) {
            $user = $guru->user;
            // Evaluasi and EvaluasiDetail will be cascade deleted based on migration
            $guru->delete();
            $user->delete(); // Delete user will cascade to guru based on DB schema if setup properly, but manual is safer
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil dihapus!');
    }
}
