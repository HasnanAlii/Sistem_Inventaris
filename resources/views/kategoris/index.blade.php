<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Data Kategori Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">
        <a href="{{ route('kategoris.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('kategoris.*')
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg'
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather="layers" class="w-6 h-6"></i>
            Kategori
        </a>

        <a href="{{ route('lokasis.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('lokasis.*')
                      ? 'bg-purple-200 border-purple-600 text-purple-900 shadow-lg'
                      : 'border-purple-400 text-purple-700 bg-purple-50 hover:bg-purple-100 hover:border-purple-500 hover:text-purple-800' }}">
            <i data-feather="map-pin" class="w-6 h-6"></i>
            Lokasi
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
                        <i data-feather="layers" class="w-6 h-6 text-amber-600"></i>
                        Daftar Kategori Aset
                    </h3>

                    @hasrole('petugas')
                    <a href="{{ route('kategoris.create') }}"
                       class="flex items-center gap-2 bg-amber-600 text-white px-4 py-2 rounded-lg font-medium 
                       hover:bg-amber-700 hover:shadow-md transition-all duration-200">
                        <i data-feather="plus-circle" class="w-5 h-5"></i>
                        Tambah Kategori
                    </a>
                    @endhasrole
                </div>

                <!-- ✅ Pesan Sukses -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-800 bg-green-50 border border-green-200 rounded-lg shadow-sm text-base">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-base">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Nama Kategori</th>
                                <th class="px-5 py-3 text-left">Kode</th>
                                <th class="px-5 py-3 text-left">Deskripsi</th>
                                @hasrole('petugas')
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($kategoris as $i => $kategori)
                                <tr class="hover:bg-amber-50 transition duration-150">
                                    <td class="px-5 py-3 font-medium text-gray-800">
                                        {{ $i + 1 + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}
                                    </td>
                                    <td class="px-5 py-3 text-gray-700">{{ $kategori->nama }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $kategori->kode }}</td>
                                    <td class="px-5 py-3 text-gray-600">{{ $kategori->deskripsi ?? '-' }}</td>

                                    @hasrole('petugas')
                                    <td class="px-5 py-3 text-center flex justify-center gap-3">
                                        <a href="{{ route('kategoris.edit', $kategori) }}"
                                           class="text-yellow-600 hover:text-yellow-800 font-medium transition">Edit</a>
                                        <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endhasrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-6">
                                        Belum ada data kategori aset.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 📄 Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl text-base">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
