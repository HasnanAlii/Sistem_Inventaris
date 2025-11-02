<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            {{ __('Tambah Pengadaan ATK') }}
        </h2>
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-gray-100">

                {{-- 🧾 Judul Form --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 pl-4 border-l-4 border-blue-500">
                        Form Tambah Pengadaan ATK
                    </h3>
                    <p class="text-sm text-gray-500">
                        Lengkapi data berikut untuk menambahkan pengadaan alat tulis kantor baru.
                    </p>
                </div>

                {{-- Pesan Error --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 📋 Form --}}
                <form action="{{ route('atkprocurements.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Pengadaan & Jumlah --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-2">Nama Pengadaan</label>
                            <input type="text" name="nama_pengadaan"
                                class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                required>
                        </div>
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-2">Jumlah Barang</label>
                            <input type="number" name="jumlah"
                                class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                required>
                        </div>
                    </div>

                    {{-- Biaya & Tanggal Pengadaan --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-2">Biaya (Rp)</label>
                            <input type="number" name="biaya"
                                class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                required>
                        </div>
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-2">Tanggal Pengadaan</label>
                            <input type="date" name="tanggal_pengadaan"
                                value="{{ old('tanggal_pengadaan', \Carbon\Carbon::now()->toDateString()) }}"
                                class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">
                        </div>
                    </div>

                    {{-- Daftar ATK --}}
                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-2">Daftar ATK</label>
                        <div id="atks-container" class="space-y-5">
                            <div class="atk-item border border-gray-200 p-5 rounded-xl relative bg-gray-50">
                                <button type="button"
                                    class="remove-atk absolute top-2 right-3 text-red-500 font-bold text-xl">×</button>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                                        <input type="text" name="atk_items[0][nama_barang]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang</label>
                                        <input type="text" name="atk_items[0][kode_barang]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 bg-gray-100 text-gray-600 cursor-not-allowed shadow-sm"
                                            readonly placeholder="Otomatis">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                        <input type="number" name="atk_items[0][stok]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan (Rp)</label>
                                        <input type="number" name="atk_items[0][harga_satuan]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                                        <input type="date" name="atk_items[0][tanggal_masuk]"
                                            value="{{ old('atk_items.0.tanggal_masuk', \Carbon\Carbon::now()->toDateString()) }}"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <input type="text" name="atk_items[0][keterangan]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-atk"
                            class="mt-3 px-5 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-md transition text-base font-semibold">
                            + Tambah ATK
                        </button>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('logs.addatk') }}"
                            class="flex items-center gap-2 text-gray-600 hover:text-gray-900 text-base px-4 py-2.5 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>

                        <button type="submit"
                            class="bg-blue-600 text-white text-base font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Simpan Pengadaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let atkIndex = 1;
        const container = document.getElementById('atks-container');

        // Generate kode barang otomatis
        function generateKodeBarang(input) {
            const year = new Date().getFullYear();
            const seq = String(container.querySelectorAll('.atk-item').length).padStart(4, '0');
            input.value = `ATK-${year}-${seq}`;
        }

        // Tambah ATK
        document.getElementById('add-atk').addEventListener('click', function() {
            const template = container.querySelector('.atk-item').cloneNode(true);
            template.querySelectorAll('input').forEach(el => {
                const name = el.getAttribute('name');
                el.setAttribute('name', name.replace(/\d+/, atkIndex));

                if (el.hasAttribute('readonly')) {
                    el.value = 'Otomatis';
                } else if (el.type === 'date') {
                    el.value = new Date().toISOString().split('T')[0];
                } else {
                    el.value = '';
                }
            });
            container.appendChild(template);
            atkIndex++;
        });

        // Hapus ATK
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-atk')) {
                const items = container.querySelectorAll('.atk-item');
                if (items.length > 1) e.target.closest('.atk-item').remove();
            }
        });
    </script>
</x-app-layout>
