<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-3 flex flex-wrap items-center gap-3 rounded-xl mb-8">
        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('asets.*') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-sm' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-5 h-5"></i>
            List Inventaris
        </a>

        @hasrole('petugas')
        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('maintenance.*') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-sm' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-5 h-5"></i>
            Riwayat Perbaikan
        </a>

        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('assessments.*') 
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-sm' 
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            Penilaian Kelayakan
        </a>
        @endhasrole

        <a href="{{ route('aset_loans.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('aset_loans.*') 
                      ? 'bg-cyan-200 border-cyan-600 text-cyan-900 shadow-sm' 
                      : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-5 h-5"></i>
            Peminjaman Aset
        </a>
    </nav>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header & Filter -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-yellow-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="package" class="w-5 h-5 text-amber-600"></i>
                        Daftar Aset Inventaris
                    </h3>

                    {{-- @hasrole('petugas')
                     <a href="{{ route('asets.create') }}"
                        class="flex items-center gap-2 bg-amber-600 text-white px-4 py-2 rounded-lg font-medium 
                                hover:bg-amber-700 hover:shadow-lg transition-all duration-200">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            <span>Tambah Aset</span>
                        </a>
                    @endhasrole --}}
                </div>

                <!-- 🔍 Filter -->
                <div class="p-6 border-b border-gray-200 bg-white">
                    <form method="GET" class="flex flex-wrap md:flex-nowrap gap-3 items-center">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari aset..." 
                            class="border rounded-lg px-3 py-2 w-full md:w-auto focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                        <select name="kategori_id" class="border rounded-lg px-3 py-2 w-full md:w-auto focus:ring-2 focus:ring-blue-500 pr-10">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>

                        <select name="lokasi_id" class="border rounded-lg px-3 py-2 w-full md:w-auto focus:ring-2 focus:ring-blue-500 pr-10">
                            <option value="">Semua Lokasi</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                    {{ $lokasi->nama }}
                                </option>
                            @endforeach
                        </select>

                        <select name="kondisi" class="border rounded-lg px-3 py-2 w-full md:w-auto focus:ring-2 focus:ring-blue-500 pr-10">
                            <option value="">Semua Kondisi</option>
                            <option value="baru" {{ request('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>

                        <button type="submit" 
                            class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">
                            Filter
                        </button>
                    </form>
                </div>

                <!-- 📋 Tabel -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">Nomor Inventaris</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Kategori</th>
                                <th class="px-4 py-3 text-left">Lokasi</th>
                                <th class="px-4 py-3 text-left">Kondisi</th>
                                <th class="px-4 py-3 text-center">Umur</th>
                                <th class="px-4 py-3 text-center">Tanggal Perolehan</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                                @hasrole('petugas')
                                <th class="px-4 py-3 text-center">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($asets as $aset)
                                <tr class="hover:bg-amber-50 transition duration-150">
                                    <td class="px-4 py-3">{{ $aset->nomor_inventaris }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $aset->nama }}</td>
                                    <td class="px-4 py-3">{{ $aset->kategori->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $aset->lokasi->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $aset->kondisi) }}</td>
                                    <td class="px-4 py-3 text-center">{{ $aset->umur_ekonomis }} thn</td>
                                    <td class="px-4 py-3 text-center">{{ $aset->tanggal_perolehan->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format($aset->harga, 0, ',', '.') }}</td>

                                    @hasrole('petugas')
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('asets.show', $aset) }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat</a>
                                            <a href="{{ route('asets.edit', $aset) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">Edit</a>
                                            <button type="button" 
                                                    onclick="openDeleteModal('{{ route('asets.destroy', $aset) }}')" 
                                                    class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                        </div>
                                    </td>
                                    @endhasrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 py-6">Belum ada data aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    {{ $asets->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- 🗑️ Modal Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-3">Hapus Aset?</h3>
            <p class="text-gray-600 mb-4">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end gap-2">
                <button onclick="toggleModal(false)" class="px-4 py-2 border rounded-lg">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        feather.replace();

        function openDeleteModal(url) {
            document.getElementById('deleteForm').action = url;
            toggleModal(true);
        }
        function toggleModal(show) {
            const modal = document.getElementById('deleteModal');
            modal.classList.toggle('hidden', !show);
            modal.classList.toggle('flex', show);
        }
    </script>
</x-app-layout>
