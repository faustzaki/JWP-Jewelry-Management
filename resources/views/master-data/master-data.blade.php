@extends('layouts.app')

@section('title', 'Master Data')

@section('content')
<div x-data="{
    activeTab: '{{ session('tab', old('tab', 'kategori')) }}',
    
    // Category form state
    inputKategori: '',
    inputPrefix: '',
    editingKategoriId: null,

    // Product form state
    inputBarang: {
        kategori_barang_id: '',
        nama_barang: '',
        satuan: 'Pcs',
        deskripsi: '',
        prefix: '',
        nomor: '',
        nomorPlaceholder: ''
    },
    editingBarangId: null,

    // Category detail modal state
    showDetailModal: false,
    selectedCategory: { nama_kategori: '', prefix: '', barangs: [] },

    // Product detail modal state
    showProductDetailModal: false,
    selectedProduct: { kode_barang: '', nama_barang: '', kategori: '', deskripsi: '' },

    // User form state
    inputPengguna: {
        username: '',
        nama_lengkap: '',
        email: ''
    },
    editingPenggunaId: null,

    // User detail modal state
    showUserDetailModal: false,
    selectedUser: { username: '', nama_lengkap: '', email: '', role: '', created_at: '' },

    openDetail(cat, barangs) {
        this.selectedCategory = cat;
        this.selectedCategory.barangs = barangs;
        this.showDetailModal = true;
    },

    openProductDetail(item, katName) {
        this.selectedProduct = item;
        this.selectedProduct.kategori = katName;
        this.showProductDetailModal = true;
    },

    openUserDetail(user) {
        this.selectedUser = user;
        this.showUserDetailModal = true;
    },

    onCategoryChange(kategoriList) {
        const cat = kategoriList.find(c => c.id == this.inputBarang.kategori_barang_id);
        if (cat && cat.prefix) {
            this.inputBarang.prefix = cat.prefix;
            if (!this.editingBarangId) {
                const nextNum = cat.barangs_count + 1;
                this.inputBarang.nomorPlaceholder = String(nextNum).padStart(2, '0');
                this.inputBarang.nomor = '';
            }
        } else {
            this.inputBarang.prefix = '';
            this.inputBarang.nomorPlaceholder = '';
            if (!this.editingBarangId) {
                this.inputBarang.nomor = '';
            }
        }
    },

    editKategori(cat) {
        this.inputKategori = cat.nama_kategori;
        this.inputPrefix = cat.prefix;
        this.editingKategoriId = cat.id;
    },

    editBarang(item, catPrefix) {
        let prefix = '';
        let nomor = '';
        if (catPrefix && item.kode_barang.startsWith(catPrefix)) {
            prefix = catPrefix;
            nomor = item.kode_barang.substring(catPrefix.length);
        } else {
            nomor = item.kode_barang;
        }
        this.inputBarang = { 
            kategori_barang_id: item.kategori_barang_id,
            nama_barang: item.nama_barang,
            satuan: item.satuan,
            deskripsi: item.deskripsi || '',
            prefix: prefix,
            nomor: nomor,
            nomorPlaceholder: nomor
        };
        this.editingBarangId = item.id;
    },

    editPengguna(user) {
        this.inputPengguna = {
            username: user.username,
            nama_lengkap: user.nama_lengkap,
            email: user.email
        };
        this.editingPenggunaId = user.id;
    },

    resetKategoriForm() {
        this.inputKategori = '';
        this.inputPrefix = '';
        this.editingKategoriId = null;
    },

    resetBarangForm() {
        this.inputBarang = { kategori_barang_id: '', nama_barang: '', satuan: 'Pcs', deskripsi: '', prefix: '', nomor: '', nomorPlaceholder: '' };
        this.editingBarangId = null;
    },

    resetPenggunaForm() {
        this.inputPengguna = { username: '', nama_lengkap: '', email: '' };
        this.editingPenggunaId = null;
    }
}" class="space-y-6">
    <!-- Header Page -->
    <div>
        <h1 class="text-2xl font-heading">Manajemen Master Data</h1>
        <p class="text-sm text-neutral-text-muted">Kelola master Kategori Keperluan Barang Perusahaan Steel dan katalog produk terdaftar di Toko JeWePe.</p>
    </div>

    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-success/10 text-success border border-success/20 p-4 rounded-xl text-sm font-medium mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-error/10 text-error border border-error/20 p-4 rounded-xl text-sm font-medium mb-6">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-error/10 text-error border border-error/20 p-4 rounded-xl text-sm font-medium mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="border-b border-neutral-border flex items-center gap-6">
        <button 
            @click="activeTab = 'kategori'"
            :class="activeTab === 'kategori' ? 'border-primary text-neutral-text font-semibold' : 'border-transparent text-neutral-text-muted hover:text-neutral-text'"
            class="pb-3 border-b-2 text-sm font-medium transition-all cursor-pointer"
        >
            Kategori Barang
        </button>
        <button 
            @click="activeTab = 'barang'"
            :class="activeTab === 'barang' ? 'border-primary text-neutral-text font-semibold' : 'border-transparent text-neutral-text-muted hover:text-neutral-text'"
            class="pb-3 border-b-2 text-sm font-medium transition-all cursor-pointer"
        >
            Daftar Keperluan Barang Perusahaan Steel (Barang)
        </button>
        <button 
            @click="activeTab = 'pengguna'"
            :class="activeTab === 'pengguna' ? 'border-primary text-neutral-text font-semibold' : 'border-transparent text-neutral-text-muted hover:text-neutral-text'"
            class="pb-3 border-b-2 text-sm font-medium transition-all cursor-pointer"
        >
            Pengguna (Admin)
        </button>
    </div>

    <!-- Tab Content 1: Kategori Barang -->
    @include('master-data.kategori.tab')

    <!-- Tab Content 2: Daftar Keperluan Barang Perusahaan Steel (Barang) -->
    @include('master-data.barang.tab')

    <!-- Tab Content 3: Pengguna (Admin) -->
    @include('master-data.pengguna.tab')

    <!-- Modal Detail Kategori -->
    @include('master-data.kategori.modal')

    <!-- Modal Detail Produk keperluan barang perusahaan steel -->
    @include('master-data.barang.modal')

    <!-- Modal Detail Pengguna Admin -->
    @include('master-data.pengguna.modal')

</div>
@endsection



