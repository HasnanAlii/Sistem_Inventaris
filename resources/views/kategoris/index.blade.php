<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kategori Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Menu Navigasi Subpage -->
    <nav class="bg-white shadow-md border-b border-gray-200 px-6 py-3 flex items-center justify-start gap-4 rounded-lg mb-6">
        <!-- Kategori -->
        <a href="{{ route('kategoris.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('kategoris.*') ? 'bg-blue-200 border-blue-600 text-blue-900' : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="layers" class="w-5 h-5"></i>
            <span>Kategori</span>
        </a>

        <!-- Lokasi -->
        <a href="{{ route('lokasis.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('lokasis.*') ? 'bg-purple-200 border-purple-600 text-purple-900' : 'border-purple-400 text-purple-700 bg-purple-50 hover:bg-purple-100 hover:border-purple-500 hover:text-purple-800' }}">
            <i data-feather="map-pin" class="w-5 h-5"></i>
            <span>Lokasi</span>
        </a>
    </nav>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                <!-- 🔹 Tambah Kategori -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200">
                    @hasrole('petugas')
                    <a href="{{ route('kategoris.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 w-full sm:w-auto text-center">
                        + Tambah Kategori
                    </a>
                    @endhasrole

                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded w-full sm:w-auto">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Kode</th>
                                <th class="px-4 py-2 border">Deskripsi</th>
                                @hasrole('petugas')
                                <th class="px-4 py-2 border text-center w-48">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $i => $kategori)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $kategori->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $kategori->kode }}</td>
                                    <td class="px-4 py-2 border">{{ $kategori->deskripsi ?? '-' }}</td>
                                    @hasrole('petugas')
                                    <td class="px-4 py-2 border text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('kategoris.edit', $kategori) }}" class="text-yellow-600 hover:underline">Edit</a>
                                            <button type="button" 
                                                    onclick="openDeleteModal('{{ route('kategoris.destroy', $kategori) }}')" 
                                                    class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                    @endhasrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- 🗑️ Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-3">Hapus Kategori?</h3>
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
