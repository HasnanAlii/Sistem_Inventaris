<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-8">
        <!-- 🔔 NOTIFIKASI DETAIL -->
@if($stokMenipis > 0 || $asetRusak > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-2xl shadow-md mx-2">
        <h3 class="text-lg font-bold text-yellow-800 mb-3 flex items-center gap-2">
            <i data-feather="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
            Peringatan!
        </h3>

        @if($stokMenipis > 0)
            <p class="text-gray-700 font-semibold mb-2">📦 Barang ATK dengan stok menipis:</p>
            <ul class="list-disc list-inside text-gray-700 mb-4">
                @foreach($daftarStokMenipis as $atk)
                    <li>{{ $atk->nama_barang }} — Stok: {{ $atk->stok }} (Min: {{ $atk->stok_minimum }})</li>
                @endforeach
            </ul>
        @endif

        @if($asetRusak > 0)
            <p class="text-gray-700 font-semibold mb-2">💢 Aset yang sedang rusak:</p>
            <ul class="list-disc list-inside text-gray-700">
                @foreach($daftarAsetRusak as $aset)
                    <li>{{ $aset->nama }} — Kondisi: {{ $aset->kondisi }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif


        <!-- ========== KARTU STATISTIK ========== -->
        <div class="w-full flex flex-wrap gap-4 px-2">
            <div class="flex-1 bg-blue-100 p-6 rounded-3xl shadow-lg flex items-center justify-between min-w-[180px]">
                <div class="flex items-center gap-3">
                    <i data-feather="layers" class="w-8 h-8 text-blue-600"></i>
                    <h3 class="text-lg font-bold text-blue-800">Total Aset</h3>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalAset }}</p>
            </div>

            <div class="flex-1 bg-amber-100 p-6 rounded-3xl shadow-lg flex items-center justify-between min-w-[180px]">
                <div class="flex items-center gap-3">
                    <i data-feather="archive" class="w-8 h-8 text-amber-600"></i>
                    <h3 class="text-lg font-bold text-amber-700">Total ATK</h3>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalAtk }}</p>
            </div>

            <div class="flex-1 bg-green-100 p-6 rounded-3xl shadow-lg flex items-center justify-between min-w-[180px]">
                <div class="flex items-center gap-3">
                    <i data-feather="shopping-cart" class="w-8 h-8 text-green-600"></i>
                    <h3 class="text-lg font-bold text-green-700">Peminjaman</h3>
                </div>
                <p class="text-4xl font-extrabold text-gray-900">{{ $totalPeminjaman }}</p>
            </div>

            <div class="flex-[2] bg-red-100 p-8 rounded-3xl shadow-lg flex flex-col justify-center min-w-[300px]">
                <div class="flex items-center gap-3 mb-2">
                    <i data-feather="bell" class="w-8 h-8 text-red-600"></i>
                    <h3 class="text-xl font-bold text-red-700">Notifikasi</h3>
                </div>
                <p class="text-lg text-gray-900">
                    @if($stokMenipis > 0)
                        Terdapat {{ $stokMenipis }} aset yang stoknya menipis.
                    @else
                        Tidak ada notifikasi.
                    @endif
                </p>
            </div>
        </div>

        <!-- ========== TABEL PENGADAAN ========== -->
        <div class="flex flex-col lg:flex-row gap-6 px-2">
            <!-- 🔹 Tabel Pengadaan ATK -->
            <div class="flex-1 bg-white shadow-md rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-amber-700 mb-4">Pengadaan ATK Terbaru</h3>
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-amber-100 text-amber-900">
                        <tr>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Biaya</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengadaanAtk as $atk)
                            <tr class="border-b hover:bg-amber-50">
                                <td class="px-4 py-2">{{ $atk->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $atk->jumlah }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($atk->biaya, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    {{ $atk->tanggal_pengadaan ? $atk->tanggal_pengadaan->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('atkprocurements.show', $atk->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-3 text-gray-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔹 Tabel Pengadaan Aset -->
            <div class="flex-1 bg-white shadow-md rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-blue-700 mb-4">Pengadaan Aset Terbaru</h3>
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-blue-100 text-blue-900">
                        <tr>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Biaya</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengadaanAset as $aset)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $aset->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $aset->jumlah }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($aset->biaya, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    {{ $aset->tanggal_pengadaan ? $aset->tanggal_pengadaan->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('aset_logs.show', $aset->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-3 text-gray-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
