<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __('Edit Barang ATK') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">

                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Edit Barang ATK
                </h3>

                <form action="{{ route('atks.update', $atk) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Grid Input --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Nama Barang --}}
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Nama Barang</label>
                            <input type="text" name="nama_barang" value="{{ old('nama_barang', $atk->nama_barang) }}"
                                class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Masukkan nama barang..." required>
                        </div>

                   

                        {{-- Stok --}}
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Stok</label>
                            <input type="number" name="stok" value="{{ old('stok', $atk->stok) }}"
                                class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Masukkan jumlah stok" required>
                        </div>

                        {{-- Stok Minimum --}}
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Stok Minimum</label>
                            <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $atk->stok_minimum) }}"
                                class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Masukkan stok minimum" required>
                        </div>

                        {{-- Harga Satuan --}}
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Harga Satuan</label>
                            <input type="number" name="harga_satuan" value="{{ old('harga_satuan', $atk->harga_satuan) }}" step="0.01"
                                class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Masukkan harga per satuan">
                        </div>

                    {{-- Tanggal Masuk --}}
                    <div class="col-span-1 sm:col-span-2">
                        <label class="block font-semibold text-gray-700 mb-2">Tanggal Masuk</label>
                        <input 
                            type="date" 
                            name="tanggal_masuk"
                            value="{{ old('tanggal_masuk', optional($atk->tanggal_masuk)->format('Y-m-d')) }}"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        >
                    </div>

                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-6">
                        <a href="{{ route('atks.index') }}"
                            class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Perbarui
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
