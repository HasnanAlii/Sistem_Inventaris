<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight">
            {{ __('Dashboard Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-8 px-2">

        <!-- 👋 NOTIFIKASI SELAMAT DATANG -->
        <div id="welcome-alert" class="bg-green-100 border-l-4 border-green-500 p-4 rounded-2xl shadow-md flex justify-between items-start">
            <div class="flex items-center gap-3">
                <i data-feather="smile" class="w-6 h-6 text-green-600"></i>
                <div>
                    <h3 class="font-semibold text-green-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-700 text-sm mt-1">Semoga harimu menyenangkan 🌟</p>
                </div>
            </div>
            <button onclick="document.getElementById('welcome-alert').style.display='none'"
                class="text-green-600 hover:text-green-800 font-bold text-xl leading-none px-2">×</button>
        </div>

        <!-- 🔔 NOTIFIKASI PEMINJAMAN -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-2xl shadow-md">
            <div class="flex items-center gap-3">
                <i data-feather="bell" class="w-6 h-6 text-yellow-600"></i>
                <h3 class="font-semibold text-yellow-800">Notifikasi</h3>
            </div>
            <p class="mt-2 text-gray-800">
                @if($belumDikembalikan > 0)
                    Anda memiliki <strong>{{ $belumDikembalikan }}</strong> aset yang belum dikembalikan.
                @else
                    Tidak ada aset yang perlu dikembalikan saat ini.
                @endif
            </p>
        </div>

        <!-- 📦 TABEL PEMINJAMAN ASET & PERMINTAAN ATK -->
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- 🔹 Tabel Peminjaman Aset -->
            <div class="flex-1 bg-white shadow-md rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-blue-700 mb-4">Riwayat Peminjaman Aset</h3>
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-blue-100 text-blue-900">
                        <tr>
                            <th class="px-4 py-2">Nama Aset</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Tanggal Pinjam</th>
                            <th class="px-4 py-2">Tanggal Kembali</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamanAset as $loan)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $loan->aset->nama ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $loan->jumlah }}</td>
                                <td class="px-4 py-2">{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">
                                    {{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded-lg text-xs font-semibold
                                        {{ $loan->status == 'Belum Dikembalikan' ? 'bg-red-200 text-red-800' :
                                           ($loan->status == 'Disetujui' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-700') }}">
                                        {{ $loan->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-3 text-gray-500">Belum ada data peminjaman</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔹 Tabel Permintaan ATK -->
            <div class="flex-1 bg-white shadow-md rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-amber-700 mb-4">Riwayat Permintaan ATK</h3>
                <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-amber-100 text-amber-900">
                        <tr>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Tanggal Permintaan</th>
                            <th class="px-4 py-2">Tanggal Persetujuan</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permintaanAtk as $atkLog)
                            <tr class="border-b hover:bg-amber-50">
                                <td class="px-4 py-2">{{ $atkLog->atk->nama_barang ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $atkLog->jumlah }}</td>
                                <td class="px-4 py-2">
                                    {{ $atkLog->tanggal_permintaan ? $atkLog->tanggal_permintaan->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $atkLog->tanggal_persetujuan ? $atkLog->tanggal_persetujuan->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded-lg text-xs font-semibold
                                        {{ $atkLog->status == 'Menunggu' ? 'bg-yellow-200 text-yellow-800' :
                                           ($atkLog->status == 'Disetujui' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                        {{ $atkLog->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-3 text-gray-500">Belum ada permintaan ATK</td></tr>
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
