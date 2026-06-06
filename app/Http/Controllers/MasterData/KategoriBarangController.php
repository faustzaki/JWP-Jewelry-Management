<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriBarangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_barangs',
            'prefix' => 'required|string|max:10|unique:kategori_barangs'
        ]);

        // Normalisasi format prefix ke huruf kapital untuk standardisasi generator SKU
        KategoriBarang::create([
            'nama_kategori' => $request->nama_kategori,
            'prefix' => strtoupper($request->prefix)
        ]);

        return back()->with('tab', request('tab', 'kategori'))->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategori_barangs')->ignore($kategori->id)],
            'prefix' => ['required', 'string', 'max:10', Rule::unique('kategori_barangs')->ignore($kategori->id)]
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'prefix' => strtoupper($request->prefix)
        ]);

        return back()->with('tab', request('tab', 'kategori'))->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        // Proteksi integritas data referensial agar tidak terjadi error foreign key constraint
        if ($kategori->barangs()->count() > 0) {
            return back()->with('tab', request('tab', 'kategori'))->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk perhiasan!');
        }

        $kategori->delete();
        return back()->with('tab', request('tab', 'kategori'))->with('success', 'Kategori berhasil dihapus!');
    }
}
