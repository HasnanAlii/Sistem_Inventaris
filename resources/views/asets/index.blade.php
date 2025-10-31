<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Menu Navigasi Subpage -->
    <nav class="bg-white shadow-md border-b border-gray-200 px-6 py-3 flex items-center justify-start gap-4 rounded-lg mb-6">
        <!-- List Inventaris -->
        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('asets.*') ? 'bg-amber-200 border-amber-600 text-amber-900' : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-5 h-5"></i>
            <span>List Inventaris</span>
        </a>

        <!-- Riwayat Perbaikan -->
            @hasrole('petugas')

        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('maintenance.*') ? 'bg-green-200 border-green-600 text-green-900' : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-5 h-5"></i>
            <span>Riwayat Perbaikan</span>
        </a>

        <!-- Penilaian Kelayakan -->
        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('assessments.*') ? 'bg-blue-200 border-blue-600 text-blue-900' : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            <span>Penilaian Kelayakan</span>
        </a>
        @endhasrole

        <a href="{{ route('aset_loans.index') }}"
        class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                {{ request()->routeIs('aset_loans.*') ? 'bg-cyan-200 border-cyan-600 text-cyan-900' : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-5 h-5"></i>
            <span>Peminjaman Aset</span>
           </a>
    </nav>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                <!-- 🔍 Filter & Tambah -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200">
                    <form method="GET" class="flex flex-wrap sm:flex-nowrap gap-2 w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aset..." 
                               class="border rounded-lg px-3 py-2 w-full sm:w-auto focus:ring-blue-500 focus:border-blue-500">

                        <select name="kategori_id" class="border rounded-lg px-3 py-2 w-full sm:w-auto pr-10">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Filter
                        </button>
                    </form>
                    @hasrole('petugas')
                    <a href="{{ route('asets.create') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full sm:w-auto text-center">
                        + Tambah Aset
                    </a>
                    @endhasrole
                </div>

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Nomor Inventaris</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Kategori</th>
                                <th class="px-4 py-2 border">Lokasi</th>
                                <th class="px-4 py-2 border">Kondisi</th>
                                <th class="px-4 py-2 border text-center">Umur</th>
                                <th class="px-4 py-2 border">Tanggal Perolehan</th>
                                <th class="px-4 py-2 border text-right">Harga</th>
                              @hasrole('petugas')
                                <th class="px-4 py-2 border text-center w-48">Aksi</th>
                              @endhasrole

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($asets as $aset)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $aset->nomor_inventaris }}</td>
                                    <td class="px-4 py-2 border">{{ $aset->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $aset->kategori->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $aset->lokasi->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 border capitalize">{{ str_replace('_', ' ', $aset->kondisi) }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $aset->umur_ekonomis }} thn</td>
                                    <td class="px-4 py-2 border text-center">{{ $aset->tanggal_perolehan->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border text-right">Rp {{ number_format($aset->harga, 0, ',', '.') }}</td>
                                    @hasrole('petugas')
                                    <td class="px-4 py-2 border text-center">

                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('asets.show', $aset) }}" class="text-blue-600 hover:underline">Lihat</a>
                                            <a href="{{ route('asets.edit', $aset) }}" class="text-yellow-600 hover:underline">Edit</a>
                                            <button type="button" 
                                                    onclick="openDeleteModal('{{ route('asets.destroy', $aset) }}')" 
                                                    class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                              @endhasrole

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-gray-500">Tidak ada data aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200">
                    {{ $asets->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- 🗑️ Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-3">Hapus Aset?</h3>
            <p class="text-gray-600 mb-4">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end space-x-2">
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
