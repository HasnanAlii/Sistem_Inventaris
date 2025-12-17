<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            {{ __('Edit Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">

                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Edit Aset
                </h3>

                <form method="POST" action="{{ route('asets.update', $aset) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nomor Inventaris --}}
                    <div>
                        <label class="font-semibold text-gray-700">Nomor Inventaris</label>
                        <input type="text" name="nomor_inventaris" value="{{ old('nomor_inventaris', $aset->nomor_inventaris) }}"
                            class="w-full border-gray-300 rounded-lg py-2 bg-gray-100" disabled>
                    </div>

                    {{-- Nama Aset --}}
                    <div>
                        <label class="font-semibold text-gray-700">Nama Aset</label>
                        <input type="text" name="nama" value="{{ old('nama', $aset->nama) }}"
                            class="w-full border-gray-300 rounded-lg py-2" required>
                    </div>

                    {{-- Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Kategori --}}
                        <div>
                            <label class="font-semibold text-gray-700">Kategori</label>
                            <select name="kategori_id" class="w-full border-gray-300 rounded-lg py-2" required>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ $aset->kategori_id == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="font-semibold text-gray-700">Lokasi</label>
                            <select name="lokasi_id" class="w-full border-gray-300 rounded-lg py-2" required>
                                @foreach ($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}"
                                        {{ $aset->lokasi_id == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Merek --}}
              

                        {{-- Tanggal Perolehan --}}
                  

                        {{-- Umur Ekonomis --}}
                        <div>
                            <label class="font-semibold text-gray-700">Umur Ekonomis (Bulan)</label>
                            <input type="number" name="umur_ekonomis" value="{{ $aset->umur_ekonomis }}"
                                class="w-full border-gray-300 rounded-lg py-2">
                        </div>

                           {{-- Harga --}}
                        <div>
                            <label class="font-semibold text-gray-700">Harga</label>

                            {{-- Input tampilan --}}
                            <input type="text" id="harga_view"
                                value="{{ number_format($aset->harga, 0, ',', '.') }}"
                                class="w-full border-gray-300 rounded-lg py-2"
                                placeholder="Rp 0">

                            {{-- Input asli (dikirim ke backend) --}}
                            <input type="hidden" name="harga" id="harga">
                        </div>
                        <script>
                            const hargaView = document.getElementById('harga_view');
                            const hargaHidden = document.getElementById('harga');

                            // set nilai awal
                            hargaHidden.value = "{{ $aset->harga }}";

                            hargaView.addEventListener('input', function () {
                                let value = this.value.replace(/[^0-9]/g, '');

                                hargaHidden.value = value;

                                this.value = value
                                    ? new Intl.NumberFormat('id-ID').format(value)
                                    : '';
                            });
                        </script>



                        {{-- Kondisi --}}
                        <div>
                            <label class="font-semibold text-gray-700">Kondisi</label>
                            <select name="kondisi" class="w-full border-gray-300 rounded-lg py-2" required>
                                @foreach ([
                                    'baru' => 'Baru',
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_berat' => 'Rusak Berat'
                                ] as $key => $label)
                                    <option value="{{ $key }}" {{ $aset->kondisi == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="font-semibold text-gray-700">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg py-2">
                           @foreach (['aktif' => 'Tersedia', 'nonaktif' => 'Tidak Tersedia'] as $key => $label)
                                <option value="{{ $key }}" {{ $aset->status == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-3 pt-6">
                        <a href="{{ route('asets.index') }}"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
