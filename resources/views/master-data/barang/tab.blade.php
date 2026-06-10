    <!-- Tab Content 2: Daftar Keperluan Barang Perusahaan Steel (Barang) -->
    <div x-show="activeTab === 'barang'" class="grid grid-cols-1 xl:grid-cols-3 gap-6" style="display: none;">
        <!-- Form Tambah Produk (Sisi Kanan di Desktop) -->
        <div class="xl:col-span-1 border border-neutral-border bg-neutral-surface rounded-xl p-6 shadow-sm h-fit order-first xl:order-last">
            <h3 class="text-lg font-heading mb-4" x-text="editingBarangId ? 'Ubah Detail Barang' : 'Registrasi Barang Baru'"></h3>
            <form :action="editingBarangId ? '/master-data/barang/' + editingBarangId : '{{ route('barang.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editingBarangId">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="hidden" name="tab" value="barang">
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Kategori</label>
                    <div class="relative">
                        <select 
                            name="kategori_barang_id" x-model="inputBarang.kategori_barang_id"
                            required
                            @change="onCategoryChange({{ $kategoris }})"
                            class="w-full border border-neutral-border bg-transparent rounded-lg pl-3 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow appearance-none cursor-pointer"
                        >
                            <option value="" class="bg-white text-black dark:bg-neutral-surface dark:text-white">-- Pilih Kategori --</option>
                            @foreach($kategoris as $cat)<option value="{{ $cat->id }}" class="bg-white text-black dark:bg-neutral-surface dark:text-white">{{ $cat->nama_kategori }}</option>@endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-text-muted">
                            <x-heroicon-o-chevron-down class="h-4 w-4" />
                        </div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Kode Barang</label>
                    <div class="flex rounded-lg border border-neutral-border bg-transparent focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-shadow overflow-hidden">
                        <span 
                            class="bg-neutral-bg dark:bg-neutral-bg/30 text-neutral-text-muted text-sm px-3 py-2 border-r border-neutral-border select-none font-mono flex items-center" 
                            x-text="inputBarang.prefix || 'KODE'"
                        ></span>
                        <input type="hidden" name="kode_barang" :value="inputBarang.prefix + (inputBarang.nomor || inputBarang.nomorPlaceholder)">
                        <input 
                            x-model="inputBarang.nomor"
                            type="text" 
                            :placeholder="inputBarang.nomorPlaceholder || '00'" 
                            class="flex-1 bg-transparent px-3 py-2 text-sm focus:outline-none font-mono uppercase" 
                        />
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Nama Barang</label>
                    <input 
                        name="nama_barang" x-model="inputBarang.nama_barang"
                        type="text" 
                        required
                        placeholder="Contoh: Cincin Berlian Royal" 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                </div>
                <!-- Input Deskripsi Baru -->
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Deskripsi Produk</label>
                    <textarea 
                        name="deskripsi" x-model="inputBarang.deskripsi"
                        placeholder="Tuliskan deskripsi lengkap produk..." 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                        rows="3"
                    ></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button 
                        type="submit" 
                        class="flex-1 bg-black text-white dark:bg-white dark:text-black font-medium text-sm px-4 py-2 rounded-lg hover:opacity-90 transition-opacity cursor-pointer text-center"
                        x-text="editingBarangId ? 'Simpan Perubahan' : 'Daftarkan Barang'"
                    ></button>
                    <button 
                        type="button"
                        x-show="editingBarangId"
                        @click="resetBarangForm()"
                        class="border border-neutral-border hover:bg-neutral-bg text-neutral-text font-medium text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel keperluan barang perusahaan steel (Sederhana: Hanya Kode, Nama, Kategori, Aksi) -->
        <div class="xl:col-span-2 border border-neutral-border bg-neutral-surface rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                <h3 class="text-lg font-heading">Daftar Inventaris Produk</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Kode Barang</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Nama Barang</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Kategori</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $item)
                            <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors">
                                <td class="py-3.5 px-6 font-mono text-neutral-text-muted">{{ $item->kode_barang }}</td>
                                <td class="py-3.5 px-6 font-medium">{{ $item->nama_barang }}</td>
                                <td class="py-3.5 px-6 text-neutral-text-muted">{{ $item->kategoriBarang->nama_kategori }}</td>
                                <td class="py-3.5 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button 
                                            @click='openProductDetail(@json($item), @json($item->kategoriBarang->nama_kategori))'
                                            class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                        >
                                            Detail
                                        </button>
                                        <button 
                                            @click='editBarang(@json($item), @json($item->kategoriBarang->prefix))'
                                            class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                        >
                                            Edit
                                        </button>
                                        <form id="form-delete-barang-{{ $item->id }}" action="{{ route('barang.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="tab" value="barang">
                                            <button 
                                                type="button"
                                                @click="$dispatch('open-confirm', { title: 'Hapus Barang', message: 'Apakah Anda yakin ingin menghapus barang {{ addslashes($item->nama_barang) }}?', onConfirm: () => document.getElementById('form-delete-barang-{{ $item->id }}').submit() })"
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



