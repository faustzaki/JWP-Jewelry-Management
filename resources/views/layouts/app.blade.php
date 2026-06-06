<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true, isDark: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-bind:class="{ 'dark': isDark }" x-init="$watch('isDark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'JeWePe') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine/Livewire scripts will be injected here if Livewire is used -->
    @livewireStyles
    {{-- Terapkan kelas tema gelap di awal pemuatan dokumen untuk mencegah efek kedipan flash putih --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-neutral-bg text-neutral-text font-sans antialiased h-screen flex overflow-hidden">
    
    {{-- Aside menu navigasi utama dengan dukungan responsive toggler berbasis Alpine.js --}}
    <aside 
        x-bind:class="sidebarOpen ? 'w-64' : 'w-20'" 
        class="transition-all duration-300 ease-in-out border-r border-neutral-border bg-neutral-surface flex-shrink-0 h-full flex flex-col"
    >
        <div class="h-16 flex items-center justify-between px-4 border-b border-neutral-border">
            <span x-show="sidebarOpen" class="font-heading text-xl">JeWePe</span>
            <span x-show="!sidebarOpen" class="font-heading text-xl mx-auto">JWP</span>
            <button @click="sidebarOpen = !sidebarOpen" class="p-1 hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-colors">
                <x-heroicon-o-bars-3 class="w-5 h-5" />
            </button>
        </div>
        
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto overflow-x-hidden whitespace-nowrap">
            <a href="{{ route('dashboard') }}" class="flex items-center w-full justify-start px-3 py-2 text-sm font-medium rounded-md hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ request()->routeIs('dashboard') ? 'bg-black/5 dark:bg-white/10 ' : '' }}">
                <x-heroicon-o-home class="w-5 h-5 mr-3 shrink-0" />
                <span x-show="sidebarOpen">Dashboard</span>
            </a>
            
            <div class="pt-6 pb-2" x-show="sidebarOpen" x-transition>
                <p class="text-[12px] text-neutral-text-muted font-semibold">PERSEDIAAN</p>
            </div>
            <div class="pt-6 pb-2 text-center" x-show="!sidebarOpen" x-transition>
                <div class="h-px bg-neutral-border w-8 mx-auto"></div>
            </div>
            
            <a href="{{ route('persediaan.index') }}" class="flex items-center w-full justify-start px-3 py-2 text-sm font-medium rounded-md hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ request()->routeIs('persediaan.index') ? 'bg-black/5 dark:bg-white/10 ' : '' }}">
                <x-heroicon-o-archive-box class="w-5 h-5 mr-3 shrink-0" />
                <span x-show="sidebarOpen">Stok Persediaan</span>
            </a>
            <a href="{{ route('persediaan.masuk.index') }}" class="flex items-center w-full justify-start px-3 py-2 text-sm font-medium rounded-md hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ request()->routeIs('persediaan.masuk.*') ? 'bg-black/5 dark:bg-white/10 ' : '' }}">
                <x-heroicon-o-arrow-down class="w-5 h-5 mr-3 shrink-0" />
                <span x-show="sidebarOpen">Barang Masuk</span>
            </a>
            <a href="{{ route('persediaan.keluar.index') }}" class="flex items-center w-full justify-start px-3 py-2 text-sm font-medium rounded-md hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ request()->routeIs('persediaan.keluar.*') ? 'bg-black/5 dark:bg-white/10 ' : '' }}">
                <x-heroicon-o-arrow-up class="w-5 h-5 mr-3 shrink-0" />
                <span x-show="sidebarOpen">Barang Keluar</span>
            </a>
            
            <div class="pt-6 pb-2" x-show="sidebarOpen" x-transition>
                <p class="text-[12px] text-neutral-text-muted font-semibold">MASTER DATA</p>
            </div>
            <div class="pt-6 pb-2 text-center" x-show="!sidebarOpen" x-transition>
                <div class="h-px bg-neutral-border w-8 mx-auto"></div>
            </div>
            
            <a href="{{ route('master-data.index') }}" class="flex items-center w-full justify-start px-3 py-2 text-sm font-medium rounded-md hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ request()->routeIs('master-data.index') ? 'bg-black/5 dark:bg-white/10 ' : '' }}">
                <x-heroicon-o-cog-6-tooth class="w-5 h-5 mr-3 shrink-0" />
                <span x-show="sidebarOpen">Master Data</span>
            </a>
            
            <div class="pt-6 pb-2" x-show="sidebarOpen" x-transition>
                <p class="text-[12px] text-neutral-text-muted font-semibold">LAPORAN</p>
            </div>
            <div class="pt-6 pb-2 text-center" x-show="!sidebarOpen" x-transition>
                <div class="h-px bg-neutral-border w-8 mx-auto"></div>
            </div>
            
            <a href="{{ route('laporan.index') }}" class="flex items-center w-full justify-start px-3 py-2 text-sm font-medium rounded-md hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ request()->routeIs('laporan.index') ? 'bg-black/5 dark:bg-white/10 ' : '' }}">
                <x-heroicon-o-document-chart-bar class="w-5 h-5 mr-3 shrink-0" />
                <span x-show="sidebarOpen">Laporan Sirkulasi</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 h-full relative bg-neutral-bg overflow-y-auto">
        {{-- Sticky header dengan efek glassmorphism untuk menyajikan nama halaman dan aksi global --}}
        <header class="sticky top-0 z-40 shrink-0 w-full h-16 border-b border-white/50 dark:border-white/10 backdrop-blur-[20px] bg-white/75 dark:bg-black/75 flex items-center justify-between px-8">
            <div>
                <!-- Page Title -->
                <h2 class="text-xl font-heading">
                    @yield('title', 'Dashboard')
                </h2>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <button @click="isDark = !isDark" class="p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5 transition-colors border border-transparent">
                    <!-- Sun icon for light mode -->
                    <x-heroicon-o-sun x-show="!isDark" class="w-5 h-5" />
                    <!-- Moon icon for dark mode -->
                    <x-heroicon-o-moon x-show="isDark" style="display: none;" class="w-5 h-5" />
                </button>

                <!-- User Name & Profile -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-neutral-text leading-tight">{{ auth()->user()->nama_lengkap }}</p>
                        <p class="text-xs text-neutral-text-muted">{{ auth()->user()->role }}</p>
                    </div>
                    <a href="{{ route('profil') }}" class="w-9 h-9 rounded-full bg-neutral-200 dark:bg-neutral-800 flex items-center justify-center border border-neutral-border hover:bg-black/5 dark:hover:bg-white/5 transition-colors cursor-pointer overflow-hidden" title="Lihat Profil">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="{{ auth()->user()->nama_lengkap }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama_lengkap) }}&background=0D8ABC&color=fff" alt="{{ auth()->user()->nama_lengkap }}" class="w-full h-full object-cover">
                        @endif
                    </a>
                </div>
                
                <!-- Logout Form & Button -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <button @click="$dispatch('open-confirm', { title: 'Konfirmasi Keluar', message: 'Apakah Anda yakin ingin keluar dari sistem?', type: 'danger', onConfirm: () => document.getElementById('logout-form').submit() })" class="w-9 h-9 rounded-full bg-error/10 flex items-center justify-center border border-error/20 hover:bg-error/20 transition-colors cursor-pointer" title="Keluar">
                    <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 text-error" />
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    <!-- Toast Container (Placeholder for original toast component) -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

    @include('components.ui.confirm-modal')
    @livewireScripts
</body>
</html>
