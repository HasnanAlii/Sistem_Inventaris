<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pengadaan ATK') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-3 flex flex-wrap items-center gap-3 rounded-xl mb-8">
        <a href="{{ route('logs.atk') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('logs.atk') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-sm' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="clipboard" class="w-5 h-5"></i>
            Riwayat Permintaan ATK
        </a>

        <a href="{{ route('logs.aset') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('logs.aset') 
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-sm' 
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="package" class="w-5 h-5"></i>
            Riwayat Pengadaan Aset
        </a>

        <a href="{{ route('logs.addatk') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('logs.addatk') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-sm' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather="archive" class="w-5 h-5"></i>
            Riwayat Pengadaan ATK
        </a>
    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl border border-gray-100 overflow-hidden">

                <!-- Header Tabel -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-yellow-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="clock" class="w-5 h-5 text-amber-600"></i>
                        Riwayat Pengadaan ATK
                    </h3>
                    <a href="{{ route('atkprocurements.create') }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg shadow hover:bg-amber-700 transition font-medium">
                        <i data-feather="plus-circle" class="w-5 h-5"></i>
                        Tambah Pengadaan ATK
                    </a>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Nama Pengadaan</th>
                                <th class="px-4 py-3 text-left">Jumlah</th>
                                <th class="px-4 py-3 text-left">Biaya</th>
                                <th class="px-4 py-3 text-center">Tanggal Pengadaan</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($procurements as $item)
                                <tr class="hover:bg-amber-50 transition duration-150">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $item->nama_barang }}</td>
                                    <td class="px-4 py-3">{{ $item->jumlah }}</td>
                                    <td class="px-4 py-3">{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item->tanggal_pengadaan?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('atkprocurements.show', $item->id) }}"
                                           class="text-blue-600 hover:text-blue-800 font-medium">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-6">
                                        Belum ada riwayat pengadaan ATK.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    {{ $procurements->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
