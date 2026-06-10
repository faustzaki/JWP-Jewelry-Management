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
            'Pipes' => 'PIP',
            'Plates' => 'PLT',
            'Rebars' => 'RBR',
            'Beams' => 'BEM',
            'Coils' => 'COL',
            'Wire Rods' => 'WRD',
            'Angles' => 'ANG',
            'Custom Steel' => 'CUS',
            'Fasteners' => 'FAS',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $prefix) {
            $categoryModels[$name] = KategoriBarang::create([
                'nama_kategori' => $name,
                'prefix' => $prefix,
            ]);
        }

        $products = [
            ['kode_barang' => 'PIP-0001', 'nama_barang' => 'Seamless Carbon Steel Pipe 8in', 'category' => 'Pipes', 'satuan' => 'Batang'],
            ['kode_barang' => 'PIP-0002', 'nama_barang' => 'Galvanized Steel Pipe 4in', 'category' => 'Pipes', 'satuan' => 'Batang'],
            ['kode_barang' => 'PIP-0003', 'nama_barang' => 'Stainless Steel Pipe 304 2in', 'category' => 'Pipes', 'satuan' => 'Batang'],
            ['kode_barang' => 'PIP-0004', 'nama_barang' => 'ERW Steel Pipe 12in', 'category' => 'Pipes', 'satuan' => 'Batang'],
            ['kode_barang' => 'PIP-0005', 'nama_barang' => 'Ductile Iron Pipe 6in', 'category' => 'Pipes', 'satuan' => 'Batang'],
            ['kode_barang' => 'PLT-0001', 'nama_barang' => 'Carbon Steel Plate 10mm', 'category' => 'Plates', 'satuan' => 'Lembar'],
            ['kode_barang' => 'PLT-0002', 'nama_barang' => 'Shipbuilding Steel Plate Grade A', 'category' => 'Plates', 'satuan' => 'Lembar'],
            ['kode_barang' => 'PLT-0003', 'nama_barang' => 'Stainless Steel Plate 316L', 'category' => 'Plates', 'satuan' => 'Lembar'],
            ['kode_barang' => 'PLT-0004', 'nama_barang' => 'Checkered Steel Plate 4.5mm', 'category' => 'Plates', 'satuan' => 'Lembar'],
            ['kode_barang' => 'PLT-0005', 'nama_barang' => 'Boiler Steel Plate 16mm', 'category' => 'Plates', 'satuan' => 'Lembar'],
            ['kode_barang' => 'RBR-0001', 'nama_barang' => 'Deformed Steel Rebar 10mm', 'category' => 'Rebars', 'satuan' => 'Batang'],
            ['kode_barang' => 'RBR-0002', 'nama_barang' => 'Deformed Steel Rebar 16mm', 'category' => 'Rebars', 'satuan' => 'Batang'],
            ['kode_barang' => 'RBR-0003', 'nama_barang' => 'Plain Steel Rebar 8mm', 'category' => 'Rebars', 'satuan' => 'Batang'],
            ['kode_barang' => 'RBR-0004', 'nama_barang' => 'High Tensile Rebar 25mm', 'category' => 'Rebars', 'satuan' => 'Batang'],
            ['kode_barang' => 'RBR-0005', 'nama_barang' => 'Epoxy Coated Rebar 12mm', 'category' => 'Rebars', 'satuan' => 'Batang'],
            ['kode_barang' => 'BEM-0001', 'nama_barang' => 'H-Beam 200x200x8x12', 'category' => 'Beams', 'satuan' => 'Batang'],
            ['kode_barang' => 'BEM-0002', 'nama_barang' => 'I-Beam 150x75x5x7', 'category' => 'Beams', 'satuan' => 'Batang'],
            ['kode_barang' => 'BEM-0003', 'nama_barang' => 'Wide Flange Beam 300x150', 'category' => 'Beams', 'satuan' => 'Batang'],
            ['kode_barang' => 'COL-0001', 'nama_barang' => 'Hot Rolled Steel Coil', 'category' => 'Coils', 'satuan' => 'Ton'],
            ['kode_barang' => 'COL-0002', 'nama_barang' => 'Cold Rolled Steel Coil', 'category' => 'Coils', 'satuan' => 'Ton'],
            ['kode_barang' => 'COL-0003', 'nama_barang' => 'Galvanized Steel Coil', 'category' => 'Coils', 'satuan' => 'Ton'],
            ['kode_barang' => 'WRD-0001', 'nama_barang' => 'High Carbon Wire Rod 5.5mm', 'category' => 'Wire Rods', 'satuan' => 'Ton'],
            ['kode_barang' => 'WRD-0002', 'nama_barang' => 'Low Carbon Wire Rod 8mm', 'category' => 'Wire Rods', 'satuan' => 'Ton'],
            ['kode_barang' => 'WRD-0003', 'nama_barang' => 'Stainless Steel Wire Rod', 'category' => 'Wire Rods', 'satuan' => 'Ton'],
            ['kode_barang' => 'ANG-0001', 'nama_barang' => 'Equal Angle Steel 50x50x5', 'category' => 'Angles', 'satuan' => 'Batang'],
            ['kode_barang' => 'ANG-0002', 'nama_barang' => 'Unequal Angle Steel 100x75x7', 'category' => 'Angles', 'satuan' => 'Batang'],
            ['kode_barang' => 'ANG-0003', 'nama_barang' => 'Galvanized Angle Steel 40x40x4', 'category' => 'Angles', 'satuan' => 'Batang'],
            ['kode_barang' => 'CUS-0001', 'nama_barang' => 'Custom Fabricated Steel Column', 'category' => 'Custom Steel', 'satuan' => 'Unit'],
            ['kode_barang' => 'CUS-0002', 'nama_barang' => 'Laser Cut Steel Bracket', 'category' => 'Custom Steel', 'satuan' => 'Unit'],
            ['kode_barang' => 'FAS-0001', 'nama_barang' => 'Heavy Duty Hex Bolt M16', 'category' => 'Fasteners', 'satuan' => 'Box'],
        ];

        $suppliers = [
            'PT Krakatau Steel Tbk',
            'PT Gunung Raja Paksi',
            'Hanil Jaya Steel',
            'Baosteel Group Indonesia',
            'Jindal Steel & Power',
        ];

        $customers = [
            'PT Waskita Karya (Invoice #1001)',
            'PT Wijaya Karya (Invoice #1002)',
            'CV Konstruksi Mandiri (Invoice #1003)',
            'PT Adhi Karya (Invoice #1004)',
            'CV Baja Ringan Sentosa (Invoice #1005)',
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
                'satuan' => $p['satuan'],
                'deskripsi' => 'Data test untuk material ' . $p['nama_barang'],
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
