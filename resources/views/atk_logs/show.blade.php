<x-app-layout>
    {{-- 🧭 Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            📝 {{ __('Detail Permintaan ATK') }}
        </h2>
    </x-slot>

    {{-- 📄 Konten Utama --}}
    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">

                {{-- 🧾 Informasi Permintaan --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                        📋 Informasi Permintaan ATK
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail lengkap permintaan alat tulis kantor oleh pegawai.
                    </p>
                </div>

                {{-- 📋 Detail --}}
                <table class="w-full border-collapse text-sm mb-8">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-3 text-gray-600 font-medium">Nama Barang</th>
                            <td class="py-3 text-gray-800 font-semibold">
                                {{ $atkLog->atk->nama_barang ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Pemohon</th>
                            <td class="py-3 text-gray-800">{{ $atkLog->user->name ?? 'Tidak diketahui' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Jumlah Diminta</th>
                            <td class="py-3 text-gray-800">{{ $atkLog->jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Tanggal Permintaan</th>
                            <td class="py-3 text-gray-800">
                                {{ $atkLog->tanggal_permintaan ? $atkLog->tanggal_permintaan->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Tanggal Persetujuan</th>
                            <td class="py-3 text-gray-800">
                                {{ $atkLog->tanggal_persetujuan ? $atkLog->tanggal_persetujuan->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Status Permintaan</th>
                            <td class="py-3">
                                @php
                                    $statusColors = [
                                        'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700',
                                        'Disetujui' => 'bg-green-100 text-green-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        'Selesai' => 'bg-blue-100 text-blue-700',
                                    ];
                                @endphp
                                <span class="inline-block px-4 py-2 rounded-lg font-semibold text-sm {{ $statusColors[$atkLog->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $atkLog->status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- 🔘 Tombol Aksi --}}
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('logs.list') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    @if ($atkLog->status === 'Menunggu Konfirmasi')
                        <div class="flex items-center gap-3">
                            {{-- Tombol Tolak --}}
                            <form action="{{ route('atk_logs.reject', $atkLog) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 bg-red-600 text-white px-4 py-2.5 rounded-lg hover:bg-red-700 shadow-sm transition">
                                    <i data-feather="x-circle" class="w-4 h-4"></i>
                                    Tolak
                                </button>
                            </form>

                            {{-- Tombol Setujui --}}
                            <form action="{{ route('atk_logs.approve', $atkLog) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 bg-green-600 text-white px-4 py-2.5 rounded-lg hover:bg-green-700 shadow-sm transition">
                                    <i data-feather="check-circle" class="w-4 h-4"></i>
                                    Setujui
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

{{-- Aktifkan Feather Icons --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof feather !== 'undefined') feather.replace();
    });
</script>
