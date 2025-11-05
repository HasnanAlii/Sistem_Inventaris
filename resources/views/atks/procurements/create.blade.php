<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            {{ __('Tambah Pengadaan Alat Kantor') }}
        </h2>
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-gray-100">

                {{-- 🧾 Judul Form --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 pl-4 border-l-4 border-blue-500">
                        Form Tambah Pengadaan Alat Kantor
                    </h3>
                    <p class="text-sm text-gray-500">
                        Lengkapi data berikut untuk menambahkan pengadaan alat kantor baru.
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
                <form action="{{ route('atkprocurements.store') }}" method="POST" class="space-y-6" id="atk-form">
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
                            <input type="text" name="jumlah" class="jumlah-ribuan w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm" required>
                        </div>
                    </div>

                    {{-- Biaya & Tanggal Pengadaan --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-2">Biaya (Rp)</label>
                            <input type="text" name="biaya" id="biaya"
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
                        <label class="block text-base font-semibold text-gray-700 mb-2">Daftar Barang</label>
                        <div id="atks-container" class="space-y-5">
                            <div class="atk-item border border-gray-200 p-5 rounded-xl relative bg-gray-50">
                                <button type="button"
                                    class="remove-atk absolute top-2 right-3 text-red-500 font-bold text-xl">×</button>

                                {{-- Nama & Kategori --}}
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                                        <input type="text" name="atk_items[0][nama_barang]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                        <select name="atk_items[0][kategori_id]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Satuan & Stok --}}
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                        <input type="text" name="atk_items[0][stok]"
                                            class="stok-ribuan w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                                        <input type="text" name="atk_items[0][satuan]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            placeholder="misal: pcs, box, rim" required>
                                    </div>
                                </div>

                                {{-- Harga dan Tanggal --}}
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan (Rp)</label>
                                        <input type="text" name="atk_items[0][harga_satuan]"
                                            class="harga-ribuan w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                                        <input type="date" name="atk_items[0][tanggal_masuk]"
                                            value="{{ old('atk_items.0.tanggal_masuk', \Carbon\Carbon::now()->toDateString()) }}"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Tambah ATK --}}
                        <button type="button" id="add-atk"
                            class="mt-3 px-5 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-md transition text-base font-semibold">
                            + Tambah Barang
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

        function formatRibuan(input) {
            input.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        }

        document.querySelectorAll('.jumlah-ribuan, .stok-ribuan, .harga-ribuan, #biaya').forEach(el => formatRibuan(el));

        // Hapus titik sebelum submit
        document.getElementById('atk-form').addEventListener('submit', function(e) {
            const cleanNumber = (str) => str.replace(/\./g, '');
            this.querySelector('[name="jumlah"]').value = cleanNumber(this.querySelector('[name="jumlah"]').value);
            this.querySelector('[name="biaya"]').value = cleanNumber(this.querySelector('[name="biaya"]').value);
            this.querySelectorAll('.stok-ribuan').forEach(el => el.value = cleanNumber(el.value));
            this.querySelectorAll('.harga-ribuan').forEach(el => el.value = cleanNumber(el.value));
        });

        // Tambah ATK
        document.getElementById('add-atk').addEventListener('click', function() {
            const template = container.querySelector('.atk-item').cloneNode(true);
            template.querySelectorAll('input, select').forEach(el => {
                const name = el.getAttribute('name');
                el.setAttribute('name', name.replace(/\d+/, atkIndex));

                if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else if (el.type === 'date') {
                    el.value = new Date().toISOString().split('T')[0];
                } else {
                    el.value = '';
                }
            });
            container.appendChild(template);
            template.querySelectorAll('.stok-ribuan, .harga-ribuan').forEach(el => formatRibuan(el));
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
