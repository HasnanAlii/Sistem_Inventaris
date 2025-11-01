<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah Pengadaan Aset') }}
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

            <form action="{{ route('aset_logs.store') }}" method="POST">
                @csrf

                {{-- Nama Pengadaan & Jumlah --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Nama Pengadaan</label>
                        <input type="text" name="nama_barang" class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
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

                {{-- Daftar Aset --}}
                <div class="mt-6">
                    <label class="block font-semibold mb-2">Daftar Aset</label>
                    <div id="asets-container" class="space-y-4">
                        <div class="aset-item border p-4 rounded relative">
                            <button type="button" class="remove-aset absolute top-2 right-2 text-red-500 font-bold">×</button>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium">Nama Barang</label>
                                    <input type="text" name="asets[0][nama]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Nomor Inventaris</label>
                                    <input type="text" name="asets[0][nomor_inventaris]" class="w-full border-gray-300 rounded-xl px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed" readonly placeholder="Otomatis">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <div>
                                    <label class="block text-sm font-medium">Kategori</label>
                                    <select name="asets[0][kategori_id]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none kategori-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" data-code="{{ strtoupper(substr($kategori->nama, 0, 3)) }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Harga (Rp)</label>
                                    <input type="number" name="asets[0][harga]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mt-4">
                              <div>
                                    <label class="block text-sm font-medium">Tanggal Perolehan</label>
                                  <!-- Input tanggal perolehan default sekarang -->
                                    <input 
                                        type="date" 
                                        name="asets[0][tanggal_perolehan]" 
                                        value="{{ old('asets.0.tanggal_perolehan', \Carbon\Carbon::now()->toDateString()) }}"
                                        class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        required
                                    >

                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Lokasi</label>
                                    <select name="asets[0][lokasi_id]" class="w-full border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                                        <option value="">-- Pilih Lokasi --</option>
                                        @foreach ($lokasis as $lokasi)
                                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-aset" class="mt-3 px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">
                        Tambah Aset
                    </button>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ route('logs.aset') }}" class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
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
        let asetIndex = 1;
        const container = document.getElementById('asets-container');

        // Fungsi generate nomor inventaris sementara (di frontend)
        function generateNomorInventaris(select) {
            const code = select.selectedOptions[0].dataset.code || 'XXX';
            const year = new Date().getFullYear();
            const input = select.closest('.aset-item').querySelector('input[readonly]');

            // Hitung jumlah aset dengan kategori yang sama di form
            const items = document.querySelectorAll('.aset-item');
            let count = 0;
            items.forEach(item => {
                const kategoriSelect = item.querySelector('.kategori-select');
                if(kategoriSelect && kategoriSelect.value === select.value) {
                    count++;
                }
            });

            // Buat nomor inventaris incremental
            const seq = String(count).padStart(4, '0');
            input.value = `INV-${code}/${year}/${seq}`;
        }


        // Tambah aset baru
        document.getElementById('add-aset').addEventListener('click', function() {
        const template = container.querySelector('.aset-item').cloneNode(true);
        template.querySelectorAll('input, select').forEach(el => {
            const name = el.getAttribute('name');
            el.setAttribute('name', name.replace(/\d+/, asetIndex));

            if(el.tagName === 'INPUT') {
                if(el.hasAttribute('readonly')) {
                    el.value = 'Otomatis'; // nomor inventaris
                } else if(el.type === 'date') {
                    el.value = new Date().toISOString().split('T')[0]; // tanggal perolehan default sekarang
                } else {
                    el.value = '';
                }
            }

            if(el.tagName === 'SELECT') el.selectedIndex = 0;
        });
        container.appendChild(template);
        asetIndex++;
    });


        // Remove aset
        container.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-aset')) {
                const items = container.querySelectorAll('.aset-item');
                if(items.length > 1) e.target.closest('.aset-item').remove();
            }
        });

        // Update nomor inventaris saat kategori dipilih
        container.addEventListener('change', function(e) {
            if(e.target.classList.contains('kategori-select')) {
                generateNomorInventaris(e.target);
            }
        });
    </script>
</x-app-layout>
