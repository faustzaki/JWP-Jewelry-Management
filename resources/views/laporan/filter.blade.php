    <!-- Filter Section (Hidden on Print) -->
    <div class="border border-neutral-border bg-neutral-surface rounded-xl p-5 shadow-sm print:hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search bar -->
            <div class="space-y-1.5 col-span-1 sm:col-span-2 lg:col-span-2">
                <label class="text-xs font-semibold text-neutral-text-muted">Cari Barang</label>
                <div class="relative">
                    <input 
                        x-model="search"
                        type="text" 
                        placeholder="Kode atau Nama Keperluan Barang Perusahaan Steel..." 
                        class="w-full border border-neutral-border bg-transparent rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-text-muted">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" stroke-width="2" />
                    </div>
                </div>
            </div>

            <!-- Kategori -->
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-neutral-text-muted">Kategori</label>
                <div class="relative">
                    <select 
                        x-model="selectedCategory"
                        class="w-full border border-neutral-border bg-transparent rounded-lg pl-3 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow appearance-none cursor-pointer"
                    >
                        <template x-for="cat in daftarKategori" :key="cat">
                            <option :value="cat" x-text="cat" class="bg-white text-black dark:bg-neutral-surface dark:text-white"></option>
                        </template>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-text-muted">
                        <x-heroicon-o-chevron-down class="h-4 w-4" stroke-width="2" />
                    </div>
                </div>
            </div>

            <!-- Tanggal -->
            <form method="GET" action="{{ route('laporan.index') }}" x-ref="dateForm" class="space-y-1.5">
                <label class="text-xs font-semibold text-neutral-text-muted">Tanggal Laporan</label>
                <input 
                    name="date"
                    type="date" 
                    value="{{ $filterDate }}"
                    @change="$refs.dateForm.submit()"
                    class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow cursor-pointer" 
                />
            </form>
        </div>
        
        <!-- Quick Reset Filter -->
        <div class="flex justify-end mt-4 pt-4 border-t border-neutral-border/50" x-show="search || selectedCategory !== 'Semua' || '{{ $filterDate }}' !== '{{ \Carbon\Carbon::today()->format('Y-m-d') }}'">
            <button 
                @click="search = ''; selectedCategory = 'Semua'; if ('{{ $filterDate }}' !== '{{ \Carbon\Carbon::today()->format('Y-m-d') }}') window.location.href='{{ route('laporan.index') }}';"
                class="text-xs font-medium text-neutral-text hover:underline cursor-pointer"
            >
                Reset Filter
            </button>
        </div>
    </div>


