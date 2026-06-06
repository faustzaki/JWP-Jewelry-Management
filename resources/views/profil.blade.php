@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-success/10 border border-success/20 text-success text-sm flex items-center justify-between" x-data="{ show: true }" x-show="show">
    <span>{{ session('success') }}</span>
    <button @click="show = false" class="text-success hover:opacity-75 cursor-pointer"><x-heroicon-o-x-mark class="w-5 h-5"/></button>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-error/10 border border-error/20 text-error text-sm flex items-start flex-col gap-1" x-data="{ show: true }" x-show="show">
    <div class="flex items-center justify-between w-full">
        <span class="font-bold">Terjadi kesalahan:</span>
        <button @click="show = false" class="text-error hover:opacity-75 cursor-pointer"><x-heroicon-o-x-mark class="w-5 h-5"/></button>
    </div>
    <ul class="list-disc list-inside mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div x-data="{
    // User profile state
    user: {{ Js::from(auth()->user()) }},
    
    // Form input binding
    inputUser: {
        username: '{{ old('username', auth()->user()->username) }}',
        nama: '{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}',
        email: '{{ old('email', auth()->user()->email) }}',
        passwordLama: '',
        password: '',
        konfirmasiPassword: ''
    },
    
    // Avatar preview
    avatarPreview: '{{ auth()->user()->foto_profil ? asset('storage/'.auth()->user()->foto_profil) : '' }}',

    triggerAvatarUpload() {
        this.$refs.avatarInput.click();
    },

    onAvatarChange(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.avatarPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },

    saveProfile() {
        if (!this.inputUser.username.trim() || !this.inputUser.nama.trim() || !this.inputUser.email.trim()) {
            window.dispatchEvent(new CustomEvent('open-confirm', { detail: { title: 'Peringatan', message: 'Harap lengkapi Username, Nama Lengkap, dan Email!', type: 'danger', isAlert: true } }));
            return;
        }

        if (this.inputUser.password) {
            if (!this.inputUser.passwordLama) {
                window.dispatchEvent(new CustomEvent('open-confirm', { detail: { title: 'Peringatan', message: 'Harap masukkan password lama Anda untuk mengganti password!', type: 'danger', isAlert: true } }));
                return;
            }
            if (this.inputUser.password !== this.inputUser.konfirmasiPassword) {
                window.dispatchEvent(new CustomEvent('open-confirm', { detail: { title: 'Peringatan', message: 'Password baru dan konfirmasi password tidak cocok!', type: 'danger', isAlert: true } }));
                return;
            }
        }

        window.dispatchEvent(new CustomEvent('open-confirm', { 
            detail: {
                title: 'Simpan Perubahan', 
                message: 'Apakah Anda yakin ingin menyimpan perubahan profil ini?', 
                type: 'primary', 
                onConfirm: () => {
                    document.getElementById('profile-form').submit();
                }
            }
        }));
    }
}" class="w-full max-w-[56rem] mx-auto space-y-6">
    {{-- Judul halaman dan deskripsi fungsi halaman manajemen pengaturan akun --}}
    <div>
        <h1 class="text-2xl font-heading">Pengaturan Profil</h1>
        <p class="text-sm text-neutral-text-muted">Kelola kredensial akun, ganti foto profil, serta update kata sandi masuk sistem.</p>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        
        {{-- Sisi kiri: Card info ringkas dan tombol upload foto profil berbasis Alpine.js --}}
        <div class="md:col-span-1 border border-neutral-border bg-neutral-surface rounded-xl p-6 shadow-sm flex flex-col items-center text-center space-y-5">
            <h3 class="text-sm font-semibold text-neutral-text-muted uppercase tracking-wider self-start">Foto Profil</h3>
            
            <div class="relative group">
                <div class="w-32 h-32 rounded-full overflow-hidden border border-neutral-border bg-neutral-bg flex items-center justify-center">
                    <template x-if="avatarPreview">
                        <img :src="avatarPreview" class="w-full h-full object-cover" alt="Pratinjau Foto Profil" />
                    </template>
                    <template x-if="!avatarPreview">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama_lengkap) }}&background=0D8ABC&color=fff" class="w-full h-full object-cover" alt="Pratinjau Foto Profil" />
                    </template>
                </div>
                <!-- Hover Upload Overlay -->
                <button 
                    @click="triggerAvatarUpload()"
                    class="absolute inset-0 bg-black/60 rounded-full flex flex-col items-center justify-center text-white text-[10px] font-medium opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer duration-200"
                >
                    <x-heroicon-o-camera class="w-5 h-5 mb-1" stroke-width="2" />
                    Ganti Foto
                </button>
            </div>

            <!-- User Info display -->
            <div class="space-y-1">
                <h4 class="font-heading text-lg text-neutral-text" x-text="user.nama_lengkap"></h4>
                <p class="text-xs font-mono text-neutral-text-muted" x-text="'@' + user.username"></p>
                <p class="text-xs text-neutral-text-muted" x-text="user.email"></p>
            </div>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-neutral-bg text-neutral-text border border-neutral-border" x-text="user.role"></span>
        </div>

        <!-- Right Side: Edit Form Card -->
        <div class="md:col-span-2 border border-neutral-border bg-neutral-surface rounded-xl p-6 shadow-sm space-y-6">
            <h3 class="text-lg font-heading pb-3 border-b border-neutral-border/50">Ubah Informasi Akun</h3>
            
            <form id="profile-form" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" @submit.prevent="saveProfile()" class="space-y-5">
                @csrf
                
                <input 
                    type="file" 
                    name="foto_profil"
                    x-ref="avatarInput" 
                    accept="image/*" 
                    class="hidden" 
                    @change="onAvatarChange($event)" 
                />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5 col-span-2 sm:col-span-1">
                        <label class="text-sm font-medium text-neutral-text-muted">Username</label>
                        <input 
                            name="username"
                            x-model="inputUser.username"
                            type="text" 
                            required
                            class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                        />
                    </div>
                    <div class="space-y-1.5 col-span-2 sm:col-span-1">
                        <label class="text-sm font-medium text-neutral-text-muted">Nama Lengkap</label>
                        <input 
                            name="nama_lengkap"
                            x-model="inputUser.nama"
                            type="text" 
                            required
                            class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                        />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-text-muted">Alamat Email</label>
                    <input 
                        name="email"
                        x-model="inputUser.email"
                        type="email" 
                        required
                        class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                    />
                </div>

                <div class="border-t border-neutral-border/50 pt-4 space-y-4">
                    <h4 class="text-sm font-heading uppercase tracking-wider text-neutral-text-muted">Ganti Password</h4>
                    
                    <div class="space-y-1.5 mb-4">
                        <label class="text-sm font-medium text-neutral-text-muted">Password Lama</label>
                        <input 
                            name="password_lama"
                            x-model="inputUser.passwordLama"
                            type="password" 
                            placeholder="••••••••" 
                            class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                        />
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-neutral-text-muted">Password Baru</label>
                            <input 
                                name="password"
                                x-model="inputUser.password"
                                type="password" 
                                placeholder="••••••••" 
                                class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-neutral-text-muted">Konfirmasi Password Baru</label>
                            <input 
                                name="password_confirmation"
                                x-model="inputUser.konfirmasiPassword"
                                type="password" 
                                placeholder="••••••••" 
                                class="w-full border border-neutral-border bg-transparent rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-shadow" 
                            />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-neutral-border/50">
                    <button 
                        type="submit" 
                        class="bg-black text-white dark:bg-white dark:text-black font-medium text-sm px-6 py-2.5 rounded-lg hover:opacity-90 transition-opacity cursor-pointer"
                    >
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
