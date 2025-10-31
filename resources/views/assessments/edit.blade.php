<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penilaian Aset') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">✏️ Ubah Data Penilaian</h3>

                <form action="{{ route('assessments.update', $assessment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pilih Aset --}}
                  <div class="mb-4">
    <label class="block text-gray-700 font-medium mb-2">Aset</label>

    <!-- Tampilkan nama aset, tapi tidak bisa diubah -->
    <input type="hidden" name="aset_id" value="{{ $assessment->aset_id }}">
    <input type="text" value="{{ $assessment->aset->nama ?? '-' }}" class="w-full border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" disabled>
</div>

                    {{-- Kondisi --}}
                    <div class="mb-4">
                        <label for="condition" class="block text-gray-700 font-medium mb-2">Kondisi</label>
                        <select name="condition" id="condition" class="w-full border-gray-300 rounded-lg" required>
                            <option value="baru" @selected($assessment->condition == 'baru')>Baru</option>
                            <option value="baik" @selected($assessment->condition == 'baik')>Baik</option>
                            <option value="rusak_ringan" @selected($assessment->condition == 'rusak_ringan')>Rusak Ringan</option>
                            <option value="rusak_berat" @selected($assessment->condition == 'rusak_berat')>Rusak Berat</option>
                        </select>
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-4">
                        <label for="notes" class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <textarea name="notes" id="notes" class="w-full border-gray-300 rounded-lg" rows="3">{{ old('notes', $assessment->notes) }}</textarea>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('assessments.index') }}"
                           class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
