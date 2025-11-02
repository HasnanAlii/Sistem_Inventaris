<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Penilaian Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">

        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('asets.*') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-6 h-6"></i>
            List Inventaris
        </a>

        @hasrole('petugas')
        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('maintenance.*') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-lg' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-6 h-6"></i>
            Riwayat Perbaikan
        </a>

        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('assessments.*') 
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-lg' 
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-6 h-6"></i>
            Penilaian Kelayakan
        </a>
        @endhasrole

        @role('pegawai')
        <a href="{{ route('aset_loans.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('aset_loans.*') 
                      ? 'bg-cyan-200 border-cyan-600 text-cyan-900 shadow-lg' 
                      : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-6 h-6"></i>
            Peminjaman Aset
        </a>
        @endhasrole
    </nav>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header Tabel -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-2xl shadow-sm">

                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="check-square" class="w-6 h-6 text-blue-600"></i>
                        Daftar Penilaian Aset
                    </h3>

                    

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                        <!-- Form Cari -->
                        <form action="{{ route('assessments.index') }}" method="GET" class="flex flex-wrap gap-3 items-center w-full sm:w-auto">
                            <input 
                                type="text" 
                                name="aset_name" 
                                value="{{ request('aset_name') }}" 
                                placeholder="Cari nama aset..." 
                                class="border-gray-300 rounded-xl px-4 py-2 text-base focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <button type="submit" 
                                class="bg-blue-600 text-white px-5 py-2 rounded-xl font-medium hover:bg-blue-700 transition shadow-sm">
                                Cari
                            </button>
                            <a href="{{ route('assessments.index') }}" 
                               class="bg-gray-200 text-gray-700 px-5 py-2 rounded-xl font-medium hover:bg-gray-300 transition shadow-sm">
                                Reset
                            </a>
                        </form>

                        <!-- Tombol Tambah -->
                        <a href="{{ route('assessments.create') }}"
                           class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-xl font-medium 
                                  hover:bg-blue-700 hover:shadow-lg transition-all duration-200">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            Tambah Penilaian
                        </a>
                    </div>
                </div>

                <!-- Pesan sukses -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-700 bg-green-50 border border-green-200 rounded-lg shadow-sm text-base">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-base">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Nama Aset</th>
                                <th class="px-5 py-3 text-left">Kondisi</th>
                                <th class="px-5 py-3 text-left">Catatan</th>
                                <th class="px-5 py-3 text-center">Tanggal</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessments as $assessment)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="px-5 py-3">{{ $loop->iteration + ($assessments->currentPage() - 1) * $assessments->perPage() }}</td>
                                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $assessment->aset->nama ?? '-' }}</td>
                                    <td class="px-5 py-3 capitalize">{{ str_replace('_', ' ', $assessment->condition) }}</td>
                                    <td class="px-5 py-3 text-gray-600">{{ $assessment->notes ?? '-' }}</td>
                                    <td class="px-5 py-3 text-center text-gray-600">{{ $assessment->created_at->format('d/m/Y') }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($assessment->status == 'Layak') bg-cyan-100 text-cyan-800
                                            @elseif($assessment->status == 'Kurang Layak') bg-yellow-100 text-yellow-800
                                            @elseif($assessment->status == 'Tidak Layak') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ $assessment->status }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('assessments.show', $assessment->id) }}"
                                               class="text-blue-600 hover:text-blue-800 font-medium transition">Detail</a>
                                            <a href="{{ route('assessments.edit', $assessment->id) }}"
                                               class="text-yellow-600 hover:text-yellow-800 font-medium transition">Edit</a>
                                            <form action="{{ route('assessments.destroy', $assessment->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus penilaian ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-6">Belum ada data penilaian aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl text-base">
                    {{ $assessments->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
