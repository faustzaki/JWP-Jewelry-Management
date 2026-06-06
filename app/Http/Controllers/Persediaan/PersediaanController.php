<?php

namespace App\Http\Controllers\Persediaan;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class PersediaanController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategoriBarang')->get()->map(function ($barang) {
            // Bandingkan timestamp transaksi masuk dan keluar untuk menyajikan mutasi terbaru
            $lastMasuk = BarangMasuk::where('barang_id', $barang->id)->latest()->first();
            $lastKeluar = BarangKeluar::where('barang_id', $barang->id)->latest()->first();
            
            $mutasi = null;
            if ($lastMasuk && $lastKeluar) {
                if ($lastMasuk->created_at > $lastKeluar->created_at) {
                    $mutasi = [
                        'tipe' => 'masuk',
                        'qty' => $lastMasuk->jumlah_masuk,
                        'tanggal' => $lastMasuk->tanggal_masuk->format('d M Y')
                    ];
                } else {
                    $mutasi = [
                        'tipe' => 'keluar',
                        'qty' => $lastKeluar->jumlah_keluar,
                        'tanggal' => $lastKeluar->tanggal_keluar->format('d M Y')
                    ];
                }
            } elseif ($lastMasuk) {
                $mutasi = [
                    'tipe' => 'masuk',
                    'qty' => $lastMasuk->jumlah_masuk,
                    'tanggal' => $lastMasuk->tanggal_masuk->format('d M Y')
                ];
            } elseif ($lastKeluar) {
                $mutasi = [
                    'tipe' => 'keluar',
                    'qty' => $lastKeluar->jumlah_keluar,
                    'tanggal' => $lastKeluar->tanggal_keluar->format('d M Y')
                ];
            }

            return [
                'id' => $barang->id,
                'kode' => $barang->kode_barang,
                'nama' => $barang->nama_barang,
                'kategori' => $barang->kategoriBarang->nama_kategori ?? 'Tidak Ada',
                'stok' => $barang->stok_sekarang,
                'satuan' => $barang->satuan,
                'mutasi' => $mutasi
            ];
        });

        $kategoris = \App\Models\KategoriBarang::all();
        return view('persediaan.persediaan', compact('barangs', 'kategoris'));
    }
}
