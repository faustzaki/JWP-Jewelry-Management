    <!-- Table Container -->
    <div class="border border-neutral-border bg-neutral-surface rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                <thead>
                    <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Kode</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Nama Perhiasan</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Kategori</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-right">Stok</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Satuan</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Mutasi Terakhir</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Status</th>
                        <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="item in filteredBarang" :key="item.id">
                        <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors">
                            <td class="py-3.5 px-6 font-mono text-neutral-text-muted" x-text="item.kode"></td>
                            <td class="py-3.5 px-6 font-medium" x-text="item.nama"></td>
                            <td class="py-3.5 px-6 text-neutral-text-muted" x-text="item.kategori"></td>
                            <td class="py-3.5 px-6 text-right font-semibold" :class="item.stok < 10 ? 'text-error' : ''" x-text="item.stok"></td>
                            <td class="py-3.5 px-6 text-neutral-text-muted" x-text="item.satuan"></td>
                            <td class="py-3.5 px-6">
                                <template x-if="item.mutasi">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-xs" :class="item.mutasi.tipe === 'masuk' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                                            <span x-text="item.mutasi.tipe === 'masuk' ? '+' : '-'"></span><span x-text="item.mutasi.qty"></span> <span x-text="item.satuan"></span>
                                        </span>
                                        <span class="text-[11px] text-neutral-text-muted" x-text="item.mutasi.tanggal"></span>
                                    </div>
                                </template>
                                <template x-if="!item.mutasi">
                                    <span class="text-xs text-neutral-text-muted">-</span>
                                </template>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <span 
                                    x-show="item.stok > 0"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success/10 border border-success/30 text-success"
                                >
                                    Tersedia
                                </span>
                                <span 
                                    x-show="item.stok === 0"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-error/10 border border-error/30 text-error"
                                >
                                    Tidak Tersedia
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a 
                                        :href="'{{ route('persediaan.masuk.index') }}?barang_id=' + item.id"
                                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                    >
                                        <x-heroicon-o-plus class="w-3.5 h-3.5 text-success" stroke-width="2" />
                                        Masuk
                                    </a>
                                    <a 
                                        :href="item.stok === 0 ? '#' : '{{ route('persediaan.keluar.index') }}?barang_id=' + item.id"
                                        :class="item.stok === 0 ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-neutral-bg cursor-pointer'"
                                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface text-neutral-text transition-colors"
                                    >
                                        <x-heroicon-o-minus class="w-3.5 h-3.5 text-error" stroke-width="2" />
                                        Keluar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
