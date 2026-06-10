# Panduan Pembaruan Sistem (Dari Perhiasan ke Steel Company)

Dokumen ini berisi langkah-langkah untuk mengambil (pull) pembaruan terbaru yang mengubah tema dan data aplikasi dari Manajemen Perhiasan menjadi Manajemen Keperluan Barang Perusahaan Baja (*Steel Company*).

## Langkah 1: Tarik Pembaruan Terbaru (Git Pull)
Pastikan Anda berada di *branch* `main` dan tarik kode terbaru dari *repository*:

```bash
git pull origin main
```

## Langkah 2: Refresh Database dan Terapkan Data Baru (Seeder)
Karena pembaruan ini membawa data *dummy* baru yang berisikan kategori, produk, satuan (ton, batang, lembar), serta mutasi stok khusus perusahaan baja, Anda perlu menjalankan *seeder* ulang. 

Anda bisa memilih salah satu dari dua cara berikut:

**Cara A (Hanya Update Data Dummy, tabel lama dikosongkan):**
```bash
php artisan db:seed --class=TestDataSeeder
```

**Cara B (Reset Seluruh Database dari Awal + Seed Ulang):**
```bash
php artisan migrate:fresh --seed
```
*(Gunakan Cara B jika Anda ingin benar-benar mereset aplikasi ke kondisi bersih seperti bawaan awal).*

## Langkah 3: Jalankan Ulang Aplikasi
Setelah data *dummy* disesuaikan, jalankan *development server* Laravel:

```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui `http://localhost:8000` (atau *port* sesuai konfigurasi Anda). Saat Anda masuk (*login*), Anda akan melihat bahwa seluruh judul, daftar barang, status stok, kategori, pemasok, dan tabel telah berubah menjadi ekosistem material *steel* (Pipes, Plates, Beams, Coils, dll.).

---
*Catatan: Pastikan dependensi (Composer/NPM) sudah yang paling mutakhir, namun pada update khusus ini tidak ada perubahan struktur package.*
