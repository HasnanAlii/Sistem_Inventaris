<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Riwayat Permintaan ATK') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">
        @hasrole('petugas')
        <a href="{{ route('atks.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('atks.*') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-6 h-6"></i>
            List ATK
        </a>
        @endhasrole

        <a href="{{ route('logs.list') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('logs.*') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-lg' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-6 h-6"></i>
            Permintaan ATK
        </a>

    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-2xl shadow-sm">

                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="clock" class="w-6 h-6 text-green-600"></i>
                        Riwayat Permintaan ATK
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('atks.take') }}"
                           class="flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-xl font-medium 
                           hover:bg-green-700 hover:shadow-md transition-all duration-200">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            Tambah Permintaan
                        </a>
                    </div>
                </div>

                <!-- ✅ Pesan sukses -->
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
                                <th class="px-5 py-3 text-left">Nama Barang</th>
                                <th class="px-5 py-3 text-left">Pemohon</th>
                                <th class="px-5 py-3 text-center">Jumlah</th>
                                <th class="px-5 py-3 text-center">Tanggal Permintaan</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                @hasrole('petugas')
                                <th class="px-5 py-3 text-center">Aksi</th>
                                @endhasrole
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $log->atk->nama_barang ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $log->user->name ?? 'Tidak diketahui' }}</td>
                                    <td class="px-5 py-3 text-center text-gray-700">{{ $log->jumlah }}</td>
                                    <td class="px-5 py-3 text-center text-gray-600">
                                        {{ $log->tanggal_permintaan ? $log->tanggal_permintaan->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-3 text-center">
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
                                    <td class="px-5 py-3 text-center">
                                        <a href="{{ route('logs.atk.show', $log) }}"
                                           class="text-blue-600 hover:text-blue-800 font-medium transition">
                                            Detail
                                        </a>
                                    </td>
                                    @endhasrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-6 text-base">
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
