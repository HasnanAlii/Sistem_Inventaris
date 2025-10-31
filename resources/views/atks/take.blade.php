<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Permintaan ATK') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('atks.request.store') }}" method="POST">
                    @csrf

                    {{-- Pilih ATK --}}
                    <div class="mb-4">
                        <label for="atk_id" class="block font-semibold mb-1">Pilih Barang</label>
                        <select name="atk_id" id="atk_id" class="w-full border rounded-lg px-3 py-2" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($atks as $atk)
                                <option value="{{ $atk->id }}">
                                    {{ $atk->nama_barang }} (Stok: {{ $atk->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('atk_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Jumlah Permintaan</label>
                        <input type="number" name="jumlah" min="1" class="w-full border rounded-lg px-3 py-2" required>
                        @error('jumlah')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- Keterangan opsional --}}
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Keterangan (opsional)</label>
                        <textarea name="keterangan" class="w-full border rounded-lg px-3 py-2" rows="3" placeholder="Contoh: Untuk kebutuhan kantor bagian administrasi..."></textarea>
                        @error('keterangan')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('logs.list') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Kirim Permintaan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
