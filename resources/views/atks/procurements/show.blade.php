<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __('Detail Pengadaan ATK: ') . $procurement->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">

                {{-- 📌 Informasi Pengadaan --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                        📌 Informasi Pengadaan ATK
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail lengkap pengadaan ATK yang telah dilakukan.
                    </p>

                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div><strong>Nama Pengadaan:</strong> {{ $procurement->nama_barang }}</div>
                        <div><strong>Jumlah Barang:</strong> {{ $procurement->jumlah }}</div>
                        <div><strong>Biaya:</strong> Rp {{ number_format($procurement->biaya,0,',','.') }}</div>
                        <div><strong>Tanggal Pengadaan:</strong> {{ $procurement->tanggal_pengadaan ? $procurement->tanggal_pengadaan->format('d/m/Y') : '-' }}</div>
                    </div>
                </div>

                {{-- 📋 Daftar ATK --}}
                <div class="overflow-x-auto mb-6">
                    <h3 class="text-lg font-semibold text-blue-700 mb-4 flex items-center gap-2">
                        🗂 Daftar ATK
                    </h3>
                    <table class="min-w-full w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Kode Barang</th>
                                <th class="px-4 py-3 text-left">Nama Barang</th>
                                <th class="px-4 py-3 text-left">Kategori</th>
                                <th class="px-4 py-3 text-left">Harga Satuan</th>
                                <th class="px-4 py-3 text-left">Tanggal Masuk</th>
                                <th class="px-4 py-3 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($procurement->atks as $atk)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $atk->kode_barang }}</td>
                                    <td class="px-4 py-3">{{ $atk->nama_barang }}</td>
                                    <td class="px-4 py-3">{{ $atk->kategori->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($atk->harga_satuan ?? 0,0,',','.') }}</td>
                                    <td class="px-4 py-3">{{ $atk->tanggal_masuk ? $atk->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                                    <td class="px-4 py-3">{{ $atk->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-6">
                                        Belum ada ATK untuk pengadaan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Kembali --}}
                <div class="flex justify-end">
                    <a href="{{ route('logs.addatk') }}" 
                       class="px-5 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
