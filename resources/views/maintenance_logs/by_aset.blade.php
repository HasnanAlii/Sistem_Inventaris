<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Perbaikan Aset: ') . $aset->nama }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Jenis Perbaikan</th>
                            <th class="px-4 py-2 text-left">Biaya</th>
                            <th class="px-4 py-2 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $log->tanggal }}</td>
                            <td class="px-4 py-2">{{ $log->jenis_perbaikan }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($log->biaya, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $log->keterangan }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-gray-500">Belum ada riwayat perbaikan</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
