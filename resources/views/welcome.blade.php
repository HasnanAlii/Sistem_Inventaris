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
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>
<body class="bg-gradient-to-b from-[#F8FAFC] to-[#E6F0FF] text-gray-800 font-instrument-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-50 backdrop-blur-md bg-opacity-90">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-12 w-auto">
                <span class="font-bold text-lg text-gray-900">Dinas Arsip & Perpustakaan Cianjur</span>
            </div>
            {{-- <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition font-medium">Login</a>
                    @endauth
                @endif
            </div> --}}
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-24 text-center">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6 text-gray-900 leading-tight">Selamat Datang di Sistem Inventaris dan Kelayakan Aset</h1>
            <p class="text-gray-600 mb-10 text-lg lg:text-xl">Kelola aset tetap dan tidak tetap dengan cepat dan mudah untuk pegawai dan petugas internal.</p>
            <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-blue-600 text-white rounded-2xl shadow-lg hover:bg-blue-700 transition text-lg font-semibold">
                Masuk Sekarang
            </a>
        </div>
    </section>

    <!-- Fitur Section -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-16 text-gray-900">Fitur Utama</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-900">Inventaris Aset</h3>
                    <p class="text-gray-600">Catat dan pantau semua aset secara digital dengan cepat dan akurat.</p>
                </div>
                <div class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-900">Manajemen Stok ATK</h3>
                    <p class="text-gray-600">Kelola alat tulis kantor, cek stok, dan catat pemakaian dengan mudah.</p>
                </div>
                <div class="p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-900">Penilaian Kelayakan</h3>
                    <p class="text-gray-600">Tentukan aset layak pakai atau perlu diganti berdasarkan kondisi dan umur aset.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-8 mt-20">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Sistem Inventaris. Dinas Arsip dan Perpustakaan Kabupaten Cianjur.
        </div>
    </footer>

</body>
</html>
