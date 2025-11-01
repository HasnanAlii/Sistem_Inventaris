<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah Pengadaan ATK') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-2xl p-8 border border-gray-100">

            {{-- Judul Form --}}
            <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                Form Tambah Pengadaan
            </h3>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('atkprocurements.store') }}" method="POST">
                @csrf

                {{-- Nama Pengadaan & Jumlah --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Pengadaan</label>
                        <input type="text" name="nama_pengadaan" class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Jumlah Barang</label>
                        <input type="number" name="jumlah" class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                </div>

                {{-- Biaya & Tanggal Pengadaan --}}
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Biaya (Rp)</label>
                        <input type="number" name="biaya" class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>
                   <div>
                        <label class="block font-semibold text-gray-700 mb-1">Tanggal Pengadaan</label>
                        <input 
                            type="date" 
                            name="tanggal_pengadaan" 
                            value="{{ old('tanggal_pengadaan', \Carbon\Carbon::now()->toDateString()) }}"
                            class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                   </div>
                </div>

                {{-- Daftar ATK --}}
                <div class="mt-6">
                    <label class="block font-semibold mb-2">Daftar ATK</label>
                    <div id="atks-container" class="space-y-4">
                        <div class="atk-item border p-4 rounded relative">
                            <button type="button" class="remove-atk absolute top-2 right-2 text-red-500 font-bold">×</button>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium">Nama Barang</label>
                                    <input type="text" name="atk_items[0][nama_barang]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Kode Barang</label>
                                    <input type="text" name="atk_items[0][kode_barang]" class="w-full border-gray-300 rounded-xl px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed" readonly placeholder="Otomatis">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <div>
                                    <label class="block text-sm font-medium">Stok</label>
                                    <input type="number" name="atk_items[0][stok]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Harga Satuan (Rp)</label>
                                    <input type="number" name="atk_items[0][harga_satuan]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <div>
                                    <label class="block text-sm font-medium">Tanggal Masuk</label>
                                    <input 
                                        type="date" 
                                        name="atk_items[0][tanggal_masuk]" 
                                        value="{{ old('atk_items.0.tanggal_masuk', \Carbon\Carbon::now()->toDateString()) }}"
                                        class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Keterangan</label>
                                    <input type="text" name="atk_items[0][keterangan]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-atk" class="mt-3 px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">
                        Tambah ATK
                    </button>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ route('logs.addatk') }}" class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-md transition">
                        Simpan Pengadaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let atkIndex = 1;
        const container = document.getElementById('atks-container');

        // Fungsi generate kode barang sementara
        function generateKodeBarang(input) {
            const year = new Date().getFullYear();
            const seq = String(container.querySelectorAll('.atk-item').length).padStart(4,'0');
            input.value = `ATK-${year}-${seq}`;
        }

        // Tambah ATK baru
        document.getElementById('add-atk').addEventListener('click', function() {
            const template = container.querySelector('.atk-item').cloneNode(true);
            template.querySelectorAll('input').forEach(el => {
                const name = el.getAttribute('name');
                el.setAttribute('name', name.replace(/\d+/, atkIndex));

                if(el.hasAttribute('readonly')) {
                    el.value = 'Otomatis';
                } else if(el.type === 'date') {
                    el.value = new Date().toISOString().split('T')[0];
                } else {
                    el.value = '';
                }
            });
            container.appendChild(template);
            atkIndex++;
        });

        // Remove ATK
        container.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-atk')) {
                const items = container.querySelectorAll('.atk-item');
                if(items.length > 1) e.target.closest('.atk-item').remove();
            }
        });
    </script>
</x-app-layout>
