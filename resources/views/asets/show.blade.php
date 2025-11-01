<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            🏷️ {{ __('Detail Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">

                {{-- 🧾 Informasi Aset --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                        🧾 Informasi Aset
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail lengkap mengenai data aset.
                    </p>
                </div>

                <table class="w-full border-collapse text-sm mb-8">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-3 text-gray-600 font-medium">Nama Aset</th>
                            <td class="py-3 text-gray-800 font-semibold">{{ $aset->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Kategori</th>
                            <td class="py-3 text-gray-800">{{ $aset->kategori->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Lokasi</th>
                            <td class="py-3 text-gray-800">{{ $aset->lokasi->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Tanggal Perolehan</th>
                            <td class="py-3 text-gray-800">
                                {{ $aset->tanggal_perolehan ? $aset->tanggal_perolehan->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Umur Ekonomis</th>
                            <td class="py-3 text-gray-800">{{ $aset->umur_ekonomis ?? '-' }} Tahun</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Harga</th>
                            <td class="py-3 text-green-700 font-semibold">
                                Rp{{ number_format($aset->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Kondisi</th>
                            <td class="py-3">
                                <span
                                    class="@if($aset->kondisi == 'baru') text-blue-600
                                            @elseif($aset->kondisi == 'baik') text-green-600
                                            @elseif($aset->kondisi == 'rusak_ringan') text-yellow-600
                                            @else text-red-600 @endif font-semibold capitalize">
                                    {{ str_replace('_', ' ', $aset->kondisi) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- 🔧 Riwayat Perbaikan --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                        🔧 Riwayat Perbaikan
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar perbaikan atau pemeliharaan yang pernah dilakukan terhadap aset ini.
                    </p>
                </div>

                @if($aset->maintenanceLogs->isEmpty())
                    <p class="text-gray-500 mb-6">Belum ada riwayat perbaikan untuk aset ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse text-sm divide-y divide-gray-200">
                            <thead class="bg-blue-50 text-blue-800 font-semibold">
                                <tr>
                                    <th class="px-4 py-2 text-left">#</th>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-left">Jenis Perbaikan</th>
                                    <th class="px-4 py-2 text-left">Biaya</th>
                                    <th class="px-4 py-2 text-left">Keterangan</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($aset->maintenanceLogs as $log)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $log->tanggal->translatedFormat('d F Y') }}</td>
                                        <td class="px-4 py-2">{{ $log->jenis_perbaikan ?? '-' }}</td>
                                        <td class="px-4 py-2 text-green-700 font-medium">
                                            Rp{{ number_format($log->biaya, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $log->keterangan ?? '-' }}</td>
                                        <td class="px-4 py-2 text-center space-x-2">
                                            <a href="{{ route('maintenance.show', $log->id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">Lihat</a>
                                            <a href="{{ route('maintenance.edit', $log->id) }}"
                                                class="text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                                            <form action="{{ route('maintenance.destroy', $log->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus riwayat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Tombol Navigasi --}}
                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('asets.index') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
