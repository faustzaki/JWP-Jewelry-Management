    <!-- Detailed Inventory Report Table -->
    <div class="border border-neutral-border bg-neutral-surface rounded-xl shadow-sm overflow-hidden flex flex-col print:border-none print:shadow-none">
        <div class="p-6 border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50 print:px-0 print:py-2 print:border-b-2">
            <h3 class="text-lg font-heading print:text-md print:font-bold">Laporan Detail Persediaan & Sirkulasi</h3>
            <span class="text-xs text-neutral-text-muted hidden print:block" x-text="'Tanggal: ' + (filterDate || 'Semua Waktu')"></span>
        </div>
        
        <div class="w-full overflow-x-hidden">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50 print:bg-neutral-bg/10">
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading print:py-2 print:px-3">No</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading print:py-2 print:px-3">Kode Barang</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading print:py-2 print:px-3">Nama Barang</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading print:py-2 print:px-3">Kategori</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading text-right print:py-2 print:px-3">Stok Awal</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading text-right print:py-2 print:px-3">Total Masuk</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading text-right print:py-2 print:px-3">Total Keluar</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading text-right print:py-2 print:px-3">Stok Akhir</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading text-center print:py-2 print:px-3">Status</th>
                        <th class="py-3.5 px-4 text-neutral-text-muted font-heading print:py-2 print:px-3">Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in filteredBarang" :key="item.id">
                        <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors print:hover:bg-transparent">
                            <td class="py-3.5 px-4 text-neutral-text-muted font-mono print:py-2 print:px-3" x-text="index + 1"></td>
                            <td class="py-3.5 px-4 font-mono text-xs text-neutral-text-muted print:py-2 print:px-3" x-text="item.kode"></td>
                            <td class="py-3.5 px-4 font-medium text-neutral-text print:py-2 print:px-3" x-text="item.nama"></td>
                            <td class="py-3.5 px-4 text-neutral-text-muted print:py-2 print:px-3" x-text="item.kategori"></td>
                            <td class="py-3.5 px-4 text-right font-mono print:py-2 print:px-3" x-text="item.stok_awal"></td>
                            <td class="py-3.5 px-4 text-right font-mono text-neutral-text print:py-2 print:px-3" x-text="'+' + item.masuk"></td>
                            <td class="py-3.5 px-4 text-right font-mono text-neutral-text print:py-2 print:px-3" x-text="'-' + item.keluar"></td>
                            <td class="py-3.5 px-4 text-right font-mono font-semibold text-neutral-text print:py-2 print:px-3" x-text="item.stok_akhir"></td>
                            <td class="py-3.5 px-4 text-center print:py-2 print:px-3">
                                <span 
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium print:border print:px-1.5"
                                    :class="{
                                        'bg-neutral-bg text-neutral-text border border-neutral-border print:bg-transparent': item.status === 'Aman',
                                        'bg-yellow-50 text-yellow-800 border border-yellow-200 dark:bg-yellow-950/20 dark:text-yellow-400 dark:border-yellow-900/50': item.status === 'Stok Menipis',
                                        'bg-error/5 text-error border border-error/10': item.status === 'Habis'
                                    }"
                                    x-text="item.status"
                                ></span>
                            </td>
                            <td class="py-3.5 px-4 text-neutral-text-muted font-mono text-xs print:py-2 print:px-3" x-text="item.updated_at"></td>
                        </tr>
                    </template>
                    
                    <tr x-show="filteredBarang.length === 0">
                        <td colspan="10" class="py-12 text-center text-neutral-text-muted space-y-2">
                            <x-heroicon-o-document-text class="w-12 h-12 mx-auto opacity-40" stroke-width="1" />
                            <p class="text-sm font-medium">Tidak Ada Data Ditemukan</p>
                            <p class="text-xs">Coba ubah kata kunci pencarian atau rentang tanggal filter Anda.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Report footer note -->
        <div class="p-6 border-t border-neutral-border bg-neutral-bg/20 dark:bg-neutral-bg/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-neutral-text-muted print:px-0 print:border-none print:mt-4">
            <span x-text="'Laporan dibuat otomatis oleh sistem Toko JeWePe pada ' + new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></span>
            <span class="font-mono text-[10px]" x-text="'PAGE_REF: JWP-STK-REP-' + new Date().getFullYear()"></span>
        </div>
    </div>
