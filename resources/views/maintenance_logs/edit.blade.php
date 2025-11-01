<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __(' Riwayat Perbaikan Aset') }}
        </h2>
    </x-slot>

    <div class="py-10  min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">

                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Ubah Perbaikan Aset
                </h3>
                <form action="{{ route('maintenance.update', $maintenanceLog->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Pilih Aset --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Pilih Aset</label>
                        <select name="aset_id"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id }}"
                                    {{ old('aset_id', $maintenanceLog->aset_id) == $aset->id ? 'selected' : '' }}>
                                    {{ $aset->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('aset_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Perbaikan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Tanggal Perbaikan</label>
                        <input type="date" name="tanggal"
                        value="{{ old('tanggal', \Carbon\Carbon::parse($maintenanceLog->tanggal)->format('Y-m-d')) }}"
                        class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required>

                        @error('tanggal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Perbaikan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Jenis Perbaikan</label>
                        <input type="text" name="jenis_perbaikan"
                            value="{{ old('jenis_perbaikan', $maintenanceLog->jenis_perbaikan) }}"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Contoh: Ganti Komponen, Kalibrasi, Pembersihan">
                        @error('jenis_perbaikan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Biaya --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Biaya (Rp)</label>
                        <input type="number" name="biaya"
                            value="{{ old('biaya', $maintenanceLog->biaya) }}"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            step="0.01" placeholder="Masukkan biaya perbaikan">
                        @error('biaya')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Tambahkan catatan mengenai perbaikan (opsional)...">{{ old('keterangan', $maintenanceLog->keterangan) }}</textarea>
                        @error('keterangan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-4">
                        <a href="{{ route('maintenance.index') }}"
                            class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                             Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
