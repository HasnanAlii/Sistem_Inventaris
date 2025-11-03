<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Data ATK (Alat Tulis Kantor)') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">

        <a href="{{ route('atks.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('atks.*') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-6 h-6"></i>
            List ATK
        </a>

        <a href="{{ route('logs.list') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('logs.*') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-lg' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-6 h-6"></i>
            Permintaan ATK
        </a>

    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header Tabel -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-amber-50 to-yellow-50 rounded-t-2xl shadow-sm">

                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="package" class="w-6 h-6 text-amber-600"></i>
                        Daftar ATK (Alat Tulis Kantor)
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">
                        <form method="GET" class="flex items-center gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
                                class="border rounded-full px-4 py-2 w-56 focus:ring-amber-500 focus:border-amber-500 text-sm"
                                autocomplete="off">

                            <button type="submit"
                                    class="flex items-center gap-2 bg-amber-600 text-white px-4 py-2 rounded-full font-medium 
                                        hover:bg-amber-700 hover:shadow-md transition-all duration-200">
                                Cari
                            </button>
                        </form>

                        {{-- Tombol Tambah (aktifkan jika dibutuhkan) --}}
                        {{-- @hasrole('petugas')
                        <a href="{{ route('atks.create') }}"
                            class="flex items-center gap-2 bg-amber-600 text-white px-5 py-2 rounded-xl font-medium 
                                   hover:bg-amber-700 hover:shadow-lg transition-all duration-200">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            Tambah ATK
                        </a>
                        @endhasrole --}}
                    </div>
                </div>

                <!-- ✅ Pesan sukses -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-700 bg-green-50 border border-green-200 rounded-lg shadow-sm text-base">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-base">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Kode</th>
                                <th class="px-5 py-3 text-left">Nama Barang</th>
                                <th class="px-5 py-3 text-center">Stok</th>
                                <th class="px-5 py-3 text-right">Harga</th>
                                <th class="px-5 py-3 text-center">Tanggal Masuk</th>
                                @hasrole('petugas')
                                <th class="px-5 py-3 text-center">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($atks as $atk)
                                <tr class="hover:bg-amber-50 transition duration-150">
                                    <td class="px-5 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $atk->kode_barang }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $atk->nama_barang }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2 {{ $atk->stok <= $atk->stok_minimum ? 'text-red-600 font-semibold' : '' }}">
                                            <span>{{ $atk->stok }}</span>
                                            @if($atk->stok <= $atk->stok_minimum)
                                                <span class="text-xs text-red-600">⚠️ Stok rendah</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-right text-gray-700">Rp {{ number_format($atk->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-5 py-3 text-center text-gray-600">{{ $atk->tanggal_masuk ->format('d/m/Y')}}</td>

                                    @hasrole('petugas')
                                    <td class="px-5 py-3 text-center">
                                        <div class="flex justify-center gap-3 flex-wrap">
                                            <a href="{{ route('atks.show', $atk) }}"
                                               class="text-blue-600 hover:text-blue-800 font-medium transition">Detail</a>
                                            <a href="{{ route('atks.edit', $atk) }}"
                                               class="text-yellow-600 hover:text-yellow-800 font-medium transition">Edit</a>
                                            <form action="{{ route('atks.destroy', $atk) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus ATK ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endhasrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-6">
                                        Tidak ada data ATK ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl text-base">
                    {{ $atks->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
