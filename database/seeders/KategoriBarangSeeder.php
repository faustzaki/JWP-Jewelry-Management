<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriBarang;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Cincin', 'prefix' => 'JW-CIN'],
            ['nama_kategori' => 'Gelang', 'prefix' => 'JW-GEL'],
            ['nama_kategori' => 'Kalung', 'prefix' => 'JW-KAL'],
            ['nama_kategori' => 'Anting', 'prefix' => 'JW-ANT'],
        ];

        foreach ($kategoris as $kategori) {
            KategoriBarang::create($kategori);
        }
    }
}
