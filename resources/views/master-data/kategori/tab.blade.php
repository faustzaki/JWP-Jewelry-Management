    <!-- Tab Content 1: Kategori Barang -->
    <div x-show="activeTab === 'kategori'" class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Form Kategori (Sisi Kanan di Desktop) -->
        <div class="xl:col-span-1 border border-neutral-border bg-neutral-surface rounded-xl p-6 shadow-sm h-fit order-first xl:order-last">
            <h3 class="text-lg font-heading mb-4" x-text="editingKategoriId ? 'Ubah Kategori' : 'Input Kategori Baru'"></h3>
            <form :action="editingKategoriId ? '/master-data/kategori/' + editingKategoriId : '{{ route('kategori.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editingKategoriId">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="hidden" name="tab" value="kategori">
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Nama Kategori</label>
                    <input 
                        name="nama_kategori"
                        x-model="inputKategori"
                        type="text" 
                        required
                        placeholder="Misal: Cincin, Kalung..." 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Prefix Kode Barang</label>
                    <input 
                        name="prefix"
                        x-model="inputPrefix"
                        type="text" 
                        required
                        placeholder="Misal: JW-CIN, JW-GEL..." 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow uppercase" 
                    />
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <button 
                        type="submit" 
                        class="flex-1 bg-black text-white dark:bg-white dark:text-black font-medium text-sm px-4 py-2 rounded-lg hover:opacity-90 transition-opacity cursor-pointer text-center"
                        x-text="editingKategoriId ? 'Simpan Perubahan' : 'Tambah Kategori'"
                    ></button>
                    <button 
                        type="button"
                        x-show="editingKategoriId"
                        @click="resetKategoriForm()"
                        class="border border-neutral-border hover:bg-neutral-bg text-neutral-text font-medium text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Kategori (Sisi Kiri di Desktop) -->
        <div class="xl:col-span-2 border border-neutral-border bg-neutral-surface rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                <h3 class="text-lg font-heading">Daftar Kategori Perhiasan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">No</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Nama Kategori</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Prefix Kode</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Jumlah Produk</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $index => $cat)
                            <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors">
                                <td class="py-3.5 px-6 text-neutral-text-muted font-mono">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-6 font-medium">{{ $cat->nama_kategori }}</td>
                                <td class="py-3.5 px-6 font-mono text-xs text-neutral-text-muted">{{ $cat->prefix }}</td>
                                <td class="py-3.5 px-6 text-center font-mono">{{ $cat->barangs_count }} Item</td>
                                <td class="py-3.5 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button 
                                            @click='openDetail(@json($cat), @json($cat->barangs))'
                                            class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                        >
                                            Detail
                                        </button>
                                        <button 
                                            @click='editKategori(@json($cat))'
                                            class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                        >
                                            Edit
                                        </button>
                                        <form id="form-delete-kategori-{{ $cat->id }}" action="{{ route('kategori.destroy', $cat->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="tab" value="kategori">
                                            <button 
                                                type="button"
                                                @click="$dispatch('open-confirm', { title: 'Hapus Kategori', message: 'Apakah Anda yakin ingin menghapus kategori {{ addslashes($cat->nama_kategori) }}?', onConfirm: () => document.getElementById('form-delete-kategori-{{ $cat->id }}').submit() })"
                                                class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-error hover:border-error/30 hover:bg-error/5 transition-colors cursor-pointer"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

