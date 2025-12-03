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
                    <p class="text-sm text-gray-500">Lengkapi data berikut untuk menambahkan pengadaan ATK.</p>
                </div>

                {{-- Error --}}
                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- 📋 FORM --}}
                <form action="{{ route('atkprocurements.store') }}" method="POST" id="atk-form" class="space-y-6">
                    @csrf

                    {{-- Nama Pengadaan + Jumlah --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Nama Pengadaan</label>
                            <input type="text" name="nama_pengadaan"
                                class="w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Jumlah Barang</label>
                            <input type="text" name="jumlah" id="jumlah" readonly
                                class="w-full border-gray-300 bg-gray-100 cursor-not-allowed rounded-lg px-3 py-2.5 shadow-sm">
                        </div>
                    </div>

                    {{-- Biaya + Tanggal --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Total Biaya (Rp)</label>
                            <input type="text" name="biaya" id="biaya" readonly
                                class="w-full border-gray-300 bg-gray-100 cursor-not-allowed rounded-lg px-3 py-2.5 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Tanggal Pengadaan</label>
                            <input type="date" name="tanggal_pengadaan"
                                value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                class="w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm">
                        </div>
                    </div>

                    {{-- LIST ATK --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Daftar Barang</label>

                        <div id="atks-container" class="space-y-5">

                            {{-- ITEM PERTAMA --}}
                            <div class="atk-item border border-gray-200 p-5 rounded-xl relative bg-gray-50">
                                <button type="button"
                                    class="remove-atk absolute top-2 right-3 text-red-500 font-bold text-xl">×</button>

                                {{-- Nama + Kategori --}}
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm mb-1 font-medium">Nama Barang</label>
                                        <input type="text" name="atk_items[0][nama_barang]"
                                            class="w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1 font-medium">Kategori</label>
                                        <select name="atk_items[0][kategori_id]"
                                            class="w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Stok + Satuan --}}
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm mb-1 font-medium">Jumlah</label>
                                        <input type="text" name="atk_items[0][stok]"
                                            class="stok-ribuan w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1 font-medium">Satuan</label>
                                        <input type="text" name="atk_items[0][satuan]"
                                            class="w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm" required>
                                    </div>
                                </div>

                                {{-- Harga + Tanggal --}}
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm mb-1 font-medium">Harga Satuan (Rp)</label>
                                        <input type="text" name="atk_items[0][harga_satuan]"
                                            class="harga-ribuan w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1 font-medium">Tanggal Masuk</label>
                                        <input type="date" name="atk_items[0][tanggal_masuk]"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                            class="w-full border-gray-300 rounded-lg px-3 py-2.5 shadow-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tambah barang --}}
                        <button type="button" id="add-atk"
                            class="mt-3 px-5 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-md font-semibold">
                            + Tambah Barang
                        </button>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('logs.addatk') }}"
                            class="px-4 py-2.5 border rounded-lg hover:bg-gray-100 text-gray-700 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>

                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-md">
                            Simpan Pengadaan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        let atkIndex = 1;
        const container = document.getElementById('atks-container');

        /* FORMAT RIBUAN */
        function applyRibuan(el) {
            el.addEventListener("input", () => {
                let v = el.value.replace(/\D/g, "");
                el.value = v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                hitungBiaya();
            });
        }

        /* JUMLAH BARANG OTOMATIS */
        function hitungJumlah() {
            let total = document.querySelectorAll('.atk-item').length;
            document.getElementById('jumlah').value = total;
        }

        /* HITUNG TOTAL BIAYA = Σ(stok × harga_satuan) */
        function hitungBiaya() {
            const clean = n => n.replace(/\./g, '') || 0;
            let total = 0;

            document.querySelectorAll('.atk-item').forEach(item => {
                let stok = clean(item.querySelector('.stok-ribuan').value);
                let harga = clean(item.querySelector('.harga-ribuan').value);
                total += (parseInt(stok) || 0) * (parseInt(harga) || 0);
            });

            document.getElementById("biaya").value =
                total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            hitungJumlah();
        }

        /* Terapkan format ribuan ke input awal */
        document.querySelectorAll('.stok-ribuan, .harga-ribuan').forEach(applyRibuan);

        /* TAMBAH BARANG */
        document.getElementById('add-atk').addEventListener('click', () => {
            let template = container.querySelector('.atk-item').cloneNode(true);

            template.querySelectorAll("input, select").forEach(el => {
                el.name = el.name.replace(/\d+/, atkIndex);
                if (el.type === "date") {
                    el.value = new Date().toISOString().split("T")[0];
                } else {
                    el.value = "";
                }
                if (el.classList.contains("stok-ribuan") || el.classList.contains("harga-ribuan")) {
                    applyRibuan(el);
                }
            });

            container.appendChild(template);
            atkIndex++;
            hitungBiaya();
        });

        /* HAPUS BARANG */
        container.addEventListener('click', e => {
            if (e.target.classList.contains('remove-atk')) {
                let items = container.querySelectorAll('.atk-item');
                if (items.length > 1) {
                    e.target.closest('.atk-item').remove();
                    hitungBiaya();
                }
            }
        });

        /* CLEAN DATA SEBELUM SUBMIT */
        document.getElementById('atk-form').addEventListener('submit', () => {
            const clean = n => n.replace(/\./g, '');
            document.getElementById('biaya').value = clean(document.getElementById('biaya').value);
            document.getElementById('jumlah').value = clean(document.getElementById('jumlah').value);

            document.querySelectorAll('.stok-ribuan, .harga-ribuan').forEach(el => {
                el.value = clean(el.value);
            });
        });

        /* INISIALISASI */
        hitungBiaya();
    </script>

</x-app-layout>
