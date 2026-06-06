<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_barang_id')->constrained('kategori_barangs')->onDelete('restrict');
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 150);
            $table->integer('stok_sekarang')->default(0);
            $table->string('satuan', 20)->default('Pcs');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
