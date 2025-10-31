<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Penilaian Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Menu Navigasi Subpage -->
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
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                {{-- <!-- Header & Tombol Tambah -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Daftar Penilaian Aset</h3>
                    <a href="{{ route('assessments.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 w-full sm:w-auto text-center">
                        + Tambah Penilaian
                    </a>
                </div> --}}

                <!-- Pesan sukses -->
                @if(session('success'))
                    <div class="p-4 text-green-700 bg-green-50 border border-green-200 m-6 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tabel -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[800px] w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">Nama Aset</th>
                                <th class="px-4 py-2 text-left">Kondisi</th>
                                <th class="px-4 py-2 text-left">Catatan</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessments as $assessment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $loop->iteration + ($assessments->currentPage() - 1) * $assessments->perPage() }}</td>
                                    <td class="px-4 py-2">{{ $assessment->aset->nama ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                         {{ ucfirst(str_replace('_', ' ', $assessment->condition)) }}
                                    </td>
                                    <td class="px-4 py-2">{{ $assessment->notes ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $assessment->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded text-xs font-medium
                                            @if($assessment->status == 'Layak') bg-cyan-100 text-cyan-700
                                            @elseif($assessment->status == 'Kurang Layak') bg-yellow-100 text-yellow-700
                                            @elseif($assessment->status == 'Tidak Layak') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ $assessment->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 text-center flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('assessments.edit', $assessment->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('assessments.destroy', $assessment->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus penilaian ini?')" class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-4">
                                        Belum ada data penilaian aset
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200">
                    {{ $assessments->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
