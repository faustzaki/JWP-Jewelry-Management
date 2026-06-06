<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DaftarPerhiasanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'kode_barang' => 'required|string|max:50|unique:barangs',
            'nama_barang' => 'required|string|max:150',
            'satuan' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string'
        ]);

        // Normalisasi kode SKU ke huruf kapital agar penamaan seragam di database
        Barang::create([
            'kategori_barang_id' => $request->kategori_barang_id,
            'kode_barang' => strtoupper($request->kode_barang),
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan ?? 'Pcs',
            'deskripsi' => $request->deskripsi,
            'stok_sekarang' => 0,
            'status' => 'Tidak Tersedia'
        ]);

        // Kirim state tab aktif kembali agar UI tidak kembali ke tab awal
        return back()->with('tab', request('tab', 'barang'))->with('success', 'Produk barang baru berhasil didaftarkan!');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'kode_barang' => ['required', 'string', 'max:50', Rule::unique('barangs')->ignore($barang->id)],
            'nama_barang' => 'required|string|max:150',
            'satuan' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string'
        ]);

        $barang->update([
            'kategori_barang_id' => $request->kategori_barang_id,
            'kode_barang' => strtoupper($request->kode_barang),
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan ?? 'Pcs',
            'deskripsi' => $request->deskripsi
        ]);

        return back()->with('tab', request('tab', 'barang'))->with('success', 'Data produk barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        
        return back()->with('tab', request('tab', 'barang'))->with('success', 'Barang berhasil dihapus!');
    }
}
