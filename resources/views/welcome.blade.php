<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Inventaris') }}</title>
    
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/Logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/Logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('storage/Logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['"Instrument Sans"', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-gradient-to-b from-white to-[#E6F0FF] text-gray-800 font-sans antialiased">

    <nav class="sticky top-0 bg-white shadow-sm z-50 backdrop-blur-md bg-opacity-90">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="font-bold text-lg text-gray-900 hidden sm:block">Dinas Arsip & Perpustakaan Cianjur</span>
            </div>
            <a href="{{ route('login') }}" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition font-medium text-sm">
                Login
            </a>
        </div>
    </nav>

    <section class="pt-24 pb-32">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 grid md:grid-cols-2 gap-16 items-center">
            
            <div class="text-center md:text-left">
                <h1 class="text-5xl lg:text-6xl font-bold mb-6 text-gray-900 leading-tight">
                    Sistem Inventaris & Kelayakan Aset
                </h1>
                <p class="text-gray-600 mb-10 text-lg lg:text-xl">
                    Selamat datang! Kelola aset tetap dan tidak tetap dengan cepat dan mudah untuk pegawai dan petugas internal.
                </p>
                <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-xl transition text-lg font-semibold">
                    Masuk Sekarang
                </a>
            </div>

            <div class="relative hidden md:block">
                <div class="bg-white rounded-2xl shadow-2xl p-4 border border-gray-100 transform rotate-3 hover:rotate-2 transition-transform">
                    <div class="flex items-center gap-1.5 mb-3">
                        <div class="w-3.5 h-3.5 rounded-full bg-red-400"></div>
                        <div class="w-3.5 h-3.5 rounded-full bg-yellow-400"></div>
                        <div class="w-3.5 h-3.5 rounded-full bg-green-400"></div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="bg-gray-200 h-4 rounded w-1/3 mb-3 animate-pulse"></div>
                        <div class="bg-gray-200 h-10 rounded w-full mb-4 animate-pulse"></div>
                        <div class="bg-gray-200 h-32 rounded w-full animate-pulse"></div>
                    </div>
                </div>
                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-blue-200 rounded-full opacity-30 -z-10 blur-2xl"></div>
            </div>

        </div>
    </section>

 

    <section class="pt-12 pb-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-16 text-gray-900">Fitur Utama</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                <div class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-900">Inventaris Aset</h3>
                    <p class="text-gray-600">Catat dan pantau semua aset secara digital dengan cepat dan akurat.</p>
                </div>
                
                <div class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25c.621 0 1.125.504 1.125 1.125v3.375c0 .621-.504 1.125-1.125 1.125h-1.5c-.621 0-1.125-.504-1.125-1.125v-3.375c0-.621.504-1.125 1.125-1.125h1.5zM17.625 9.75l-6.75 6.75m0 0l6.75 6.75m-6.75-6.75L10.875 3" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-900">Manajemen Stok ATK</h3>
                    <p class="text-gray-600">Kelola alat tulis kantor, cek stok, dan catat pemakaian dengan mudah.</p>
                </div>
                
                <div class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-900">Penilaian Kelayakan</h3>
                    <p class="text-gray-600">Tentukan aset layak pakai atau perlu diganti berdasarkan kondisi dan umur aset.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t py-12">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <div class="flex flex-col items-center gap-4 mb-6">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-10 w-auto">
                <span class="font-semibold text-gray-700">Dinas Arsip dan Perpustakaan Kabupaten Cianjur</span>
            </div>
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Sistem Inventaris. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer>

</body>
</html>