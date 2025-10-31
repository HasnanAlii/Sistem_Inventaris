<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Riwayat Permintaan ATK') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Subpage -->
    <nav class="bg-white shadow-md border-b border-gray-200 px-6 py-3 flex items-center justify-start gap-4 rounded-lg mb-6">
        <!-- Riwayat Permintaan ATK -->
        <a href="{{ route('logs.atk') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('logs.atk') ? 'bg-green-200 border-green-600 text-green-900' : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="clipboard" class="w-5 h-5"></i>
            <span>Riwayat Permintaan ATK</span>
        </a>

        <!-- Riwayat Pengadaan Aset -->
        <a href="{{ route('logs.aset') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('logs.aset') ? 'bg-blue-200 border-blue-600 text-blue-900' : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="package" class="w-5 h-5"></i>
            <span>Riwayat Pengadaan Aset</span>
        </a>

          <a href="{{ route('logs.addatk') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('logs.addatk') ? 'bg-yellow-200 border-yellow-600 text-yellow-900' : 'border-yellow-400 text-yellow-700 bg-yellow-50 hover:bg-yellow-100 hover:border-yellow-500 hover:text-yellow-800' }}">
            <i data-feather="package" class="w-5 h-5"></i>
            <span>Riwayat Pengadaan ATK</span>
        </a>
    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left border border-gray-200 rounded-lg text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama Barang</th>
                                <th class="px-4 py-2 border">Pemohon</th>
                                <th class="px-4 py-2 border">Jumlah</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Tanggal Permintaan</th>
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
                                    <td class="px-4 py-2 border text-center">
                                        {{ $log->tanggal_permintaan ? $log->tanggal_permintaan->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                        Belum ada permintaan ATK.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
