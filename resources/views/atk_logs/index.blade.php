<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Riwayat Permintaan ATK') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">

        <a href="{{ route('logs.atk') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('logs.atk') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-lg' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="clipboard" class="w-6 h-6"></i>
            Riwayat Permintaan ATK
        </a>

        <a href="{{ route('logs.aset') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('logs.aset') 
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-lg' 
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="package" class="w-6 h-6"></i>
            Riwayat Pengadaan Aset
        </a>

        <a href="{{ route('logs.addatk') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('logs.addatk') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather="archive" class="w-6 h-6"></i>
            Riwayat Pengadaan ATK
        </a>
    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header Tabel -->
           <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200 
            bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-2xl shadow-sm">
            <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i data-feather="clipboard" class="w-6 h-6 text-green-600"></i>
                Riwayat Permintaan ATK
            </h3>
            <a href="{{ route('logs.atk.pdf') }}" target="_blank"
            class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-sm">
                <i data-feather="printer" class="w-4 h-4"></i>
                Cetak PDF
            </a>
        </div>


                <!-- ✅ Pesan Sukses -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-700 bg-green-50 border border-green-200 rounded-lg shadow-sm text-base">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- 📋 Tabel Riwayat -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-base">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Nama Barang</th>
                                <th class="px-5 py-3 text-left">Pemohon</th>
                                <th class="px-5 py-3 text-center">Jumlah</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-center">Tanggal Permintaan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $log->atk->nama_barang ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $log->user->name ?? 'Tidak diketahui' }}</td>
                                    <td class="px-5 py-3 text-center text-gray-700">{{ $log->jumlah }}</td>
                                    <td class="px-5 py-3 text-center">
                                        @php
                                            $statusColors = [
                                                'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                                'Disetujui' => 'bg-green-100 text-green-800',
                                                'Ditolak' => 'bg-red-100 text-red-800',
                                                'Selesai' => 'bg-blue-100 text-blue-800',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$log->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $log->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-center text-gray-600">
                                        {{ $log->tanggal_permintaan ? $log->tanggal_permintaan->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-6">
                                        Belum ada permintaan ATK.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 📄 Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl text-base">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
