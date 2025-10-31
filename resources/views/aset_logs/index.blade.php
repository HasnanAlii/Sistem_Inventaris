<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Aset') }}
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
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- 📋 Tabel Log -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Aset</th>
                                <th class="px-4 py-2 border">Aksi</th>
                                <th class="px-4 py-2 border">Oleh</th>
                                <th class="px-4 py-2 border">Keterangan</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $log->aset->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 border capitalize">{{ $log->type }}</td>
                                    <td class="px-4 py-2 border">{{ $log->user->name ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $log->keterangan }}</td>
                                    <td class="px-4 py-2 border">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>

         
            </div>
        </div>
    </div>
</x-app-layout>
