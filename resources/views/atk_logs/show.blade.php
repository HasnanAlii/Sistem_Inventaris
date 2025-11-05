<x-app-layout>
    {{-- 🧭 Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 flex items-center gap-3">
             {{ __('Detail Permintaan Alat Kantor') }}
        </h2>
    </x-slot>

    {{-- 📄 Konten Utama --}}
    <div class="py-12 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-10 border border-gray-200">

                {{-- 🧾 Informasi Permintaan --}}
                <div class="mb-10 border-b pb-6">
                    <h3 class="text-2xl font-semibold text-blue-700 flex items-center gap-3">
                         Informasi Permintaan Alat Kantor
                    </h3>
                    <p class="text-base text-gray-500 mt-2">
                        Detail lengkap permintaan alat tulis kantor oleh pegawai.
                    </p>
                </div>

                {{-- 📋 Detail --}}
                <table class="w-full border-collapse text-lg mb-10">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-4 text-gray-600 font-semibold">Nama Barang</th>
                            <td class="py-4 text-gray-900 font-semibold">
                                {{ $atkLog->atk->nama_barang ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-semibold">Pemohon</th>
                            <td class="py-4 text-gray-900">{{ $atkLog->user->name ?? 'Tidak diketahui' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-semibold">Jumlah Diminta</th>
                            <td class="py-4 text-gray-900">{{ $atkLog->jumlah }} {{ $atkLog->satuan }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-semibold">Tanggal Permintaan</th>
                            <td class="py-4 text-gray-900">
                                {{ $atkLog->tanggal_permintaan ? $atkLog->tanggal_permintaan->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-semibold">Tanggal Persetujuan</th>
                            <td class="py-4 text-gray-900">
                                {{ $atkLog->tanggal_persetujuan ? $atkLog->tanggal_persetujuan->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-semibold">Status Permintaan</th>
                            <td class="py-4">
                                @php
                                    $statusColors = [
                                        'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700',
                                        'Disetujui' => 'bg-green-100 text-green-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        'Selesai' => 'bg-blue-100 text-blue-700',
                                    ];
                                @endphp
                                <span class="inline-block px-5 py-2.5 rounded-lg font-semibold text-base {{ $statusColors[$atkLog->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $atkLog->status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- 🔘 Tombol Aksi --}}
                <div class="flex justify-between items-center mt-10">
                    <a href="{{ route('logs.list') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-gray-900 text-lg font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    @if ($atkLog->status === 'Menunggu Konfirmasi')
                        <div class="flex items-center gap-4">
                            {{-- Tombol Tolak --}}
                            <form action="{{ route('atk_logs.reject', $atkLog) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 bg-red-600 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-red-700 hover:shadow-md transition-all duration-200">
                                    <i data-feather="x-circle" class="w-5 h-5"></i>
                                    Tolak
                                </button>
                            </form>

                            {{-- Tombol Setujui --}}
                            <form action="{{ route('atk_logs.approve', $atkLog) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 bg-green-600 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-green-700 hover:shadow-md transition-all duration-200">
                                    <i data-feather="check-circle" class="w-5 h-5"></i>
                                    Setujui
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- 🪶 Aktifkan Feather Icons --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
</x-app-layout>
