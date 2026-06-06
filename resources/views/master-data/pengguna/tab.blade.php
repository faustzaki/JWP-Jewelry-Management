    <!-- Tab Content 3: Pengguna (Admin) -->
    <div x-show="activeTab === 'pengguna'" class="grid grid-cols-1 xl:grid-cols-3 gap-6" style="display: none;">
        <!-- Form Pengguna (Sisi Kanan di Desktop) -->
        <div class="xl:col-span-1 border border-neutral-border bg-neutral-surface rounded-xl p-6 shadow-sm h-fit order-first xl:order-last">
            <h3 class="text-lg font-heading mb-4" x-text="editingPenggunaId ? 'Ubah Detail Pengguna' : 'Registrasi Pengguna Baru'"></h3>
            <form :action="editingPenggunaId ? '/master-data/pengguna/' + editingPenggunaId : '{{ route('pengguna.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editingPenggunaId">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="hidden" name="tab" value="pengguna">
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Username</label>
                    <input 
                        name="username" x-model="inputPengguna.username"
                        type="text" 
                        required
                        placeholder="Misal: admin_jewepe" 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Nama Lengkap</label>
                    <input 
                        name="nama_lengkap" x-model="inputPengguna.nama_lengkap"
                        type="text" 
                        required
                        placeholder="Contoh: Administrator JeWePe" 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                </div>
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Email</label>
                    <input 
                        name="email" x-model="inputPengguna.email"
                        type="email" 
                        required
                        placeholder="Contoh: admin@jewepe.com" 
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                </div>
                
                <div class="text-xs text-neutral-text-muted bg-neutral-bg dark:bg-neutral-bg/30 border border-neutral-border/50 rounded-lg p-3 leading-relaxed" x-show="!editingPenggunaId">
                    <p>Password default: <span class="font-mono font-bold bg-neutral-surface px-1.5 py-0.5 rounded border border-neutral-border text-neutral-text">jwpadmin</span></p>
                    <p class="mt-1">Role pengguna akan ditetapkan secara otomatis sebagai <span class="font-semibold text-neutral-text">Admin</span>.</p>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button 
                        type="submit" 
                        class="flex-1 bg-black text-white dark:bg-white dark:text-black font-medium text-sm px-4 py-2 rounded-lg hover:opacity-90 transition-opacity cursor-pointer text-center"
                        x-text="editingPenggunaId ? 'Simpan Perubahan' : 'Tambah Pengguna'"
                    ></button>
                    <button 
                        type="button"
                        x-show="editingPenggunaId"
                        @click="resetPenggunaForm()"
                        class="border border-neutral-border hover:bg-neutral-bg text-neutral-text font-medium text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Pengguna (Sisi Kiri di Desktop) -->
        <div class="xl:col-span-2 border border-neutral-border bg-neutral-surface rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                <h3 class="text-lg font-heading">Daftar Pengguna Dashboard</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-neutral-border bg-neutral-bg/50 dark:bg-neutral-bg/50">
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">No</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Username</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading">Nama Lengkap</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Role</th>
                            <th class="py-3.5 px-6 text-neutral-text-muted font-heading text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penggunas as $index => $user)
                            <tr class="border-b border-neutral-border/50 hover:bg-neutral-bg/30 dark:bg-neutral-bg/30 transition-colors">
                                <td class="py-3.5 px-6 text-neutral-text-muted font-mono">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-6 font-mono text-xs">{{ $user->username }}</td>
                                <td class="py-3.5 px-6 font-medium">{{ $user->nama_lengkap }}</td>
                                <td class="py-3.5 px-6 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-bg text-neutral-text border border-neutral-border">{{ $user->role }}</span>
                                </td>
                                <td class="py-3.5 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button 
                                            @click='openUserDetail(@json($user))'
                                            class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                        >
                                            Detail
                                        </button>
                                        <button 
                                            @click='editPengguna(@json($user))'
                                            class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs font-medium border border-neutral-border rounded-lg bg-neutral-surface hover:bg-neutral-bg text-neutral-text transition-colors cursor-pointer"
                                        >
                                            Edit
                                        </button>
                                        <form id="form-delete-pengguna-{{ $user->id }}" action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="tab" value="pengguna">
                                            <button 
                                                type="button"
                                                @click="$dispatch('open-confirm', { title: 'Hapus Pengguna', message: 'Apakah Anda yakin ingin menghapus pengguna {{ addslashes($user->nama_lengkap) }}?', onConfirm: () => document.getElementById('form-delete-pengguna-{{ $user->id }}').submit() })"
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

