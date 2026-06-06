    <!-- Modal Detail Produk Perhiasan -->
    <div 
        x-show="showProductDetailModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <!-- Backdrop with fade transition -->
        <div 
            x-show="showProductDetailModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/40 backdrop-blur-[20px]"
            @click="showProductDetailModal = false"
        ></div>

        <!-- Modal Panel with scale & fade transitions -->
        <div 
            x-show="showProductDetailModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-md min-w-[300px] sm:min-w-[440px] bg-neutral-surface border border-neutral-border rounded-xl shadow-lvl3 overflow-hidden z-10 p-6 flex flex-col max-h-[85vh]"
        >
            <div class="flex items-center justify-between border-b border-neutral-border pb-4 mb-4">
                <div>
                    <h3 class="text-lg font-heading">Detail Informasi Produk</h3>
                    <p class="text-xs text-neutral-text-muted" x-text="'Kode Barang: ' + selectedProduct.kode_barang"></p>
                </div>
                <button @click="showProductDetailModal = false" class="text-neutral-text-muted hover:text-neutral-text transition-colors cursor-pointer">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <!-- Product details content -->
            <div class="space-y-4 text-sm overflow-y-auto flex-1 pr-1">
                <div class="grid grid-cols-3 py-1 border-b border-neutral-border/50">
                    <span class="text-neutral-text-muted font-medium">Nama Barang</span>
                    <span class="col-span-2 font-semibold text-neutral-text" x-text="selectedProduct.nama_barang"></span>
                </div>
                <div class="grid grid-cols-3 py-1 border-b border-neutral-border/50">
                    <span class="text-neutral-text-muted font-medium">Kategori</span>
                    <span class="col-span-2 text-neutral-text" x-text="selectedProduct.kategori"></span>
                </div>
                <div class="space-y-1 pt-1">
                    <span class="text-neutral-text-muted font-medium block">Deskripsi Produk</span>
                    <p class="text-neutral-text leading-relaxed text-justify bg-neutral-bg dark:bg-neutral-bg/30 p-3 rounded-lg border border-neutral-border/50 whitespace-pre-line" x-text="selectedProduct.deskripsi || 'Tidak ada deskripsi untuk produk ini.'"></p>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-neutral-border mt-4">
                <button type="button" @click="showProductDetailModal = false" class="px-4 py-2 border border-neutral-border rounded-lg text-sm font-medium bg-neutral-bg hover:opacity-90 text-neutral-text transition-all cursor-pointer">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>

