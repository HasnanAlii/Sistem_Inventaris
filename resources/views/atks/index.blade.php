<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data ATK (Alat Tulis Kantor)') }}
        </h2>
    </x-slot>

    <!-- 🔹 Menu Navigasi Subpage -->
    <nav class="bg-white shadow-md border-b border-gray-200 px-6 py-3 flex items-center justify-start gap-4 rounded-lg mb-6">
        <!-- List ATK -->
        <a href="{{ route('atks.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('atks.*') ? 'bg-amber-200 border-amber-600 text-amber-900' : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather="package" class="w-5 h-5"></i>
            <span>List ATK</span>
        </a>

        <!-- Permintaan ATK -->
        <a href="{{ route('logs.list') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('logs.*') ? 'bg-green-200 border-green-600 text-green-900' : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-5 h-5"></i>
            <span>Permintaan ATK</span>
        </a>
    </nav>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                <!-- 🔍 Filter & Tambah -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200">
                    <form method="GET" class="flex flex-wrap sm:flex-nowrap gap-2 w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." 
                               class="border rounded-lg px-3 py-2 w-full sm:w-auto focus:ring-blue-500 focus:border-blue-500">

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Cari
                        </button>
                    </form>

                    @hasrole('petugas')
                    <a href="{{ route('atks.create') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full sm:w-auto text-center">
                        + Tambah ATK
                    </a>
                    @endhasrole

                </div>

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Kode</th>
                                <th class="px-4 py-2 border">Nama Barang</th>
                                <th class="px-4 py-2 border">Stok</th>
                                <th class="px-4 py-2 border text-right">Harga</th>
                                <th class="px-4 py-2 border">Tanggal Masuk</th>
                                @hasrole('petugas')
                                <th class="px-4 py-2 border text-center w-48">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($atks as $atk)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $atk->kode_barang }}</td>
                                    <td class="px-4 py-2 border">{{ $atk->nama_barang }}</td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex items-center space-x-2 {{ $atk->stok <= $atk->stok_minimum ? 'text-red-600 font-bold' : '' }}">
                                            <span>{{ $atk->stok }}</span>
                                            @if($atk->stok <= $atk->stok_minimum)
                                                <span class="text-xs text-red-600">⚠️ Stok hampir habis!</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 border text-right">Rp {{ number_format($atk->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border">{{ $atk->tanggal_masuk }}</td>
                                      @hasrole('petugas')

                                    <td class="px-4 py-2 border text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('atks.show', $atk) }}" class="text-blue-600 hover:underline">Lihat</a>
                                            <a href="{{ route('atks.edit', $atk) }}" class="text-yellow-600 hover:underline">Edit</a>
                                            <button type="button" 
                                                    onclick="openDeleteModal('{{ route('atks.destroy', $atk) }}')" 
                                                    class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                    @endhasrole

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada data ATK.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200">
                    {{ $atks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- 🗑️ Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-3">Hapus ATK?</h3>
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
