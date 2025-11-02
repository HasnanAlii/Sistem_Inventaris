<x-app-layout>
    {{-- 🏷️ Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            🏷️ {{ __('Detail Aset') }}
        </h2>
    </x-slot>

    <div class=" min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-8 border border-gray-200">

                {{-- 🧾 Informasi Aset --}}
                <div class="mb-8 border-b pb-5">
                    <h3 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
                        🧾 Informasi Aset
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail lengkap mengenai data aset berikut informasi utama terkait lokasi, kategori, dan kondisi.
                    </p>
                </div>

                <table class="w-full border-collapse text-base mb-8">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-3 text-gray-600 font-semibold">Nama Aset</th>
                            <td class="py-3 text-gray-900 font-medium">{{ $aset->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-semibold">Kategori</th>
                            <td class="py-3 text-gray-900">{{ $aset->kategori->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-semibold">Lokasi</th>
                            <td class="py-3 text-gray-900">{{ $aset->lokasi->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-semibold">Tanggal Perolehan</th>
                            <td class="py-3 text-gray-900">
                                {{ $aset->tanggal_perolehan ? $aset->tanggal_perolehan->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-semibold">Umur Ekonomis</th>
                            <td class="py-3 text-gray-900">{{ $aset->umur_ekonomis ?? '-' }} Tahun</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-semibold">Harga</th>
                            <td class="py-3 text-green-700 font-semibold text-lg">
                                Rp{{ number_format($aset->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-semibold">Kondisi</th>
                            <td class="py-3">
                                <span
                                    class="@if($aset->kondisi == 'baru') text-blue-600
                                            @elseif($aset->kondisi == 'baik') text-green-600
                                            @elseif($aset->kondisi == 'rusak_ringan') text-yellow-600
                                            @else text-red-600 @endif font-semibold capitalize text-base">
                                    {{ str_replace('_', ' ', $aset->kondisi) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- 🔧 Riwayat Perbaikan --}}
                <div class="mb-8 border-b pb-5">
                    <h3 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
                        🔧 Riwayat Perbaikan
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar perbaikan atau pemeliharaan yang pernah dilakukan terhadap aset ini.
                    </p>
                </div>

                @if($aset->maintenanceLogs->isEmpty())
                    <p class="text-gray-500 mb-6 text-base">Belum ada riwayat perbaikan untuk aset ini.</p>
                @else
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    <th class="px-5 py-3 text-left">#</th>
                                    <th class="px-5 py-3 text-left">Tanggal</th>
                                    <th class="px-5 py-3 text-left">Jenis Perbaikan</th>
                                    <th class="px-5 py-3 text-left">Biaya</th>
                                    <th class="px-5 py-3 text-left">Keterangan</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($aset->maintenanceLogs as $log)
                                    <tr class="hover:bg-blue-50 transition duration-150">
                                        <td class="px-5 py-3 text-gray-800">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-3 text-gray-800">{{ $log->tanggal->translatedFormat('d F Y') }}</td>
                                        <td class="px-5 py-3 text-gray-800">{{ $log->jenis_perbaikan ?? '-' }}</td>
                                        <td class="px-5 py-3 text-green-700 font-semibold">
                                            Rp{{ number_format($log->biaya, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-3 text-gray-800">{{ $log->keterangan ?? '-' }}</td>
                                        <td class="px-5 py-3 text-center space-x-3">
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

                {{-- 🔘 Tombol Navigasi --}}
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('asets.index') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-gray-900 text-base font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
