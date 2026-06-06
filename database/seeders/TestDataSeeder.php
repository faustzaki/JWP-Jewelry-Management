<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to truncate tables safely
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
            BarangKeluar::truncate();
            BarangMasuk::truncate();
            Barang::truncate();
            KategoriBarang::truncate();
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            BarangKeluar::truncate();
            BarangMasuk::truncate();
            Barang::truncate();
            KategoriBarang::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $categories = [
            'Chains' => 'CHN',
            'Pendants' => 'PND',
            'Rings' => 'RNG',
            'Bracelets' => 'BRC',
            'Earrings' => 'ERG',
            'Watches' => 'WTC',
            'Grillz' => 'GRL',
            'Custom Jewelry' => 'CUS',
            'Accessories' => 'ACC',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $prefix) {
            $categoryModels[$name] = KategoriBarang::create([
                'nama_kategori' => $name,
                'prefix' => $prefix,
            ]);
        }

        $products = [
            ['kode_barang' => 'CHN-0001', 'nama_barang' => '14K Gold Cuban Link Chain 8mm', 'category' => 'Chains'],
            ['kode_barang' => 'CHN-0002', 'nama_barang' => 'Diamond Cuban Link Chain 12mm', 'category' => 'Chains'],
            ['kode_barang' => 'CHN-0003', 'nama_barang' => 'White Gold Rope Chain', 'category' => 'Chains'],
            ['kode_barang' => 'CHN-0004', 'nama_barang' => 'Tennis Chain VVS Moissanite', 'category' => 'Chains'],
            ['kode_barang' => 'CHN-0005', 'nama_barang' => 'Miami Cuban Chain Rose Gold', 'category' => 'Chains'],
            ['kode_barang' => 'PND-0001', 'nama_barang' => 'Diamond Cross Pendant', 'category' => 'Pendants'],
            ['kode_barang' => 'PND-0002', 'nama_barang' => 'Angel Wing Pendant', 'category' => 'Pendants'],
            ['kode_barang' => 'PND-0003', 'nama_barang' => 'Custom Letter Pendant "J"', 'category' => 'Pendants'],
            ['kode_barang' => 'PND-0004', 'nama_barang' => 'Crown Pendant Gold', 'category' => 'Pendants'],
            ['kode_barang' => 'PND-0005', 'nama_barang' => 'Money Bag Pendant Diamond', 'category' => 'Pendants'],
            ['kode_barang' => 'RNG-0001', 'nama_barang' => 'Diamond Pinky Ring', 'category' => 'Rings'],
            ['kode_barang' => 'RNG-0002', 'nama_barang' => 'Gold Signet Ring', 'category' => 'Rings'],
            ['kode_barang' => 'RNG-0003', 'nama_barang' => 'Iced Out Cluster Ring', 'category' => 'Rings'],
            ['kode_barang' => 'RNG-0004', 'nama_barang' => 'VVS Moissanite Ring', 'category' => 'Rings'],
            ['kode_barang' => 'RNG-0005', 'nama_barang' => 'Luxury Wedding Band', 'category' => 'Rings'],
            ['kode_barang' => 'BRC-0001', 'nama_barang' => 'Tennis Bracelet Diamond', 'category' => 'Bracelets'],
            ['kode_barang' => 'BRC-0002', 'nama_barang' => 'Cuban Bracelet Gold', 'category' => 'Bracelets'],
            ['kode_barang' => 'BRC-0003', 'nama_barang' => 'White Gold Bracelet', 'category' => 'Bracelets'],
            ['kode_barang' => 'ERG-0001', 'nama_barang' => 'Round Diamond Stud Earrings', 'category' => 'Earrings'],
            ['kode_barang' => 'ERG-0002', 'nama_barang' => 'Princess Cut Earrings', 'category' => 'Earrings'],
            ['kode_barang' => 'ERG-0003', 'nama_barang' => 'Hoop Earrings Gold', 'category' => 'Earrings'],
            ['kode_barang' => 'WTC-0001', 'nama_barang' => 'Bust Down Watch Silver', 'category' => 'Watches'],
            ['kode_barang' => 'WTC-0002', 'nama_barang' => 'Diamond Luxury Watch Gold', 'category' => 'Watches'],
            ['kode_barang' => 'WTC-0003', 'nama_barang' => 'Skeleton Watch Rose Gold', 'category' => 'Watches'],
            ['kode_barang' => 'GRL-0001', 'nama_barang' => '6 Teeth Gold Grillz', 'category' => 'Grillz'],
            ['kode_barang' => 'GRL-0002', 'nama_barang' => '8 Teeth Diamond Grillz', 'category' => 'Grillz'],
            ['kode_barang' => 'GRL-0003', 'nama_barang' => 'Custom Bottom Grillz', 'category' => 'Grillz'],
            ['kode_barang' => 'CUS-0001', 'nama_barang' => 'Custom Name Pendant', 'category' => 'Custom Jewelry'],
            ['kode_barang' => 'CUS-0002', 'nama_barang' => 'Custom Logo Chain', 'category' => 'Custom Jewelry'],
            ['kode_barang' => 'ACC-0001', 'nama_barang' => 'Premium Jewelry Box', 'category' => 'Accessories'],
        ];

        $suppliers = [
            'Dubai Luxury Jewelry',
            'Miami Diamond Supply',
            'GoldCraft Indonesia',
            'Elite Gems Singapore',
            'VVS Jewelry Factory',
        ];

        $customers = [
            'John Doe (Invoice #1001)',
            'Jane Smith (Invoice #1002)',
            'Budi Santoso (Invoice #1003)',
            'Siti Aminah (Invoice #1004)',
            'Michael Johnson (Invoice #1005)',
        ];

        foreach ($products as $index => $p) {
            $dateMasuk = now()->subDays(rand(10, 30))->format('Y-m-d');
            $dateKeluar = now()->subDays(rand(1, 9))->format('Y-m-d');

            if ($index % 6 === 0) {
                // Scenario A: 0 stock (no transaction history)
                $qtyMasuk = 0;
                $qtyKeluar = 0;
            } elseif ($index % 6 === 1) {
                // Scenario B: 0 stock (sold out, has history of both incoming and outgoing)
                $qtyMasuk = rand(10, 30);
                $qtyKeluar = $qtyMasuk;
            } elseif ($index % 6 === 2) {
                // Scenario C: Critical stock (< 10) from low initial entry
                $qtyMasuk = rand(1, 9);
                $qtyKeluar = 0;
            } elseif ($index % 6 === 3) {
                // Scenario D: Critical stock (< 10) from high entry minus sales
                $qtyMasuk = rand(20, 30);
                $qtyKeluar = $qtyMasuk - rand(1, 9);
            } else {
                // Scenario E: Normal healthy stock level
                $qtyMasuk = rand(30, 100);
                $qtyKeluar = rand(5, 20);
            }

            $stokSekarang = $qtyMasuk - $qtyKeluar;
            $status = $stokSekarang > 0 ? 'Tersedia' : 'Tidak Tersedia';

            $barang = Barang::create([
                'kategori_barang_id' => $categoryModels[$p['category']]->id,
                'kode_barang' => $p['kode_barang'],
                'nama_barang' => $p['nama_barang'],
                'satuan' => 'Pcs',
                'deskripsi' => 'Data test untuk produk ' . $p['nama_barang'],
                'stok_sekarang' => $stokSekarang,
                'status' => $status,
            ]);

            if ($qtyMasuk > 0) {
                BarangMasuk::create([
                    'barang_id' => $barang->id,
                    'jumlah_masuk' => $qtyMasuk,
                    'tanggal_masuk' => $dateMasuk,
                    'keterangan' => 'Supplier: ' . $suppliers[array_rand($suppliers)],
                ]);
            }

            if ($qtyKeluar > 0) {
                BarangKeluar::create([
                    'barang_id' => $barang->id,
                    'jumlah_keluar' => $qtyKeluar,
                    'tanggal_keluar' => $dateKeluar,
                    'keterangan' => 'Penjualan: ' . $customers[array_rand($customers)],
                ]);
            }
        }
    }
}
