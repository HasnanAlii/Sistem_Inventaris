<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Riwayat Perbaikan Aset') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('maintenance.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium">Aset</label>
                        <select name="aset_id" class="w-full border-gray-300 rounded">
                            <option value="">-- Pilih Aset --</option>
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id }}">{{ $aset->nama }}</option>
                            @endforeach
                        </select>
                        @error('aset_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Jenis Perbaikan</label>
                        <input type="text" name="jenis_perbaikan" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Biaya</label>
                        <input type="number" name="biaya" class="w-full border-gray-300 rounded" step="0.01">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Keterangan</label>
                        <textarea name="keterangan" class="w-full border-gray-300 rounded" rows="3"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('maintenance.index') }}" class="mr-3 text-gray-600 hover:underline">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
