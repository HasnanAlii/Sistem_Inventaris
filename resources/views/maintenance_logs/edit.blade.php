<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Riwayat Perbaikan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('maintenance.update', $maintenanceLog->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium">Aset</label>
                        <select name="aset_id" class="w-full border-gray-300 rounded">
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id }}" @selected($maintenanceLog->aset_id == $aset->id)>
                                    {{ $aset->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $maintenanceLog->tanggal }}" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Jenis Perbaikan</label>
                        <input type="text" name="jenis_perbaikan" value="{{ $maintenanceLog->jenis_perbaikan }}" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Biaya</label>
                        <input type="number" name="biaya" value="{{ $maintenanceLog->biaya }}" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Keterangan</label>
                        <textarea name="keterangan" class="w-full border-gray-300 rounded" rows="3">{{ $maintenanceLog->keterangan }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('maintenance.index') }}" class="mr-3 text-gray-600 hover:underline">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
