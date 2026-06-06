    <!-- Modal Detail Kategori -->
    <div 
        x-show="showDetailModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <!-- Backdrop with fade transition -->
        <div 
            x-show="showDetailModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/40 backdrop-blur-[20px]"
            @click="showDetailModal = false"
        ></div>

        <!-- Modal Panel with scale & fade transitions -->
        <div 
            x-show="showDetailModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-lg min-w-[300px] sm:min-w-[480px] bg-neutral-surface border border-neutral-border rounded-xl shadow-lvl3 overflow-hidden z-10 p-6 flex flex-col max-h-[80vh]"
        >
            <div class="flex items-center justify-between border-b border-neutral-border pb-4 mb-4">
                <div>
                    <h3 class="text-lg font-heading" x-text="'Detail Kategori: ' + selectedCategory.nama_kategori"></h3>
                    <p class="text-xs text-neutral-text-muted" x-text="'Prefix Kode: ' + selectedCategory.prefix"></p>
                </div>
                <button @click="showDetailModal = false" class="text-neutral-text-muted hover:text-neutral-text transition-colors cursor-pointer">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <!-- List Products in Category -->
            <div class="overflow-y-auto flex-1 pr-1">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                            <th class="py-2.5 px-4 text-neutral-text-muted font-heading">Kode Barang</th>
                            <th class="py-2.5 px-4 text-neutral-text-muted font-heading">Nama Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in selectedCategory.barangs" :key="item.id">
                            <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors">
                                <td class="py-2.5 px-4 font-mono text-xs text-neutral-text-muted" x-text="item.kode_barang"></td>
                                <td class="py-2.5 px-4 font-medium" x-text="item.nama_barang"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <div x-show="!selectedCategory.barangs || selectedCategory.barangs.length === 0" class="py-12 text-center text-neutral-text-muted space-y-2">
                    <x-heroicon-o-cube class="w-12 h-12 mx-auto opacity-40" stroke-width="1" />
                    <p class="text-sm font-medium">Belum Ada Produk</p>
                    <p class="text-xs">Tidak ada perhiasan yang terdaftar di dalam kategori ini.</p>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-neutral-border mt-4">
                <button type="button" @click="showDetailModal = false" class="px-4 py-2 border border-neutral-border rounded-lg text-sm font-medium bg-neutral-bg hover:opacity-90 text-neutral-text transition-all cursor-pointer">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>

