<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            📍 {{ __('Edit Lokasi Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">

                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Edit Lokasi Aset
                </h3>

                <form action="{{ route('lokasis.update', $lokasi) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nama Lokasi</label>
                        <input type="text" name="nama" value="{{ old('nama', $lokasi->nama) }}"
                               class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                               placeholder="Masukkan nama lokasi..." required>
                        @error('nama')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kode --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Kode Lokasi</label>
                        <input type="text" name="kode" value="{{ old('kode', $lokasi->kode) }}"
                               class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                               placeholder="Masukkan kode lokasi (opsional)">
                        @error('kode')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gedung --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Gedung</label>
                        <input type="text" name="gedung" value="{{ old('gedung', $lokasi->gedung) }}"
                               class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                               placeholder="Masukkan nama gedung (opsional)">
                        @error('gedung')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lantai --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Lantai</label>
                        <input type="text" name="lantai" value="{{ old('lantai', $lokasi->lantai) }}"
                               class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                               placeholder="Masukkan nomor lantai (opsional)">
                        @error('lantai')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="4"
                                  class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                  placeholder="Tambahkan keterangan (opsional)">{{ old('keterangan', $lokasi->keterangan) }}</textarea>
                        @error('keterangan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-4">
                        <a href="{{ route('lokasis.index') }}"
                           class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
