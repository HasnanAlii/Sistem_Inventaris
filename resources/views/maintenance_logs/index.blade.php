<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Perbaikan Aset') }}
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
             Perbaikan Aset
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

        {{-- @role('pegawai') --}}
        <a href="{{ route('aset_loans.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('aset_loans.*') 
                      ? 'bg-cyan-200 border-cyan-600 text-cyan-900 shadow-lg' 
                      : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-6 h-6"></i>
            Peminjaman Aset
        </a>
        {{-- @endhasrole --}}
    </nav>

    <!-- 🔹 Konten Utama -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-2xl shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="tool" class="w-6 h-6 text-green-600"></i>
                        Daftar Perbaikan Aset
                    </h3>

                    <a href="{{ route('maintenance.create') }}"
                       class="flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-xl font-medium 
                              hover:bg-green-700 hover:shadow-lg transition-all duration-200">
                        <i data-feather="plus-circle" class="w-5 h-5"></i>
                        Tambah Perbaikan
                    </a>
                </div>

                <!-- ✅ Pesan Sukses -->
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
                                <th class="px-5 py-3 text-left">Jenis Perbaikan</th>
                                <th class="px-5 py-3 text-left">Biaya</th>
                                <th class="px-5 py-3 text-left">Tanggal Perbaikan</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-5 py-3">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $log->aset->nama ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $log->jenis_perbaikan ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-700">Rp{{ number_format($log->biaya, 0, ',', '.') }}</td>
                                    <td class="px-5 py-3 text-gray-600">{{ $log->tanggal->format('d/m/Y') }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('maintenance.show', $log->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-medium transition">Detail</a>
                                          
                                            <form action="{{ route('maintenance.destroy', $log->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus data perbaikan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 font-medium transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-6">Belum ada data perbaikan aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 🔄 Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl text-base">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
