<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Riwayat Permintaan ATK') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi -->
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
    <!-- 🔹 Konten -->
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-end mb-4">
                        
                        <a href="{{ route('atks.take') }}"
                        class="flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition-all duration-200">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            Tambah Permintaan
                        </a>
                    </div>
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 text-left text-sm">
                        <thead class="bg-gray-100">
                            <tr class="text-gray-700">
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama Barang</th>
                                <th class="px-4 py-2 border">Pemohon</th>
                                <th class="px-4 py-2 border">Jumlah</th>
                                <th class="px-4 py-2 border">Tanggal Permintaan</th>
                                <th class="px-4 py-2 border">Status</th>
                                  @hasrole('petugas')
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            @endhasrole

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $log->atk->nama_barang ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $log->user->name ?? 'Tidak diketahui' }}</td>
                                    <td class="px-4 py-2 border">{{ $log->jumlah }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ $log->tanggal_permintaan ? $log->tanggal_permintaan->format('d/m/Y') : '-' }}                                    </td>
                                    <td class="px-4 py-2 border">
                                        @php
                                            $statusColors = [
                                                'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700',
                                                'Disetujui' => 'bg-green-100 text-green-700',
                                                'Ditolak' => 'bg-red-100 text-red-700',
                                                'Selesai' => 'bg-blue-100 text-blue-700',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$log->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $log->status }}
                                        </span>
                                    </td>
                                @hasrole('petugas')

                                 <td class="px-4 py-2 border text-center space-x-2">
                                <a href="{{ route('logs.atk.show', $log) }}"
                                class="text-blue-600 hover:underline font-medium">
                                    Detail
                                </a>
                            </td>
                            @endhasrole

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                        Belum ada permintaan ATK.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                    <!-- 🧾 Modal Pengembalian -->
                    <div id="returnModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md relative">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Form Pengembalian ATK</h3>

                            <form id="returnForm" method="POST" action="{{ route('logs.atk.return') }}">
                                @csrf
                                <input type="hidden" name="log_id" id="returnLogId">

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium mb-1">Nama Barang</label>
                                    <input type="text" id="returnAtkName" class="w-full border-gray-300 rounded-lg shadow-sm" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium mb-1">Jumlah yang dikembalikan</label>
                                    <input type="number" name="jumlah_dikembalikan" class="w-full border-gray-300 rounded-lg shadow-sm" min="1" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium mb-1">Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="closeReturnModal()" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium">Batal</button>
                                    <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium">Kembalikan</button>
                                </div>
                            </form>
                        </div>
                    </div>

<script>
    function openReturnModal(id, name) {
        document.getElementById('returnModal').classList.remove('hidden');
        document.getElementById('returnModal').classList.add('flex');
        document.getElementById('returnLogId').value = id;
        document.getElementById('returnAtkName').value = name;
    }

    function closeReturnModal() {
        document.getElementById('returnModal').classList.add('hidden');
        document.getElementById('returnModal').classList.remove('flex');
    }
</script>

                </div>

                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
