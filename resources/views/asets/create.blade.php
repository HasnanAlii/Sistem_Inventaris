<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Aset') }}
        </h2>
    </x-slot>

    
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('asets.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-semibold mb-1">Nama Aset</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                     <div>
    <label class="block font-semibold mb-1">Nomor Inventaris (otomatis)</label>
    <input type="text" name="nomor_inventaris" 
           value="(akan diisi otomatis)" 
           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600" 
           readonly>
</div>

                    <div>
                        <label class="block font-semibold mb-1">Kategori</label>
                        <select name="kategori_id" class="w-full border rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Lokasi</label>
                        <select name="lokasi_id" class="w-full border rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Umur Ekonomis (tahun)</label>
                            <input type="number" name="umur_ekonomis" min="1" class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Harga (Rp)</label>
                            <input type="number" name="harga" class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kondisi</label>
                            <select name="kondisi" class="w-full border rounded-lg px-3 py-2" required>
                                <option value="baru">Baru</option>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('asets.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
