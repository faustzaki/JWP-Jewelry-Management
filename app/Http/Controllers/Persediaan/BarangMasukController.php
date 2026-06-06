<?php

namespace App\Http\Controllers\Persediaan;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        // Fetch all items for the dropdown
        $barangs = Barang::all();
        // Fetch history of incoming items
        $riwayats = BarangMasuk::with('barang')->orderBy('tanggal_masuk', 'desc')->orderBy('created_at', 'desc')->get();

        return view('persediaan.masuk', compact('barangs', 'riwayats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_masuk' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        try {
            // Gunakan database transaction untuk menjamin konsistensi data stok jika terjadi kegagalan sistem
            DB::transaction(function () use ($request) {
                BarangMasuk::create([
                    'barang_id' => $request->barang_id,
                    'jumlah_masuk' => $request->jumlah_masuk,
                    'tanggal_masuk' => $request->tanggal_masuk,
                    'keterangan' => $request->keterangan
                ]);

                $barang = Barang::findOrFail($request->barang_id);
                $barang->increment('stok_sekarang', $request->jumlah_masuk);
                
                // Ubah status ketersediaan secara otomatis ketika stok bertambah dari 0 agar langsung aktif di katalog
                if ($barang->stok_sekarang > 0 && $barang->status == 'Tidak Tersedia') {
                    $barang->update(['status' => 'Tersedia']);
                }
            });

            return back()->with('success', 'Transaksi barang masuk berhasil dicatat dan stok telah diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }
}
