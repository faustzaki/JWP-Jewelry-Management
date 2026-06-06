<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Agregasi metrik bulanan untuk memantau performa sirkulasi barang secara real-time
        $jenisPerhiasan = Barang::count();
        $totalMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', $currentMonth)
                                         ->whereYear('tanggal_masuk', $currentYear)
                                         ->sum('jumlah_masuk');
        $totalKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', $currentMonth)
                                           ->whereYear('tanggal_keluar', $currentYear)
                                           ->sum('jumlah_keluar');
        $totalStok = Barang::sum('stok_sekarang');
                          
        $itemMenipis = Barang::where('stok_sekarang', '<=', 10)
                             ->where('stok_sekarang', '>', 0)
                             ->count();
                             
        $itemHabis = Barang::where('stok_sekarang', 0)->count();

        // Batas stok kritis <= 10 unit untuk memicu notifikasi re-stocking segera
        $peringatanStoks = Barang::with('kategoriBarang')
                                 ->where('stok_sekarang', '<=', 10)
                                 ->orderBy('stok_sekarang', 'asc')
                                 ->take(5)
                                 ->get();

        // Menampilkan 5 item teratas dengan stok melimpah untuk strategi rotasi display produk
        $stokTerbanyaks = Barang::where('stok_sekarang', '>', 10)
                                ->orderBy('stok_sekarang', 'desc')
                                ->take(5)
                                ->get();
        // Rentang hari grafik disesuaikan dinamis berdasarkan pilihan filter pengguna
        $chartRange = request('chart_range', '7');
        $days = 7;
        $chartTitle = "Sirkulasi Barang 7 Hari Terakhir";
        
        if ($chartRange == '30') {
            $days = 30;
            $chartTitle = "Sirkulasi Barang 30 Hari Terakhir";
        } elseif ($chartRange == 'bulan_ini') {
            $days = Carbon::today()->day; // Batasi rentang hari dari tanggal 1 sampai hari ini
            $chartTitle = "Sirkulasi Barang Bulan Ini";
        }

        $chartData = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $masuk = BarangMasuk::whereDate('tanggal_masuk', $date)->sum('jumlah_masuk');
            $keluar = BarangKeluar::whereDate('tanggal_keluar', $date)->sum('jumlah_keluar');
            $chartData[] = [
                'day' => $days > 7 ? $date->format('d/m') : $date->translatedFormat('D'),
                'in' => $masuk,
                'out' => $keluar
            ];
        }

        $maxChartValue = max(1, collect($chartData)->max(function($item) {
            return max($item['in'], $item['out']);
        }));

        return view('dashboard', compact(
            'jenisPerhiasan', 
            'totalMasukBulanIni', 
            'totalKeluarBulanIni', 
            'totalStok', 
            'itemMenipis', 
            'itemHabis', 
            'peringatanStoks', 
            'stokTerbanyaks',
            'chartData',
            'maxChartValue',
            'chartTitle',
            'chartRange'
        ));
    }
}
