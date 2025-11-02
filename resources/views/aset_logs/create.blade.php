<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            {{ __('Tambah Pengadaan Aset') }}
        </h2>
    </x-slot>

    <div class=" min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-gray-100">

                {{-- 🧾 Judul Form --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                         Form Tambah Pengadaan Aset
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Lengkapi data berikut untuk menambahkan pengadaan aset baru.
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
                <form action="{{ route('aset_logs.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Pengadaan & Jumlah --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-2">Nama Pengadaan</label>
                            <input type="text" name="nama_barang"
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

                    {{-- Daftar Aset --}}
                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-2">Daftar Aset</label>
                        <div id="asets-container" class="space-y-5">
                            <div class="aset-item border border-gray-200 p-5 rounded-xl relative bg-gray-50">
                                <button type="button"
                                    class="remove-aset absolute top-2 right-3 text-red-500 font-bold text-xl">×</button>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                                        <input type="text" name="asets[0][nama]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Inventaris</label>
                                        <input type="text" name="asets[0][nomor_inventaris]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 bg-gray-100 text-gray-600 cursor-not-allowed shadow-sm"
                                            readonly placeholder="Otomatis">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                        <select name="asets[0][kategori_id]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm kategori-select"
                                            required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    data-code="{{ strtoupper(substr($kategori->nama, 0, 3)) }}">
                                                    {{ $kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                        <input type="number" name="asets[0][harga]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Perolehan</label>
                                        <input type="date" name="asets[0][tanggal_perolehan]"
                                            value="{{ old('asets.0.tanggal_perolehan', \Carbon\Carbon::now()->toDateString()) }}"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                        <select name="asets[0][lokasi_id]"
                                            class="w-full text-base border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                                            required>
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($lokasis as $lokasi)
                                                <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-aset"
                            class="mt-3 px-5 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-md transition text-base font-semibold">
                            + Tambah Aset
                        </button>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('logs.aset') }}"
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
        let asetIndex = 1;
        const container = document.getElementById('asets-container');

        function generateNomorInventaris(select) {
            const code = select.selectedOptions[0].dataset.code || 'XXX';
            const year = new Date().getFullYear();
            const input = select.closest('.aset-item').querySelector('input[readonly]');
            const items = document.querySelectorAll('.aset-item');
            let count = 0;
            items.forEach(item => {
                const kategoriSelect = item.querySelector('.kategori-select');
                if (kategoriSelect && kategoriSelect.value === select.value) count++;
            });
            const seq = String(count).padStart(4, '0');
            input.value = `INV-${code}/${year}/${seq}`;
        }

        document.getElementById('add-aset').addEventListener('click', function() {
            const template = container.querySelector('.aset-item').cloneNode(true);
            template.querySelectorAll('input, select').forEach(el => {
                const name = el.getAttribute('name');
                el.setAttribute('name', name.replace(/\d+/, asetIndex));

                if (el.tagName === 'INPUT') {
                    if (el.hasAttribute('readonly')) {
                        el.value = 'Otomatis';
                    } else if (el.type === 'date') {
                        el.value = new Date().toISOString().split('T')[0];
                    } else {
                        el.value = '';
                    }
                }
                if (el.tagName === 'SELECT') el.selectedIndex = 0;
            });
            container.appendChild(template);
            asetIndex++;
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-aset')) {
                const items = container.querySelectorAll('.aset-item');
                if (items.length > 1) e.target.closest('.aset-item').remove();
            }
        });

        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('kategori-select')) generateNomorInventaris(e.target);
        });
    </script>
</x-app-layout>
