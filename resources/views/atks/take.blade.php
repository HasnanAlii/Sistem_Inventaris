<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __('Permintaan ATK') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">

                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Permintaan Alat Tulis Kantor
                </h3>

                <form action="{{ route('atks.request.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Pilih Barang --}}
                <div>
                    <label for="atk_id" class="block font-semibold text-gray-700 mb-2">Pilih Barang</label>
                    <select name="atk_id" id="atkSelect"
                        class="w-full border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none "
                        required>
                        <option value="">-- Pilih atau cari barang --</option>
                        @foreach ($atks as $atk)
                            <option value="{{ $atk->id }}">
                                {{ $atk->nama_barang }} (Stok: {{ $atk->stok }})
                            </option>
                        @endforeach
                    </select>

                    @error('atk_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 🔍 Tom Select Script --}}
                @push('scripts')
                    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

                    <script>
                        new TomSelect('#atkSelect', {
                            create: false,
                            sortField: { field: 'text', direction: 'asc' },
                            placeholder: '-- Pilih atau cari barang --',
                            persist: false,
                            maxOptions: 100,
                            render: {
                                no_results: function(data, escape) {
                                    return '<div class="no-results text-gray-500 px-3 py-2">Barang tidak ditemukan</div>';
                                },
                            }
                        });
                    </script>
                @endpush


                    {{-- Jumlah Permintaan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Jumlah Permintaan</label>
                        <input type="number" name="jumlah" min="1"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Masukkan jumlah permintaan..." required>
                        @error('jumlah')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Contoh: Untuk kebutuhan kantor bagian administrasi..."></textarea>
                        @error('keterangan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-6">
                        <a href="{{ route('logs.list') }}"
                            class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition flex items-center gap-2">
                            {{-- <i data-feather="send" class="w-4 h-4"></i> --}}
                            Kirim Permintaan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
