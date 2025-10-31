<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Aset') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Info Aset --}}
                <h3 class="text-lg font-semibold mb-4">Informasi Aset</h3>
                <table class="w-full border border-gray-200 text-sm mb-6">
                    <tr>
                        <th class="p-2 text-left w-1/3">Nama</th>
                        <td class="p-2">{{ $aset->nama }}</td>
                    </tr>
                    <tr>
                        <th class="p-2 text-left">Kategori</th>
                        <td class="p-2">{{ $aset->kategori->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="p-2 text-left">Lokasi</th>
                        <td class="p-2">{{ $aset->lokasi->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="p-2 text-left">Tanggal Perolehan</th>
                        <td class="p-2">
                                {{ $aset->tanggal_perolehan ? $aset->tanggal_perolehan->format('d-m-Y') : '-' }}
                            </td>

                    </tr>
                    <tr>
                        <th class="p-2 text-left">Umur Ekonomis</th>
                        <td class="p-2">{{ $aset->umur_ekonomis ?? '-' }} Tahun</td>
                    </tr>
                </table>

                {{-- Riwayat Perbaikan --}}
                <h3 class="text-lg font-semibold mb-4">Riwayat Perbaikan</h3>
                @if($aset->maintenanceLogs->isEmpty())
                    <p class="text-gray-500 mb-4">Belum ada riwayat perbaikan untuk aset ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">#</th>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-left">Jenis Perbaikan</th>
                                    <th class="px-4 py-2 text-left">Biaya</th>
                                    <th class="px-4 py-2 text-left">Keterangan</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aset->maintenanceLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $log->tanggal->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">{{ $log->jenis_perbaikan ?? '-' }}</td>
                                    <td class="px-4 py-2">Rp{{ number_format($log->biaya, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $log->keterangan ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center space-x-1">
                                        <a href="{{ route('maintenance.show', $log->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                                        <a href="{{ route('maintenance.edit', $log->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('maintenance.destroy', $log->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('asets.index') }}" class="text-blue-600 hover:underline">Kembali ke daftar aset</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
