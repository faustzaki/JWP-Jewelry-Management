<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = ['barang_id', 'jumlah_keluar', 'tanggal_keluar', 'keterangan'];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];

    // Relasi balik untuk menghitung mutasi pengurangan stok keperluan barang perusahaan steel
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

