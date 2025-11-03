<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-8 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8 text-base">

        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold transition-all duration-200
                  {{ request()->routeIs('asets.*') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-6 h-6"></i>
            List Inventaris
        </a>

        @hasrole('petugas')
        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold transition-all duration-200
                  {{ request()->routeIs('maintenance.*') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-lg' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-6 h-6"></i>
            Perbaikan Aset
        </a>

        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold transition-all duration-200
                  {{ request()->routeIs('assessments.*') 
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-lg' 
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-6 h-6"></i>
            Penilaian Kelayakan
        </a>
        @endhasrole

        @role('pegawai')
        <a href="{{ route('aset_loans.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold transition-all duration-200
                  {{ request()->routeIs('aset_loans.*') 
                      ? 'bg-cyan-200 border-cyan-600 text-cyan-900 shadow-lg' 
                      : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-6 h-6"></i>
            Peminjaman Aset
        </a>
        @endhasrole

    </nav>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header & Filter -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-amber-50 to-yellow-50 rounded-t-2xl shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="package" class="w-6 h-6 text-amber-600"></i>
                        Daftar Aset Inventaris
                    </h3>

                    {{-- Form Filter --}}
                    <form method="GET" class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full sm:w-auto text-base">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari aset..." 
                            class="border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <select name="kategori_id" class="border-gray-300 pr-10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>

                        <select name="lokasi_id" class="border-gray-300 pr-10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            <option value="">Semua Lokasi</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                    {{ $lokasi->nama }}
                                </option>
                            @endforeach
                        </select>

                        <select name="kondisi" class="border-gray-300 pr-10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            <option value="">Semua Kondisi</option>
                            <option value="baru" {{ request('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>

                        <button type="submit" 
                            class="bg-amber-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-amber-700 transition shadow">
                            Cari
                        </button>
                    </form>
                </div>

                <!-- 📋 Tabel -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-base">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Nomor Inventaris</th>
                                <th class="px-5 py-3 text-left">Nama</th>
                                <th class="px-5 py-3 text-left">Kategori</th>
                                <th class="px-5 py-3 text-left">Lokasi</th>
                                <th class="px-5 py-3 text-left">Kondisi</th>
                                {{-- <th class="px-5 py-3 text-center">Umur</th> --}}
                                <th class="px-5 py-3 text-center">Tanggal Perolehan</th>
                                <th class="px-5 py-3 text-right">Harga</th>
                                @hasrole('petugas')
                                <th class="px-5 py-3 text-center">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @forelse ($asets as $aset)
                                <tr class="hover:bg-amber-50 transition duration-150">
                                    <td class="px-5 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4">{{ $aset->nomor_inventaris }}</td>
                                    <td class="px-5 py-4 font-semibold">{{ $aset->nama }}</td>
                                    <td class="px-5 py-4">{{ $aset->kategori->nama ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $aset->lokasi->nama ?? '-' }}</td>
                                    <td class="px-5 py-4 capitalize">{{ str_replace('_', ' ', $aset->kondisi) }}</td>
                                    {{-- <td class="px-5 py-4 text-center">{{ $aset->umur_ekonomis }} Bulan</td> --}}
                                    <td class="px-5 py-4 text-center">{{ $aset->tanggal_perolehan->format('d/m/Y') }}</td>
                                    <td class="px-5 py-4 text-right font-medium">Rp {{ number_format($aset->harga, 0, ',', '.') }}</td>

                                    @hasrole('petugas')
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center gap-4 text-base">
                                            <a href="{{ route('asets.show', $aset) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Lihat</a>
                                            <a href="{{ route('asets.edit', $aset) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">Edit</a>
                                            <button type="button" 
                                                    onclick="openDeleteModal('{{ route('asets.destroy', $aset) }}')" 
                                                    class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                        </div>
                                    </td>
                                    @endhasrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 py-6 text-base">Belum ada data aset.</td>
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
