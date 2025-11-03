<x-app-layout>
    {{-- 🧭 Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 flex items-center gap-3">
             {{ __('Detail Barang ATK') }}
        </h2>
    </x-slot>

    {{-- 📄 Konten Utama --}}
    <div class="py-12 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-10 border border-gray-200">

                {{-- 🧾 Informasi Barang --}}
                <div class="mb-8 border-b pb-4">
                    <h3 class="text-2xl font-semibold text-blue-700 flex items-center gap-3">
                        🧾 Informasi Barang ATK
                    </h3>
                    <p class="text-base text-gray-500 mt-2">
                        Berikut adalah detail lengkap dari data barang alat tulis kantor.
                    </p>
                </div>

                {{-- 📋 Detail Barang --}}
                <table class="w-full border-collapse text-lg mb-10">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-4 text-gray-600 font-medium">Kode Barang</th>
                            <td class="py-4 text-gray-800 font-semibold">
                                {{ $atk->kode_barang ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium">Nama Barang</th>
                            <td class="py-4 text-gray-800 font-semibold">
                                {{ $atk->nama_barang ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium">Stok</th>
                            <td class="py-4 text-gray-800">{{ $atk->stok ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium">Stok Minimum</th>
                            <td class="py-4 text-gray-800">{{ $atk->stok_minimum ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium">Harga Satuan</th>
                            <td class="py-4 text-green-700 font-bold text-xl">
                                Rp {{ number_format($atk->harga_satuan, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-4 text-gray-600 font-medium">Tanggal Masuk</th>
                            <td class="py-4 text-gray-800">
                                {{ \Carbon\Carbon::parse($atk->tanggal_masuk)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                       
                    </tbody>
                </table>

                {{-- 🔘 Tombol Aksi --}}
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('atks.index') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-gray-900 text-lg font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('atks.edit', $atk) }}"
                            class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-semibold 
                                   hover:bg-blue-700 hover:shadow-md transition-all duration-200">
                            ✏️ Edit
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
