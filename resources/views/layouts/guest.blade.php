<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isDark: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-bind:class="{ 'dark': isDark }" x-init="$watch('isDark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'JeWePe') }} - @yield('title', 'Masuk')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-neutral-bg text-neutral-text font-sans antialiased min-h-screen w-full flex items-center justify-center p-4 sm:p-8 relative overflow-hidden">

    <!-- Abstract Background Decor -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none flex justify-center items-center">
        <div class="absolute w-[600px] h-[600px] rounded-full bg-gradient-to-br from-neutral-200 to-transparent dark:from-neutral-800 opacity-20 blur-3xl -top-32 -left-32"></div>
        <div class="absolute w-[400px] h-[400px] rounded-full bg-gradient-to-bl from-neutral-200 to-transparent dark:from-neutral-800 opacity-20 blur-3xl -bottom-24 -right-24"></div>
    </div>

    <!-- Theme Toggle -->
    <div class="absolute top-6 right-6 z-50">
        <button @click="isDark = !isDark" class="p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5 transition-colors border border-transparent backdrop-blur-md bg-white/50 dark:bg-black/50">
            <x-heroicon-o-sun x-show="!isDark" class="w-5 h-5" />
            <x-heroicon-o-moon x-show="isDark" style="display: none;" class="w-5 h-5" />
        </button>
    </div>

    <main class="w-[400px] max-w-[90vw] z-10 relative shrink-0">
        @yield('content')
    </main>

    <!-- Global Confirmation Modal -->
    @include('components.ui.confirm-modal')

</body>
</html>
