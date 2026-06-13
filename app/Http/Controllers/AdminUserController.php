<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        // Only fetch users with role 'admin'
        $admins = User::where('role', 'admin')->get();
        return view('admin.admin-user.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admin-user.index')->with('success', 'Akun Admin baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.admin-user.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admin-user.index')->with('success', 'Akun Admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // Prevent self-deletion
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admin-user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
        }

        $admin->delete();

        return redirect()->route('admin.admin-user.index')->with('success', 'Akun Admin berhasil dihapus!');
    }
}
