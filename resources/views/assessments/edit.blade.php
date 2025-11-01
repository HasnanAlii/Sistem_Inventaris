<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            ✏️ {{ __('Edit Penilaian Aset') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
                    
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Ubah Penilaian Aset
                </h3>
                <form action="{{ route('assessments.update', $assessment->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- 🔹 Aset --}}
                   <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Aset</label>
                        <input type="hidden" name="aset_id" value="{{ $assessment->aset_id }}">
                        <input type="text"
                            value="{{ $assessment->aset->nama ?? '-' }}"
                            class="w-full bg-gray-100 border border-gray-300 rounded-lg py-2 px-3 text-gray-700 cursor-not-allowed focus:outline-none"
                            disabled>
                    </div>


                    {{-- 🔹 Kondisi --}}
                    <div>
                        <label for="condition" class="block text-gray-700 font-medium mb-2">Kondisi Aset</label>
                        <select name="condition" id="condition"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white"
                                required>
                            <option value="baru" @selected($assessment->condition == 'baru')>Baru</option>
                            <option value="baik" @selected($assessment->condition == 'baik')>Baik</option>
                            <option value="rusak_ringan" @selected($assessment->condition == 'rusak_ringan')>Rusak Ringan</option>
                            <option value="rusak_berat" @selected($assessment->condition == 'rusak_berat')>Rusak Berat</option>
                        </select>
                    </div>

                    {{-- 🔹 Catatan --}}
                    <div>
                        <label for="notes" class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <textarea name="notes" id="notes"
                                  class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                  rows="3"
                                  placeholder="Masukkan catatan tambahan (opsional)">{{ old('notes', $assessment->notes) }}</textarea>
                    </div>

                    {{-- 🔹 Tombol Aksi --}}
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route('assessments.index') }}"
                        class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 shadow-sm transition">
                             Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
