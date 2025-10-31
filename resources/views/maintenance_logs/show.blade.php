<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Perbaikan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="w-full border border-gray-200 text-sm">
                    <tr><th class="p-2 text-left w-1/3">Aset</th><td class="p-2">{{ $maintenanceLog->aset->nama }}</td></tr>
                    <tr><th class="p-2">Tanggal</th><td class="p-2">{{ $maintenanceLog->tanggal }}</td></tr>
                    <tr><th class="p-2">Jenis Perbaikan</th><td class="p-2">{{ $maintenanceLog->jenis_perbaikan }}</td></tr>
                    <tr><th class="p-2">Biaya</th><td class="p-2">Rp{{ number_format($maintenanceLog->biaya, 0, ',', '.') }}</td></tr>
                    <tr><th class="p-2">Keterangan</th><td class="p-2">{{ $maintenanceLog->keterangan }}</td></tr>
                </table>

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('maintenance.index') }}" class="text-blue-600 hover:underline">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
