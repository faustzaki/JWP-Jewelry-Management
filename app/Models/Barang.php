<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kategori_barang_id', 'kode_barang', 'nama_barang', 
        'stok_sekarang', 'satuan', 'deskripsi', 'status'
    ];

    // Digunakan untuk penentuan otomatisasi prefix kode barang (SKU)
    public function kategoriBarang()
    {
        return $this->belongsTo(KategoriBarang::class);
    }

    // Rekapitulasi jumlah stok masuk dari supplier
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    // Rekapitulasi jumlah penjualan/pengeluaran barang
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
