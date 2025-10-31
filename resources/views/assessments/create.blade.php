<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Penilaian Aset') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('assessments.store') }}" method="POST">
                
                @csrf

                <div class="mb-4">
                    <label for="aset_id" class="block text-gray-700 font-medium mb-2">Pilih Aset</label>
                    <select name="aset_id" id="aset_id" class="w-full border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih Aset --</option>
                        @foreach($asets as $aset)
                            <option value="{{ $aset->id }}">{{ $aset->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="condition" class="block text-gray-700 font-medium mb-2">Kondisi</label>
                    <select name="condition" id="condition" class="w-full border-gray-300 rounded-lg" required>
                        <option value="baru">Baru</option>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" class="w-full border-gray-300 rounded-lg" rows="3"></textarea>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('assessments.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 me-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
