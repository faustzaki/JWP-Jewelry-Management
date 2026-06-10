<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = ['barang_id', 'jumlah_masuk', 'tanggal_masuk', 'keterangan'];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    // Relasi balik untuk menghitung mutasi penambahan stok keperluan barang perusahaan steel
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

