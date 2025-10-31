<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lokasi Aset') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-6">

            <form action="{{ route('lokasis.update', $lokasi) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-1">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $lokasi->nama) }}" 
                           class="w-full border rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Kode</label>
                    <input type="text" name="kode" value="{{ old('kode', $lokasi->kode) }}" 
                           class="w-full border rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Gedung</label>
                    <input type="text" name="gedung" value="{{ old('gedung', $lokasi->gedung) }}" 
                           class="w-full border rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Lantai</label>
                    <input type="text" name="lantai" value="{{ old('lantai', $lokasi->lantai) }}" 
                           class="w-full border rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="4" 
                              class="w-full border rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">{{ old('keterangan', $lokasi->keterangan) }}</textarea>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('lokasis.index') }}" 
                       class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
