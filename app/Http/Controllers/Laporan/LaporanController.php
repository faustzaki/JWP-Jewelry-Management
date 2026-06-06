<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $filterDate = $request->input('date', Carbon::today()->format('Y-m-d'));

        // Siapkan opsi kategori dinamis untuk dropdown filter di sisi frontend
        $kategoris = KategoriBarang::pluck('nama_kategori')->prepend('Semua');
        
        $barangs = Barang::with(['kategoriBarang', 'barangMasuks', 'barangKeluars'])->get()->map(function ($barang) use ($filterDate) {
            
            $totalMasukAll = $barang->barangMasuks->sum('jumlah_masuk');
            $totalKeluarAll = $barang->barangKeluars->sum('jumlah_keluar');
            // Mundur ke stok awal mutlak sebelum seluruh riwayat transaksi dimasukkan
            $baseStok = $barang->stok_sekarang - $totalMasukAll + $totalKeluarAll;

            $totalMasukSebelum = $barang->barangMasuks->filter(function($m) use ($filterDate) {
                return $m->tanggal_masuk->format('Y-m-d') < $filterDate;
            })->sum('jumlah_masuk');

            $totalKeluarSebelum = $barang->barangKeluars->filter(function($k) use ($filterDate) {
                return $k->tanggal_keluar->format('Y-m-d') < $filterDate;
            })->sum('jumlah_keluar');

            $masukHariIni = $barang->barangMasuks->filter(function($m) use ($filterDate) {
                return $m->tanggal_masuk->format('Y-m-d') === $filterDate;
            })->sum('jumlah_masuk');

            $keluarHariIni = $barang->barangKeluars->filter(function($k) use ($filterDate) {
                return $k->tanggal_keluar->format('Y-m-d') === $filterDate;
            })->sum('jumlah_keluar');
            
            // Hitung akumulasi untuk mendapatkan potret saldo stok awal dan akhir pada tanggal filter
            $stokAwalHariIni = $baseStok + $totalMasukSebelum - $totalKeluarSebelum;
            $stokAkhirHariIni = $stokAwalHariIni + $masukHariIni - $keluarHariIni;

            // Klasifikasikan status ketersediaan agar admin langsung tahu prioritas pemesanan barang
            $status = 'Aman';
            if ($stokAkhirHariIni == 0) {
                $status = 'Habis';
            } elseif ($stokAkhirHariIni < 10) {
                $status = 'Stok Menipis';
            }

            return [
                'id' => $barang->id,
                'kode' => $barang->kode_barang,
                'nama' => $barang->nama_barang,
                'kategori' => $barang->kategoriBarang->nama_kategori ?? 'Tidak Ada',
                'stok_awal' => $stokAwalHariIni,
                'masuk' => $masukHariIni,
                'keluar' => $keluarHariIni,
                'stok_akhir' => $stokAkhirHariIni,
                'status' => $status,
                'updated_at' => $filterDate
            ];
        });

        return view('laporan.laporan', compact('barangs', 'kategoris', 'filterDate'));
    }
}
