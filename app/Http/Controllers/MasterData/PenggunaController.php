<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users'
        ]);

        // Terapkan password default 'jwpadmin' untuk mempermudah inisialisasi akun admin baru
        User::create([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make('jwpadmin'),
            'role' => 'Admin'
        ]);

        return back()->with('tab', request('tab', 'pengguna'))->with('success', 'Pengguna admin baru berhasil ditambahkan dengan password default \'jwpadmin\'!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'nama_lengkap' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)]
        ]);

        $user->update([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email
        ]);

        return back()->with('tab', request('tab', 'pengguna'))->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah lockout sistem dengan melarang penghapusan jika hanya ada satu akun tersisa
        if (User::count() <= 1) {
            return back()->with('tab', request('tab', 'pengguna'))->with('error', 'Tidak dapat menghapus semua admin! Harus tersisa minimal 1 admin.');
        }

        $user->delete();
        return back()->with('tab', request('tab', 'pengguna'))->with('success', 'Pengguna berhasil dihapus!');
    }
}
