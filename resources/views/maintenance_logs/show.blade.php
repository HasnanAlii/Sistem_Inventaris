<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 flex items-center gap-3">
            🧾 {{ __('Detail Riwayat Perbaikan Aset') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen ">
        <div class="max-w-5xl mx-auto sm:px-8 lg:px-10">
            <div class="bg-white rounded-2xl shadow-lg p-10 border border-gray-100">

                {{-- 🧩 Informasi Perbaikan --}}
                <div class="mb-8 border-b pb-5">
                    <h3 class="text-2xl font-semibold text-blue-700 flex items-center gap-3">
                        🧰 Informasi Perbaikan
                    </h3>
                    <p class="text-base text-gray-500 mt-2">
                        Detail lengkap riwayat perbaikan aset yang telah dilakukan.
                    </p>
                </div>

                <table class="w-full border-collapse text-base mb-10">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <th class="text-left w-1/3 py-4 text-gray-600 font-medium text-lg">Nama Aset</th>
                            <td class="py-4 text-gray-900 font-semibold text-lg">
                                {{ $maintenanceLog->aset->nama ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium text-lg">Tanggal Perbaikan</th>
                            <td class="py-4 text-gray-800 text-base">
                                {{ \Carbon\Carbon::parse($maintenanceLog->tanggal)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium text-lg">Jenis Perbaikan</th>
                            <td class="py-4 text-gray-800 text-base">
                                {{ $maintenanceLog->jenis_perbaikan ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium text-lg">Biaya</th>
                            <td class="py-4 text-green-700 font-bold text-lg">
                                @if($maintenanceLog->biaya)
                                    Rp{{ number_format($maintenanceLog->biaya, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-500 text-base">Tidak ada biaya</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium text-lg">Keterangan</th>
                            <td class="py-4 text-gray-800 text-base leading-relaxed">
                                {{ $maintenanceLog->keterangan ?? '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- 🔘 Tombol Navigasi --}}
                <div class="flex justify-between items-center mt-10">
                    <a href="{{ route('maintenance.index') }}"
                        class="flex items-center gap-3 text-gray-600 hover:text-gray-900 text-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    <a href="{{ route('maintenance.edit', $maintenanceLog->id) }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 text-lg font-medium transition shadow-md">
                        ✏️ Edit Data
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
