<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            📋 {{ __('Tambah Penilaian Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">
                
                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Tambah Penilaian Aset
                </h3>

                <form action="{{ route('assessments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Pilih Aset --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Pilih Aset</label>
                        
                        <select name="aset_id" id="asetSelect"
                            class="w-full border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-400">
                            <option value="">-- Pilih Aset --</option>
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id }}">{{ $aset->nama }}</option>
                            @endforeach
                        </select>

                        @error('aset_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 🔍 Tom Select --}}
                    @push('scripts')
                        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
                        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

                        <script>
                            new TomSelect('#asetSelect', {
                                create: false,
                                sortField: {
                                    field: 'text',
                                    direction: 'asc'
                                },
                                placeholder: '-- Pilih atau cari aset --',
                                persist: false,
                                maxOptions: 100,
                                render: {
                                    no_results: function(data, escape) {
                                        return '<div class="no-results text-gray-500 px-3 py-2">Aset tidak ditemukan</div>';
                                    },
                                    option_create: function(data, escape) {
                                        return '<div class="create text-gray-500 px-3 py-2">Tambahkan aset baru: <strong>' + escape(data.input) + '</strong></div>';
                                    }
                                }
                            });
                        </script>
                    @endpush

                    {{-- Kondisi --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Kondisi</label>
                        <select name="condition" id="condition"
                            class="w-full border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baru">Baru</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" rows="3"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Tambahkan catatan penilaian (opsional)..."></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-4">
                        <a href="{{ route('assessments.index') }}"
                            class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
