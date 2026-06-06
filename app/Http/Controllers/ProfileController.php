<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        return view('profil');
    }

    /**
     * Proses update data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'password_lama' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Validasi password lama terlebih dahulu sebagai lapisan verifikasi identitas tambahan
        if ($request->filled('password')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->withErrors(['password_lama' => 'Kata sandi lama tidak cocok.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus file avatar lama dari disk storage agar tidak menyisakan sampah berkas
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru ke public disk agar dapat diakses secara dinamis lewat URL
            $path = $request->file('foto_profil')->store('avatars', 'public');
            $user->foto_profil = $path;
        }

        // Update data lainnya
        $user->username = $request->username;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil dan pengaturan akun berhasil diperbarui!');
    }
}
