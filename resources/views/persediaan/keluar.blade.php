@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="space-y-6">
 <!-- Header Page -->
 <div class="flex items-center justify-between">
 <h1 class="text-2xl font-heading">Transaksi Barang Keluar</h1>
 </div>

 <!-- Flash Messages -->
 @if(session('success'))
     <div class="bg-success/10 text-success border border-success/20 p-4 rounded-xl text-sm font-medium">
         {{ session('success') }}
     </div>
 @endif
 @if(session('error'))
     <div class="bg-error/10 text-error border border-error/20 p-4 rounded-xl text-sm font-medium">
         {{ session('error') }}
     </div>
 @endif
 @if($errors->any())
     <div class="bg-error/10 text-error border border-error/20 p-4 rounded-xl text-sm font-medium">
         <ul class="list-disc pl-5">
             @foreach($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif

 <!-- Layout Grid -->
 <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
 
 <!-- Form Section -->
 <div class="xl:col-span-1 border border-neutral-border bg-neutral-surface rounded-xl p-6 shadow-sm h-fit">
 <h3 class="text-lg font-heading mb-4">Input Barang Keluar</h3>
 <form action="{{ route('persediaan.keluar.store') }}" method="POST" class="space-y-4">
 @csrf
 <!-- Form Group: Tanggal -->
 <div class="space-y-1.5">
 <label class="text-sm font-medium text-neutral-text-muted">Tanggal Keluar</label>
 <input type="date" name="tanggal_keluar" required class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow dark:[color-scheme:dark]" value="{{ date('Y-m-d') }}" />
 </div>
 
 <!-- Form Group: Barang -->
 <div class="space-y-1.5">
 <label class="text-sm font-medium text-neutral-text-muted">Pilih Keperluan Barang Perusahaan Steel (Stok > 0)</label>
 <div class="relative">
  <select name="barang_id" required class="w-full border border-neutral-border bg-transparent rounded-lg pl-3 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow appearance-none">
  <option value="" class="bg-white text-black dark:bg-neutral-surface dark:text-white">-- Pilih Keperluan Barang Perusahaan Steel --</option>
  @foreach($barangs as $barang)
    <option value="{{ $barang->id }}" class="bg-white text-black dark:bg-neutral-surface dark:text-white" {{ request('barang_id') == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }} (Sisa: {{ $barang->stok_sekarang }})</option>
  @endforeach
  </select>
  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-text-muted">
  <x-heroicon-o-chevron-down class="h-4 w-4" stroke-width="2" />
  </div>
 </div>
 </div>

 <!-- Form Group: Jumlah -->
 <div class="space-y-1.5">
 <label class="text-sm font-medium text-neutral-text-muted">Jumlah Keluar</label>
 <input type="number" name="jumlah_keluar" required min="1" class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" placeholder="0" />
 </div>

 <!-- Form Group: Tujuan -->
 <div class="space-y-1.5">
 <label class="text-sm font-medium text-neutral-text-muted">Tujuan / Pembeli</label>
 <input type="text" name="keterangan" class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" placeholder="Nama Pelanggan / Toko Cabang" />
 </div>

 <div class="pt-2">
 <button type="submit" class="w-full bg-black text-white dark:bg-white dark:text-black font-medium text-sm px-4 py-2 rounded-lg hover:opacity-90 transition-opacity cursor-pointer">
 Simpan Transaksi
 </button>
 </div>
 </form>
 </div>

 <!-- Table Section -->
 <div class="xl:col-span-2 border border-neutral-border bg-neutral-surface rounded-xl shadow-sm overflow-hidden flex flex-col">
 <div class="p-6 border-b border-neutral-border flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-neutral-bg/50 dark:bg-neutral-bg/50">
 <h3 class="text-lg font-heading">Riwayat Barang Keluar</h3>
 
 </div>
 
 <div class="overflow-x-auto flex-1">
 <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
 <thead>
 <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
 <th class="py-3 px-6 text-neutral-text-muted font-heading">Tanggal</th>
 <th class="py-3 px-6 text-neutral-text-muted font-heading">Nama Keperluan Barang Perusahaan Steel</th>
 <th class="py-3 px-6 text-neutral-text-muted font-heading text-right">Jumlah</th>
 <th class="py-3 px-6 text-neutral-text-muted font-heading">Tujuan / Ket.</th>
 </tr>
 </thead>
 <tbody>
 @forelse($riwayats as $item)
 <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors">
 <td class="py-3 px-6 text-neutral-text-muted">
      {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }} <span class="text-xs text-neutral-text-muted/80 font-mono">{{ $item->created_at->format('H:i:s') }}</span>
 </td>
 <td class="py-3 px-6">{{ $item->barang->nama_barang }}</td>
 <td class="py-3 px-6 text-red-600 dark:text-red-400 text-right">-{{ $item->jumlah_keluar }}</td>
 <td class="py-3 px-6 text-neutral-text-muted">{{ $item->keterangan ?? '-' }}</td>
 </tr>
 @empty
 <tr>
    <td colspan="4" class="text-center py-12 text-neutral-text-muted">Belum ada data transaksi barang keluar.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 </div>
 </div>
</div>
@endsection


