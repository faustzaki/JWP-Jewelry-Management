@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-2xl">
    {{-- Indikator kinerja utama (KPI) untuk pemantauan cepat volume sirkulasi barang --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
        <div class="bg-neutral-surface rounded-xl border border-neutral-border shadow-lvl1 p-lg">
            <div class="flex items-center gap-md">
                <div class="p-3 bg-neutral-bg rounded-md">
                    <x-heroicon-o-sparkles class="w-6 h-6 text-neutral-text" />
                </div>
                <div>
                    <p class="text-sm text-neutral-text-muted">Jenis Keperluan Barang Perusahaan Steel</p>
                    <p class="text-2xl font-heading">{{ number_format($jenisPerhiasan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-neutral-surface rounded-xl border border-neutral-border shadow-lvl1 p-lg">
            <div class="flex items-center gap-md">
                <div class="p-3 bg-neutral-bg rounded-md">
                    <x-heroicon-o-arrow-down class="w-6 h-6 text-success" />
                </div>
                <div>
                    <p class="text-sm text-neutral-text-muted">Total Masuk (Bulan Ini)</p>
                    <p class="text-2xl font-heading">{{ number_format($totalMasukBulanIni, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-neutral-surface rounded-xl border border-neutral-border shadow-lvl1 p-lg">
            <div class="flex items-center gap-md">
                <div class="p-3 bg-neutral-bg rounded-md">
                    <x-heroicon-o-arrow-up class="w-6 h-6 text-error" />
                </div>
                <div>
                    <p class="text-sm text-neutral-text-muted">Total Keluar (Bulan Ini)</p>
                    <p class="text-2xl font-heading">{{ number_format($totalKeluarBulanIni, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-neutral-surface rounded-xl border border-neutral-border shadow-lvl1 p-lg">
            <div class="flex items-center gap-md">
                <div class="p-3 bg-neutral-bg rounded-md">
                    <x-heroicon-o-cube class="w-6 h-6 text-neutral-text" />
                </div>
                <div>
                    <p class="text-sm text-neutral-text-muted">Total Persediaan</p>
                    <p class="text-2xl font-heading">{{ number_format($totalStok, 0, ',', '.') }} Pcs</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Blok keputusan taktis: penanganan stok kritis vs pengelolaan produk dengan stok berlebih --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-lg">
        <!-- Widget Alert Visual untuk Stok Kritis -->
        <div>
            <h3 class="text-lg font-heading mb-md text-neutral-text">Peringatan Stok Kritis</h3>
            <div class="rounded-xl shadow-lvl1 border border-error/30 bg-error/5">
                <div class="p-md flex items-start gap-md">
                    <div class="p-2 bg-error/10 rounded-full shrink-0">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-error" />
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-error">Ada {{ $itemMenipis + $itemHabis }} barang dengan stok <= 10</h4>
                        <ul class="mt-2 space-y-2 text-sm text-neutral-text">
                            @forelse($peringatanStoks as $stokItem)
                                <li class="flex justify-between items-center py-1 border-b border-neutral-border last:border-0">
                                    <div class="flex flex-col">
                                        <span>{{ $stokItem->nama_barang }}</span>
                                        <span class="text-xs text-neutral-text-muted">Kategori: {{ $stokItem->kategoriBarang->nama_kategori ?? '-' }}</span>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-error border border-error/30 rounded-full bg-error/5">Sisa {{ $stokItem->stok_sekarang }} unit</span>
                                </li>
                            @empty
                                <li class="py-1 text-neutral-text-muted">Tidak ada stok kritis.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('persediaan.index') }}?filter=menipis" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium border border-neutral-border rounded-md hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Visual untuk Stok Tertinggi -->
        <div>
            <h3 class="text-lg font-heading mb-md text-neutral-text">Barang Stok Terbanyak</h3>
            <div class="rounded-xl shadow-lvl1 border border-success/30 bg-success/5">
                <div class="p-md flex items-start gap-md">
                    <div class="p-2 bg-success/10 rounded-full shrink-0">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-success" />
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-success">Ada {{ count($stokTerbanyaks) }} Barang dengan stok terbanyak</h4>
                        <ul class="mt-2 space-y-2 text-sm text-neutral-text">
                            @forelse($stokTerbanyaks as $stok)
                                <li class="flex justify-between items-center py-1 border-b border-neutral-border last:border-0">
                                    <div class="flex flex-col">
                                        <span>{{ $stok->nama_barang }}</span>
                                        <span class="text-xs text-neutral-text-muted">Kategori: {{ $stok->kategoriBarang->nama_kategori ?? '-' }}</span>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-success border border-success/30 rounded-full bg-success/5">{{ $stok->stok_sekarang }} unit</span>
                                </li>
                            @empty
                                <li class="py-1 text-neutral-text-muted">Belum ada barang.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('persediaan.index') }}?filter=terbanyak" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium border border-neutral-border rounded-md hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik sirkulasi harian barang masuk vs keluar untuk analisis tren rotasi stok --}}
    <div class="bg-neutral-surface rounded-xl border border-neutral-border shadow-lvl1 p-lg">
        <div class="flex justify-between items-center mb-lg">
            <h3 class="text-lg font-heading text-neutral-text">{{ $chartTitle }}</h3>
            <select 
                onchange="window.location.href = '?chart_range=' + this.value"
                class="border border-neutral-border rounded-md px-3 py-1.5 text-sm bg-neutral-surface text-neutral-text focus:outline-none focus:ring-2 focus:ring-neutral-border cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23111111%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_0.75rem_center] bg-[size:0.65em_auto] pr-8">
                <option value="7" @selected($chartRange == '7') class="bg-white text-black dark:bg-neutral-surface dark:text-white">7 Hari Terakhir</option>
                <option value="30" @selected($chartRange == '30') class="bg-white text-black dark:bg-neutral-surface dark:text-white">30 Hari Terakhir</option>
                <option value="bulan_ini" @selected($chartRange == 'bulan_ini') class="bg-white text-black dark:bg-neutral-surface dark:text-white">Bulan Ini</option>
            </select>
        </div>
        
        <!-- Mockup Chart Bar (menggunakan Tailwind) -->
        <div class="h-64 flex items-end gap-2 sm:gap-4 lg:gap-8 pt-4 border-b border-l border-neutral-border px-4 relative">
            <!-- Grid Lines -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none -z-10">
                <div class="w-full border-t border-dashed border-neutral-border/50"></div>
                <div class="w-full border-t border-dashed border-neutral-border/50"></div>
                <div class="w-full border-t border-dashed border-neutral-border/50"></div>
                <div class="w-full border-t border-dashed border-neutral-border/50"></div>
                <div class="w-full border-t border-dashed border-neutral-border/50"></div>
            </div>

            <!-- Bars -->
            @foreach($chartData as $data)
                <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                    <div class="w-full h-full flex items-end justify-center gap-1">
                        <!-- Masuk -->
                        <div class="w-full max-w-[20px] bg-neutral-text-muted rounded-t-sm transition-all hover:opacity-80" style="height: {{ ($data['in'] / $maxChartValue) * 100 }}%;"></div>
                        <!-- Keluar -->
                        <div class="w-full max-w-[20px] bg-neutral-text rounded-t-sm transition-all hover:opacity-80" style="height: {{ ($data['out'] / $maxChartValue) * 100 }}%;"></div>
                    </div>
                    <span class="absolute -bottom-6 text-xs text-neutral-text-muted">{{ $data['day'] }}</span>
                </div>
            @endforeach
        </div>
        
        <!-- Legend -->
        <div class="mt-10 flex justify-center items-center gap-6 text-sm">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-neutral-text-muted rounded-sm"></div>
                <span class="text-neutral-text-muted">Masuk</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-neutral-text rounded-sm"></div>
                <span class="text-neutral-text-muted">Keluar</span>
            </div>
        </div>
    </div>
</div>
@endsection


