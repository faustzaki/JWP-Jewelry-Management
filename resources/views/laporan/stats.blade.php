    <!-- Stats Summary Cards (Print friendly design) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="border border-neutral-border bg-neutral-surface rounded-xl p-5 shadow-sm print:shadow-none print:border-neutral-border/80">
            <span class="text-xs font-medium text-neutral-text-muted uppercase tracking-wider block">Total Jenis Barang</span>
            <span class="text-2xl font-semibold mt-1 block font-mono" x-text="stats.totalJenis"></span>
        </div>
        <div class="border border-neutral-border bg-neutral-surface rounded-xl p-5 shadow-sm print:shadow-none print:border-neutral-border/80">
            <span class="text-xs font-medium text-neutral-text-muted uppercase tracking-wider block">Total Stok Gudang</span>
            <span class="text-2xl font-semibold mt-1 block font-mono" x-text="stats.totalStokAkhir + ' Pcs'"></span>
        </div>
        <div class="border border-neutral-border bg-neutral-surface rounded-xl p-5 shadow-sm print:shadow-none print:border-neutral-border/80">
            <span class="text-xs font-medium text-neutral-text-muted uppercase tracking-wider block">Total Stok Masuk</span>
            <span class="text-2xl font-semibold mt-1 block font-mono text-neutral-text print:text-neutral-text" x-text="stats.totalMasuk + ' Pcs'"></span>
        </div>
        <div class="border border-neutral-border bg-neutral-surface rounded-xl p-5 shadow-sm print:shadow-none print:border-neutral-border/80">
            <span class="text-xs font-medium text-neutral-text-muted uppercase tracking-wider block">Total Stok Keluar</span>
            <span class="text-2xl font-semibold mt-1 block font-mono text-neutral-text print:text-neutral-text" x-text="stats.totalKeluar + ' Pcs'"></span>
        </div>
    </div>
