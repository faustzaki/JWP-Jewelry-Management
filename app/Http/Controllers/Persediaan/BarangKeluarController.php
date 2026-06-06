<?php

namespace App\Http\Controllers\Persediaan;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        // Hanya tampilkan barang yang stoknya tersedia agar tidak terjadi transaksi keluar minus
        $barangs = Barang::where('stok_sekarang', '>', 0)->get();
        $riwayats = BarangKeluar::with('barang')->orderBy('tanggal_keluar', 'desc')->orderBy('created_at', 'desc')->get();

        return view('persediaan.keluar', compact('barangs', 'riwayats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        try {
            // Gunakan database transaction untuk menjamin konsistensi data stok jika terjadi kegagalan sistem
            DB::transaction(function () use ($request) {
                $barang = Barang::findOrFail($request->barang_id);

                // Proteksi agar stok barang mewah tidak bernilai negatif
                if ($barang->stok_sekarang < $request->jumlah_keluar) {
                    throw new \Exception("Stok tidak mencukupi! Stok saat ini: {$barang->stok_sekarang}");
                }

                BarangKeluar::create([
                    'barang_id' => $request->barang_id,
                    'jumlah_keluar' => $request->jumlah_keluar,
                    'tanggal_keluar' => $request->tanggal_keluar,
                    'keterangan' => $request->keterangan
                ]);

                $barang->decrement('stok_sekarang', $request->jumlah_keluar);
                
                // Perbarui status ketersediaan secara otomatis untuk menyinkronkan data katalog di UI
                if ($barang->stok_sekarang == 0) {
                    $barang->update(['status' => 'Tidak Tersedia']);
                }
            });

            return back()->with('success', 'Transaksi barang keluar berhasil dicatat dan stok telah dikurangi!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
