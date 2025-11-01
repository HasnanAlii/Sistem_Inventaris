<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah Aset') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-gray-100">
                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Tambah Aset
                </h3>
                <form method="POST" action="{{ route('asets.store') }}" class="space-y-6">
                    @csrf

                    {{-- Nama Aset --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Aset</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                    </div>

                    {{-- Nomor Inventaris --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nomor Inventaris (otomatis)</label>
                        <input type="text" name="nomor_inventaris" 
                            value="(akan diisi otomatis)" readonly
                            class="w-full border-gray-300 rounded-xl px-4 py-2 bg-gray-100 text-gray-600 cursor-not-allowed">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="kategori_id"
                            class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Lokasi</label>
                        <select name="lokasi_id"
                            class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal & Umur Ekonomis --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Umur Ekonomis (tahun)</label>
                            <input type="number" name="umur_ekonomis" min="1"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>
                    </div>

                    {{-- Harga & Kondisi --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="harga"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Kondisi</label>
                            <select name="kondisi"
                                class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                                <option value="baru">Baru</option>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('asets.index') }}"
                            class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-md transition">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
