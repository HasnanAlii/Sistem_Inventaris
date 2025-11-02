<x-app-layout>
    {{-- 🧭 Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 flex items-center gap-3">
             {{ __('Detail Pengadaan Aset: ') . $asetLog->nama_barang }}
        </h2>
    </x-slot>

    {{-- 📄 Konten Utama --}}
    <div class="py-12 min-h-screen">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-10 border border-gray-200">

                {{-- 🧾 Informasi Pengadaan --}}
                <div class="mb-10 border-b pb-6">
                    <h3 class="text-2xl font-semibold text-blue-700 flex items-center gap-3">
                        📌 Informasi Pengadaan Aset
                    </h3>
                    <p class="text-base text-gray-500 mt-2">
                        Detail lengkap pengadaan aset yang telah dilakukan.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-4 mt-6 text-lg">
                        <div><strong class="text-gray-700">Nama Pengadaan:</strong> <span class="text-gray-900">{{ $asetLog->nama_barang }}</span></div>
                        <div><strong class="text-gray-700">Jumlah Barang:</strong> <span class="text-gray-900">{{ $asetLog->jumlah }}</span></div>
                        <div><strong class="text-gray-700">Biaya:</strong> <span class="text-green-700 font-semibold text-xl">Rp {{ number_format($asetLog->biaya,0,',','.') }}</span></div>
                        <div><strong class="text-gray-700">Tanggal Pengadaan:</strong> 
                            <span class="text-gray-900">{{ $asetLog->tanggal_pengadaan ? $asetLog->tanggal_pengadaan->format('d F Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- 📋 Daftar Aset --}}
                <div class="overflow-x-auto mb-10">
                    <h3 class="text-2xl font-semibold text-blue-700 mb-5 flex items-center gap-3">
                        🗂 Daftar Aset
                    </h3>
                    <table class="min-w-full w-full border border-gray-300 divide-y divide-gray-200 text-lg">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-base">
                            <tr>
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Nama Aset</th>
                                <th class="px-6 py-4 text-left">Nomor Inventaris</th>
                                <th class="px-6 py-4 text-left">Kategori</th>
                                <th class="px-6 py-4 text-left">Harga</th>
                                <th class="px-6 py-4 text-left">Tanggal Perolehan</th>
                                <th class="px-6 py-4 text-left">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($asetLog->asets as $aset)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $aset->nama }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $aset->nomor_inventaris }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $aset->kategori->nama ?? '-' }}</td>
                                    <td class="px-6 py-4 text-green-700 font-semibold">Rp {{ number_format($aset->harga,0,',','.') }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d F Y') : '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $aset->lokasi->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-8 text-lg">
                                        Belum ada aset untuk pengadaan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 🔘 Tombol Aksi --}}
                <div class="flex justify-between items-center mt-10">
                    <a href="{{ route('aset_logs.index') }}" 
                       class="flex items-center gap-2 text-gray-700 hover:text-gray-900 text-lg font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    <a href="{{ route('aset_logs.print', $asetLog->id) }}" 
                       target="_blank"
                       class="flex items-center gap-3 bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-semibold 
                              hover:bg-blue-700 hover:shadow-md transition-all duration-200">
                        <i data-feather="file-text" class="w-6 h-6"></i>
                        Cetak PDF
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
