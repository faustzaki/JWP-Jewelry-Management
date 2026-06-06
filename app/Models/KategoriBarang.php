<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $fillable = ['nama_kategori', 'prefix'];

    // Relasi untuk melacak semua produk perhiasan di bawah kategori ini
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
