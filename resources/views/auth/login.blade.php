@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="bg-neutral-surface border border-neutral-border rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.05)] dark:shadow-[0_8px_24px_rgba(0,0,0,0.2)] p-8 sm:p-10 backdrop-blur-xl bg-opacity-90 dark:bg-opacity-90">
    
    <div class="text-center mb-8">
        <h1 class="text-3xl font-heading mb-2">JeWePe</h1>
        <p class="text-sm text-neutral-text-muted">Manajemen Persediaan Keperluan Barang Perusahaan Steel</p>
    </div>

    {{-- Nonaktifkan pengisian otomatis browser demi keamanan keamanan kredensial pengguna --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-5" autocomplete="off">
        @csrf
        
        {{-- Tampilkan error global jika percobaan login gagal --}}
        @if ($errors->any())
            <div class="p-3 mb-4 text-sm text-error bg-error/10 border border-error/20 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Username / Email Address -->
        <div class="space-y-1.5">
            <label for="username" class="text-sm font-medium text-neutral-text">Username / Email Akses</label>
            <input 
                id="username" 
                type="text" 
                name="username" 
                value="{{ old('username') }}"
                placeholder="Masukkan username atau email"
                autocomplete="off"
                required 
                autofocus
                class="w-full border @error('username') border-error @else border-neutral-border @enderror bg-transparent rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all"
            >
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-medium text-neutral-text">Kata Sandi</label>
                <button type="button" @click="$dispatch('open-confirm', { title: 'Lupa Kata Sandi?', message: 'Silakan hubungi Pihak Developer atau Super Admin untuk mengatur ulang kata sandi Anda.', type: 'primary', isAlert: true })" class="text-xs font-medium text-neutral-text hover:underline focus:outline-none cursor-pointer">Lupa Sandi?</button>
            </div>
            <input 
                id="password" 
                type="password" 
                name="password" 
                placeholder="Masukkan kata sandi"
                autocomplete="new-password"
                required 
                class="w-full border border-neutral-border bg-transparent rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all"
            >
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 rounded border-neutral-border text-black focus:ring-black dark:focus:ring-white bg-transparent">
            <label for="remember_me" class="ml-2 text-sm text-neutral-text-muted">
                Ingat Saya
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-black text-white dark:bg-white dark:text-black rounded-xl hover:opacity-90 text-sm font-medium transition-opacity cursor-pointer">
                Masuk ke Sistem
                <x-heroicon-o-arrow-right class="w-4 h-4" />
            </button>
        </div>
    </form>
    
    <div class="mt-8 text-center text-xs text-neutral-text-muted">
        &copy; {{ date('Y') }} JeWePe. Hak Cipta Dilindungi.
    </div>
</div>
@endsection


