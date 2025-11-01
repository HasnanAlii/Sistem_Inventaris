<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="font-sans antialiased bg-sky-50 text-gray-800" x-data="{ sidebarOpen: false }" x-cloak>
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-30 w-64 bg-sky-100 text-gray-800 transform transition-transform duration-200 ease-in-out sm:translate-x-0 sm:static sm:inset-0 shadow-lg"
    >
        <!-- Header Sidebar -->
        <div class="flex items-center justify-center p-4 border-b border-sky-300 bg-white">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-16 w-auto rounded-full shadow-md p-1 px-10">
            </a>
        </div>

        <!-- Menu Sidebar -->
        <nav class="mt-6 px-3 space-y-1">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center gap-2 px-4 py-2 rounded-md hover:bg-sky-200 hover:text-sky-800 transition">
                <i data-feather="home" class="w-5 h-5"></i> {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('asets.index')" :active="request()->is('asets*')"
                class="flex items-center gap-2 px-4 py-2 rounded-md hover:bg-sky-200 hover:text-sky-800 transition">
                <i data-feather="layers" class="w-5 h-5"></i> {{ __('Inventaris') }}
            </x-nav-link>

            <x-nav-link :href="route('atks.index')" :active="request()->is('atks*')"
                class="flex items-center justify-between px-4 py-2 rounded-md hover:bg-sky-200 hover:text-sky-800 transition">
                <div class="flex items-center gap-2">
                    <i data-feather="archive" class="w-5 h-5"></i> {{ __('Barang (ATK)') }}
                </div>
                @if(isset($stokMenipis) && $stokMenipis > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $stokMenipis }}
                    </span>
                @endif
            </x-nav-link>
            @hasrole('petugas')
            <x-nav-link :href="route('logs.atk')" :active="request()->is('logs*')"
                class="flex items-center gap-2 px-4 py-2 rounded-md hover:bg-sky-200 hover:text-sky-800 transition">
                <i data-feather="clipboard" class="w-5 h-5"></i> {{ __('Riwayat') }}
            </x-nav-link>
            
            <x-nav-link :href="route('kategoris.index')" :active="request()->is('kategoris*')"
                class="flex items-center gap-2 px-4 py-2 rounded-md hover:bg-sky-200 hover:text-sky-800 transition">
                <i data-feather="grid" class="w-5 h-5"></i> {{ __('Kelola Kategori/Lokasi') }}
            </x-nav-link>    
            @endhasrole

           
        </nav>

        <!-- Footer Sidebar -->
        <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-sky-300 p-4">
            <div class="text-sm text-gray-600">
                <span class="block font-medium">{{ Auth::user()->name }}</span>
                <span class="text-sky-600">{{ Auth::user()->email }}</span>
            </div>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('profile.edit') }}"
                   class="flex-1 text-center text-sky-700 bg-sky-100 hover:bg-sky-200 py-1 rounded-md transition text-sm">
                   <i data-feather="user" class="inline w-4 h-4 mr-1"></i> Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full text-center text-red-600 bg-red-50 hover:bg-red-100 py-1 rounded-md transition text-sm">
                        <i data-feather="log-out" class="inline w-4 h-4 mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b border-sky-300 shadow-sm flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="sm:hidden text-sky-700 hover:text-sky-900">
                    ☰
                </button>
                @isset($header)
                    <h2 class="text-lg font-semibold text-sky-800">{{ $header }}</h2>
                @endisset
            </div>

        
        </header>

        <main class="flex-1 p-6 bg-sky-50 overflow-y-auto">
            <div class=" shadow-md rounded-xl p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<script>
    feather.replace();
</script>
@stack('scripts')

</body>
</html>
