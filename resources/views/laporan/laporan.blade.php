@extends('layouts.app')

@section('title', 'Laporan Persediaan')

@section('content')
<div x-data="{
    search: '',
    selectedCategory: 'Semua',
    filterDate: '',
    
    daftarKategori: {{ Illuminate\Support\Js::from($kategoris) }},
    
    daftarBarang: {{ Illuminate\Support\Js::from($barangs) }},

    get filteredBarang() {
        return this.daftarBarang.filter(b => {
            // Search filter
            const matchSearch = !this.search || 
                b.nama.toLowerCase().includes(this.search.toLowerCase()) || 
                b.kode.toLowerCase().includes(this.search.toLowerCase());
            
            // Category filter
            const matchCategory = this.selectedCategory === 'Semua' || b.kategori === this.selectedCategory;
            
            return matchSearch && matchCategory;
        });
    },

    get stats() {
        const list = this.filteredBarang;
        const totalJenis = list.length;
        const totalStokAkhir = list.reduce((sum, item) => sum + item.stok_akhir, 0);
        const totalMasuk = list.reduce((sum, item) => sum + item.masuk, 0);
        const totalKeluar = list.reduce((sum, item) => sum + item.keluar, 0);

        return { totalJenis, totalStokAkhir, totalMasuk, totalKeluar };
    },

    exportExcel() {
        let headers = ['No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Stok Awal', 'Total Masuk', 'Total Keluar', 'Stok Akhir', 'Status', 'Last Updated'];
        let rows = this.filteredBarang.map((b, index) => [
            index + 1,
            b.kode,
            b.nama,
            b.kategori,
            b.stok_awal,
            b.masuk,
            b.keluar,
            b.stok_akhir,
            b.status,
            b.updated_at
        ]);
        let csvContent = 'data:text/csv;charset=utf-8,\uFEFF'; // Added BOM for Excel UTF-8 support
        csvContent += headers.map(h => '\'' + h + '\'').join(',') + '\n';
        rows.forEach(rowArray => {
            let row = rowArray.map(val => '\'' + val + '\'').join(',');
            csvContent += row + '\n';
        });
        
        let encodedUri = encodeURI(csvContent);
        let link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'Laporan_Stok_JeWePe_' + new Date().toISOString().split('T')[0] + '.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    },

    printReport() {
        window.print();
    }
}" class="space-y-6 print:space-y-4 print:p-0">
    <!-- Header Page (Hidden on print unless styled) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 print:border-b print:pb-4 print:mb-4">
        <div>
            <h1 class="text-2xl font-heading print:text-xl print:font-bold">Laporan Persediaan Barang</h1>
            <p class="text-sm text-neutral-text-muted print:text-xs">Rekapitulasi sirkulasi stok masuk, keluar, dan sisa persediaan fisik keperluan barang perusahaan steel.</p>
        </div>
        <div class="flex items-center gap-2 print:hidden">
            <button 
                @click="exportExcel()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text text-sm font-medium transition-colors cursor-pointer"
            >
                <x-heroicon-o-document-arrow-down class="w-4 h-4 text-emerald-600" />
                Export Excel
            </button>
            <button 
                @click="printReport()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-black text-white dark:bg-white dark:text-black rounded-lg hover:opacity-90 text-sm font-medium transition-opacity cursor-pointer"
            >
                <x-heroicon-o-printer class="w-4 h-4" />
                Cetak / PDF
            </button>
        </div>
    </div>

    <!-- Filter Section (Hidden on Print) -->
    @include('laporan.filter')

    <!-- Stats Summary Cards (Print friendly design) -->
    @include('laporan.stats')

    <!-- Detailed Inventory Report Table -->
    @include('laporan.table')

</div>
@endsection

