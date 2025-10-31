<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Aset') }}
        </h2>
    </x-slot>

    

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('asets.update', $aset) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold mb-1">Nama Aset</label>
                        <input type="text" name="nama" value="{{ old('nama', $aset->nama) }}" class="w-full border rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Kategori</label>
                        <select name="kategori_id" class="w-full border rounded-lg px-3 py-2" required>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ $aset->kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Lokasi</label>
                        <select name="lokasi_id" class="w-full border rounded-lg px-3 py-2" required>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}" {{ $aset->lokasi_id == $lokasi->id ? 'selected' : '' }}>
                                    {{ $lokasi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Perolehan</label>
                            <input 
                                type="date" 
                                name="tanggal_perolehan" 
                                value="{{ old('tanggal_perolehan', $aset->tanggal_perolehan ? $aset->tanggal_perolehan->format('d-m-Y') : '') }}" 
                                class="w-full border rounded-lg px-3 py-2" 
                                required
                            >
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Umur Ekonomis (tahun)</label>
                            <input type="number" name="umur_ekonomis" value="{{ old('umur_ekonomis', $aset->umur_ekonomis) }}" min="1" class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Harga (Rp)</label>
                            <input type="number" name="harga" value="{{ old('harga', $aset->harga) }}" class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kondisi</label>
                            <select name="kondisi" class="w-full border rounded-lg px-3 py-2" required>
                                @foreach (['baru' => 'Baru', 'baik' => 'Baik', 'rusak_ringan' => 'Rusak Ringan', 'rusak_berat' => 'Rusak Berat'] as $key => $label)
                                    <option value="{{ $key }}" {{ $aset->kondisi == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('asets.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
