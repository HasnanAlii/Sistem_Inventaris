<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __('Detail Riwayat Perbaikan Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                        🧾 Informasi Perbaikan
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail lengkap riwayat perbaikan aset.
                    </p>
                </div>

                <table class="w-full border-collapse text-sm">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-3 text-gray-600 font-medium">Aset</th>
                            <td class="py-3 text-gray-800 font-semibold">{{ $maintenanceLog->aset->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Tanggal</th>
                            <td class="py-3 text-gray-800">
                                {{ \Carbon\Carbon::parse($maintenanceLog->tanggal)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Jenis Perbaikan</th>
                            <td class="py-3 text-gray-800">
                                {{ $maintenanceLog->jenis_perbaikan ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Biaya</th>
                            <td class="py-3 text-green-700 font-semibold">
                                @if($maintenanceLog->biaya)
                                    Rp{{ number_format($maintenanceLog->biaya, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-500">Tidak ada biaya</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Keterangan</th>
                            <td class="py-3 text-gray-800">
                                {{ $maintenanceLog->keterangan ?? '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('maintenance.index') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    <a href="{{ route('maintenance.edit', $maintenanceLog->id) }}"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 shadow-md transition">
                        ✏️ Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
