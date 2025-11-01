<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-3 flex flex-wrap items-center gap-3 rounded-xl mb-8">
        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('asets.*')
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-sm'
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-5 h-5"></i>
            List Inventaris
        </a>

        @hasrole('petugas')
        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('maintenance.*')
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-sm'
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-5 h-5"></i>
            Riwayat Perbaikan
        </a>

        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('assessments.*')
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-sm'
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            Penilaian Kelayakan
        </a>
        @endhasrole

        <a href="{{ route('aset_loans.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('aset_loans.*')
                      ? 'bg-cyan-200 border-cyan-600 text-cyan-900 shadow-sm'
                      : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-5 h-5"></i>
            Peminjaman Aset
        </a>
    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- 🔸 Header + Tombol Tambah -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-sky-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="clipboard" class="w-5 h-5 text-cyan-600"></i>
                        Daftar Peminjaman Aset
                    </h3>
                    <a href="{{ route('aset_loans.create') }}"
                         class="flex items-center gap-2 bg-cyan-600 text-white px-4 py-2 rounded-lg font-medium 
                                hover:bg-cyan-700 hover:shadow-lg transition-all duration-200">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            <span>Tambah Peminjaman Aset</span>
                        </a>
                </div>

                <!-- ✅ Pesan sukses -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-700 bg-green-50 border border-green-200 rounded-lg shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Nama Aset</th>
                                <th class="px-4 py-3 text-left">Pemohon</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3 text-center">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-center">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr class="hover:bg-cyan-50 transition duration-150">
                                    <td class="px-4 py-3">{{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $loan->aset->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $loan->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">{{ $loan->jumlah }}</td>
                                    <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($loan->status == 'Disetujui') bg-green-100 text-green-800
                                            @elseif($loan->status == 'Ditolak') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center flex justify-center gap-3 flex-wrap">
                                        @role('petugas')
                                            <a href="{{ route('aset_loans.edit', $loan) }}" 
                                               class="text-yellow-600 hover:text-yellow-800 font-medium transition">
                                               Edit
                                            </a>
                                        @endrole

                                        @role('pegawai')
                                            @if($loan->status == 'Disetujui')
                                                <button onclick="openReturnModal('{{ route('aset_loans.return', $loan) }}')" 
                                                        class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition">
                                                    Kembalikan
                                                </button>
                                            @endif
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-gray-500">Belum ada peminjaman aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- 🗑️ Modal Konfirmasi Pengembalian -->
    <div id="returnModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-3">Konfirmasi Pengembalian Aset</h3>
            <p class="text-gray-600 mb-4">Apakah Anda yakin ingin mengembalikan aset ini?</p>
            <div class="flex justify-end space-x-2">
                <button onclick="toggleReturnModal(false)" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <form id="returnForm" method="POST">
                    @csrf
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Kembalikan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        feather.replace();

        function openReturnModal(url) {
            document.getElementById('returnForm').action = url;
            toggleReturnModal(true);
        }

        function toggleReturnModal(show) {
            const modal = document.getElementById('returnModal');
            modal.classList.toggle('hidden', !show);
            modal.classList.toggle('flex', show);
        }
    </script>
</x-app-layout>
