<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Aset') }}
        </h2>
    </x-slot>

    <nav class="bg-white shadow-md border-b border-gray-200 px-6 py-3 flex items-center justify-start gap-4 rounded-lg mb-6">
        <!-- List Inventaris -->
        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('asets.*') ? 'bg-amber-200 border-amber-600 text-amber-900' : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-5 h-5"></i>
            <span>List Inventaris</span>
        </a>

        <!-- Riwayat Perbaikan -->
            @hasrole('petugas')

        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('maintenance.*') ? 'bg-green-200 border-green-600 text-green-900' : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-5 h-5"></i>
            <span>Riwayat Perbaikan</span>
        </a>

        <!-- Penilaian Kelayakan -->
        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                  {{ request()->routeIs('assessments.*') ? 'bg-blue-200 border-blue-600 text-blue-900' : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            <span>Penilaian Kelayakan</span>
        </a>
        @endhasrole

        <a href="{{ route('aset_loans.index') }}"
        class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 font-semibold text-sm
                {{ request()->routeIs('aset_loans.*') ? 'bg-cyan-200 border-cyan-600 text-cyan-900' : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-5 h-5"></i>
            <span>Peminjaman Aset</span>
           </a>
    </nav>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <!-- 🔹 Tambah Peminjaman -->
                <div class="flex justify-end p-6 border-b border-gray-200">
                    <a href="{{ route('aset_loans.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        + Ajukan Peminjaman
                    </a>
                </div>

                <!-- 📋 Tabel Peminjaman -->
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama Aset</th>
                                <th class="px-4 py-2 border">Pemohon</th>
                                <th class="px-4 py-2 border text-center">Jumlah</th>
                                <th class="px-4 py-2 border text-center">Tanggal Pinjam</th>
                                <th class="px-4 py-2 border text-center">Tanggal Kembali</th>
                                <th class="px-4 py-2 border text-center">Status</th>
                                    <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $loan->aset->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $loan->user->name ?? '-' }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $loan->jumlah }}</td>
                                    <td class="px-4 py-2 border text-center">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border text-center">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            {{ $loan->status == 'Disetujui' ? 'bg-green-100 text-green-700' :
                                               ($loan->status == 'Ditolak' ? 'bg-red-100 text-red-700' :
                                               'bg-yellow-100 text-yellow-700') }}">
                                            {{ $loan->status }}
                                        </span>
                                    </td>

                                    @if(auth()->user()->hasRole('petugas'))
                                        <td class="px-4 py-2 border text-center">
                                           
                                             <a href="{{ route('aset_loans.edit', $loan) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        </td>
                                    @endif
                                    @if(auth()->user()->hasRole('pegawai') && $loan->status == 'Disetujui')
                                    <td class="px-4 py-2 border text-center">
                                        <button onclick="openReturnModal('{{ route('aset_loans.return', $loan) }}')" 
                                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                            Kembalikan
                                        </button>
                                    </td>
                                @endif

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-4 text-center text-gray-500">Belum ada peminjaman aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- 🗑️ Modal Konfirmasi Pengembalian -->
                    <div id="returnModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
                            <h3 class="text-lg font-semibold mb-3">Konfirmasi Pengembalian Aset</h3>
                            <p class="text-gray-600 mb-4">Apakah Anda yakin ingin mengembalikan aset ini?</p>
                            <div class="flex justify-end space-x-2">
                                <button onclick="toggleReturnModal(false)" class="px-4 py-2 border rounded-lg">Batal</button>
                                <form id="returnForm" method="POST">
                                    @csrf
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Kembalikan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
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

                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200">
                    {{ $loans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
