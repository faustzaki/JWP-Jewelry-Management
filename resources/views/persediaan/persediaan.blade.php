@extends('layouts.app')

@section('title', 'Stok Persediaan')

@section('content')
<div x-data="{ 
    statusFilter: '{{ request('filter', 'semua') }}',
    categoryFilter: '{{ request('kategori', 'semua') }}',
    searchQuery: '',
    
    // Injeksi dari Controller
    daftarBarang: {{ Illuminate\Support\Js::from($barangs) }},

    // Computed property to filter and sort items dynamically
    get filteredBarang() {
        let list = [...this.daftarBarang];

        // Filter by Search Query
        if (this.searchQuery) {
            const query = this.searchQuery.toLowerCase();
            list = list.filter(item => item.nama.toLowerCase().includes(query) || item.kode.toLowerCase().includes(query));
        }

        // Filter by Category
        if (this.categoryFilter !== 'semua') {
            list = list.filter(item => item.kategori === this.categoryFilter);
        }

        // Filter by Stock Status / Condition
        if (this.statusFilter === 'tersedia') {
            list = list.filter(item => item.stok > 0);
        } else if (this.statusFilter === 'tidak_tersedia') {
            list = list.filter(item => item.stok === 0);
        } else if (this.statusFilter === 'menipis') {
            list = list.filter(item => item.stok < 10);
        }

        // Sort by Stock if 'terbanyak' is chosen
        if (this.statusFilter === 'terbanyak') {
            list.sort((a, b) => b.stok - a.stok);
        } else {
            // Default sorting by ID
            list.sort((a, b) => a.id - b.id);
        }

        return list;
    }
}" class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-heading">Stok Persediaan Perhiasan</h1>
            <p class="text-sm text-neutral-text-muted">Kelola persediaan fisik, catat barang masuk dan barang keluar secara real-time.</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    @include('persediaan.filter')

    <!-- Table Container -->
    @include('persediaan.table')

</div>
@endsection
