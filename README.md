# 📋 Aplikasi Manajemen Persediaan Barang — Toko JeWePe

Aplikasi berbasis web (*back-office system*) yang dirancang khusus untuk mengelola, mencatat, dan memantau persediaan (stok) barang di **Toko JeWePe**. Mengingat komoditas perhiasan mewah memiliki valuasi yang tinggi, sistem ini menjamin akurasi sirkulasi barang secara *real-time* untuk menggantikan pencatatan manual guna meminimalkan risiko kehilangan aset dan kesalahan perhitungan stok.

---

## 🚀 Fitur Utama

- **📊 Dashboard Ringkasan Real-Time**: 
  - Monitoring metrik penting: *Total Jenis Perhiasan*, *Total Stok Masuk*, dan *Total Stok Keluar*.
  - Menampilkan informasi *Stok Tertinggi*.
  - Notifikasi visual/peringatan dini untuk perhiasan dengan *Stok Kritis (< 10 unit)*.
- **📦 Manajemen Master Data (CRUD)**:
  - **Kategori Perhiasan**: Pengelompokan barang disertai prefix kode (SKU) otomatis (contoh: `RNG` untuk Rings, `CHN` untuk Chains).
  - **Daftar Perhiasan**: Pencatatan detail perhiasan termasuk nama, satuan, deskripsi, stok saat ini, dan status ketersediaan.
  - **Manajemen Pengguna**: Pengelolaan kredensial admin sistem.
- **💸 Transaksi Persediaan**:
  - Perekaman kuantitas masuk (stok masuk dari supplier/pengrajin).
  - Perekaman kuantitas keluar (stok keluar untuk penjualan/pelanggan).
  - **Validasi Ketat**: Sistem secara otomatis menolak transaksi keluar jika kuantitas melebihi sisa stok saat ini.
- **🔄 Otomatisasi Status**:
  - Mengubah status ketersediaan barang secara otomatis menjadi **"Tidak Tersedia"** saat stok menyentuh angka 0.
- **📈 Laporan Sirkulasi**:
  - Penyajian laporan transaksi barang masuk dan keluar dengan filter berdasarkan rentang periode tertentu.
- **🔒 Keamanan Akses**:
  - Sistem login terproteksi menggunakan *Stateful Session Authentication* bawaan Laravel dan enkripsi kata sandi via Bcrypt.

---

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan arsitektur monolitik **MVC (Model-View-Controller)** yang efisien:

- **Backend**: PHP >= 8.2 & Laravel 12
- **Frontend**: Livewire v4 (Interaktivitas dinamis tanpa API decoupling), Tailwind CSS v4 (Styling modern & responsif), Blade Template, & Heroicons
- **Database**: SQLite (Default) / MySQL
- **Build Tooling**: Vite & Composer Scripts (Concurrently)

---

## ⚙️ Panduan Instalasi & Konfigurasi

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di lingkungan lokal:

### 1. Prasyarat
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM

### 2. Kloning & Persiapan Repositori
```bash
# Salin konfigurasi environment (.env)
copy .env.example .env
```

### 3. Instal Dependensi
```bash
# Instal dependensi backend PHP
composer install

# Instal dependensi frontend JS/CSS
npm install
```

### 4. Konfigurasi Aplikasi & Database
Secara default, Laravel 12 akan otomatis membuat file database SQLite (`database/database.sqlite`) jika tidak ada.
```bash
# Generate application key
php artisan key:generate

# Jalankan migrasi database dan buat user admin default
php artisan migrate --seed
```

### 5. Akun Akses Default
Setelah proses *seeding* selesai, gunakan akun berikut untuk masuk ke dashboard:
- **Username**: `jwpadmin`
- **Password**: `jwpadmin`

*(Opsional) Jika ingin menambahkan data contoh/simulasi transaksi (stok kritis, barang masuk/keluar, produk)*:
```bash
php artisan db:seed --class=TestDataSeeder
```

### 6. Menjalankan Server Pengembangan
Aplikasi ini dilengkapi konfigurasi *concurrent server*. Cukup jalankan perintah berikut untuk menjalankan server PHP, Vite, Queue, dan Logger sekaligus dalam satu terminal:
```bash
composer dev
```
Buka browser Anda dan akses di: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📂 Struktur File Utama

- `app/Models/` — Entity data (`Barang.php`, `KategoriBarang.php`, `BarangMasuk.php`, `BarangKeluar.php`, `User.php`).
- `app/Http/Controllers/` — Logika pengendali halaman dan proses persediaan.
- `routes/web.php` — Definisi seluruh route sistem.
- `database/migrations/` — Definisi skema tabel basis data.
- `database/seeders/` — Pengisi data awal & data uji coba (seeders).
- `resources/views/` — Tampilan berbasis Blade & Tailwind CSS.

