<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Aset') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <form action="{{ route('aset_loans.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="aset_id" class="block text-gray-700 font-medium mb-2">Pilih Aset</label>
                        <select name="aset_id" id="aset_id" class="w-full border-gray-300 rounded-lg" required>
                            <option value="">-- Pilih Aset --</option>
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id }}">{{ $aset->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="jumlah" class="block text-gray-700 font-medium mb-2">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" min="1" value="1"
                               class="w-full border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_pinjam" class="block text-gray-700 font-medium mb-2">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                               class="w-full border-gray-300 rounded-lg px-3 py-2" required>
                    </div>


                    <div class="flex justify-end gap-2">
                        <a href="{{ route('aset_loans.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajukan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
