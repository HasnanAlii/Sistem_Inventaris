<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __('Tambah Penilaian Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen ">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-gray-100">
                
                {{-- 🧾 Judul Form --}}
                <div class="mb-6 border-b pb-4">
                    
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                        
                         Form Tambah Penilaian Aset
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Lengkapi data berikut untuk menambahkan hasil penilaian kondisi aset.
                    </p>
                </div>

                {{-- 📋 Form --}}
                <form action="{{ route('assessments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Pilih Aset --}}
                    <div>
                        <label for="asetSelect" class="block text-base font-semibold text-gray-700 mb-2">
                            Pilih Aset
                        </label>
                        <select name="aset_id" id="asetSelect"
                            class="w-full text-base border-gray-300 rounded-lg py-2.5  focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">
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
                                sortField: { field: 'text', direction: 'asc' },
                                placeholder: '-- Pilih atau cari aset --',
                                maxOptions: 100,
                                render: {
                                    no_results: function(data, escape) {
                                        return '<div class="no-results text-gray-500 px-3 py-2">Aset tidak ditemukan</div>';
                                    }
                                }
                            });
                        </script>
                    @endpush

                    {{-- Kondisi --}}
                    <div>
                        <label for="condition" class="block text-base font-semibold text-gray-700 mb-2">
                            Kondisi Aset
                        </label>
                        <select name="condition" id="condition"
                            class="w-full text-base border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
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
                        <label for="notes" class="block text-base font-semibold text-gray-700 mb-2">
                            Catatan (Opsional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full text-base border-gray-300 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                            placeholder="Tambahkan catatan penilaian (opsional)..."></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('assessments.index') }}"
                            class="flex items-center gap-2 text-gray-600 hover:text-gray-900 text-base px-4 py-2.5 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>

                        <button type="submit"
                            class="bg-blue-600 text-white text-base font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
