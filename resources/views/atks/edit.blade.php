<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Barang ATK') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded-lg">
            <form action="{{ route('atks.update', $atk) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $atk->nama_barang }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Satuan</label>
                        <input type="text" name="satuan" value="{{ $atk->satuan }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Stok</label>
                        <input type="number" name="stok" value="{{ $atk->stok }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Stok Minimum</label>
                        <input type="number" name="stok_minimum" value="{{ $atk->stok_minimum }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Harga Satuan</label>
                        <input type="number" name="harga_satuan" value="{{ $atk->harga_satuan }}" class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- <div>
                        <label class="block text-sm font-medium">Kondisi</label>
                        <select name="kondisi" class="w-full border rounded px-3 py-2">
                            <option value="baik" {{ $atk->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak" {{ $atk->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div> --}}

                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ $atk->tanggal_masuk }}" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Keterangan</label>
                        <textarea name="keterangan" class="w-full border rounded px-3 py-2" rows="3">{{ $atk->keterangan }}</textarea>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('atks.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg mr-2">Kembali</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
