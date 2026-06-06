<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Persediaan\PersediaanController;
use App\Http\Controllers\Persediaan\BarangMasukController;
use App\Http\Controllers\Persediaan\BarangKeluarController;
use App\Http\Controllers\MasterData\MasterDataController;
use App\Http\Controllers\MasterData\KategoriBarangController;
use App\Http\Controllers\MasterData\DaftarPerhiasanController;
use App\Http\Controllers\MasterData\PenggunaController;
use App\Http\Controllers\Laporan\LaporanController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/persediaan', [PersediaanController::class, 'index'])->name('persediaan.index');

    Route::get('/persediaan/masuk', [BarangMasukController::class, 'index'])->name('persediaan.masuk.index');
    Route::post('/persediaan/masuk', [BarangMasukController::class, 'store'])->name('persediaan.masuk.store');

    Route::get('/persediaan/keluar', [BarangKeluarController::class, 'index'])->name('persediaan.keluar.index');
    Route::post('/persediaan/keluar', [BarangKeluarController::class, 'store'])->name('persediaan.keluar.store');

    Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');

    // Kategori Routes
    Route::post('/master-data/kategori', [KategoriBarangController::class, 'store'])->name('kategori.store');
    Route::put('/master-data/kategori/{id}', [KategoriBarangController::class, 'update'])->name('kategori.update');
    Route::delete('/master-data/kategori/{id}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy');

    // Barang Routes
    Route::post('/master-data/barang', [DaftarPerhiasanController::class, 'store'])->name('barang.store');
    Route::put('/master-data/barang/{id}', [DaftarPerhiasanController::class, 'update'])->name('barang.update');
    Route::delete('/master-data/barang/{id}', [DaftarPerhiasanController::class, 'destroy'])->name('barang.destroy');

    // Pengguna Routes
    Route::post('/master-data/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/master-data/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/master-data/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profil');
    Route::post('/profil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profil.update');
});
