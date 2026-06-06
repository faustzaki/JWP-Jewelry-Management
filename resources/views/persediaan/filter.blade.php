    <!-- Filter & Search Bar -->
    <div class="bg-neutral-surface border border-neutral-border rounded-xl p-4 shadow-sm flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <!-- Status & Category Filters -->
        <div class="flex flex-wrap items-center gap-4">
            <!-- Status Filter Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <button 
                    @click="statusFilter = 'semua'"
                    :class="statusFilter === 'semua' ? 'bg-primary text-white border-primary' : 'bg-transparent hover:bg-black/5 dark:hover:bg-white/5 text-neutral-text border-neutral-border'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors cursor-pointer"
                >
                    Semua
                </button>
                <button 
                    @click="statusFilter = 'tersedia'"
                    :class="statusFilter === 'tersedia' ? 'bg-primary text-white border-primary' : 'bg-transparent hover:bg-black/5 dark:hover:bg-white/5 text-neutral-text border-neutral-border'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors cursor-pointer"
                >
                    Tersedia
                </button>
                <button 
                    @click="statusFilter = 'tidak_tersedia'"
                    :class="statusFilter === 'tidak_tersedia' ? 'bg-primary text-white border-primary' : 'bg-transparent hover:bg-black/5 dark:hover:bg-white/5 text-neutral-text border-neutral-border'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors cursor-pointer"
                >
                    Tidak Tersedia
                </button>
                <button 
                    @click="statusFilter = 'menipis'"
                    :class="statusFilter === 'menipis' ? 'bg-primary text-white border-primary' : 'bg-transparent hover:bg-black/5 dark:hover:bg-white/5 text-neutral-text border-neutral-border'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors cursor-pointer"
                >
                    Stok Menipis (&lt; 10)
                </button>
                <button 
                    @click="statusFilter = 'terbanyak'"
                    :class="statusFilter === 'terbanyak' ? 'bg-primary text-white border-primary' : 'bg-transparent hover:bg-black/5 dark:hover:bg-white/5 text-neutral-text border-neutral-border'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors cursor-pointer"
                >
                    Stok Terbanyak
                </button>
            </div>

            <!-- Divider Line -->
            <div class="hidden md:block h-6 w-px bg-neutral-border"></div>

            <!-- Category Filter Dropdown -->
            <div class="flex items-center gap-2">
                <label class="text-sm text-neutral-text-muted">Kategori:</label>
                <select 
                    x-model="categoryFilter"
                    class="border border-neutral-border rounded-lg pl-3 pr-8 py-1.5 text-sm bg-transparent text-neutral-text focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white cursor-pointer"
                >
                    <option value="semua" class="bg-white text-black dark:bg-neutral-surface dark:text-white">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->nama_kategori }}" class="bg-white text-black dark:bg-neutral-surface dark:text-white">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Search Input -->
        <div class="relative w-full md:w-72">
            <x-heroicon-o-magnifying-glass class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-text-muted" stroke-width="1.5" />
            <input 
                x-model="searchQuery"
                type="text" 
                placeholder="Cari nama atau kode barang..." 
                class="w-full border border-neutral-border bg-transparent rounded-full pl-9 pr-4 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
            />
        </div>
    </div>
