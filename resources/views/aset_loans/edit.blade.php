<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Peminjaman Aset') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl p-6">

                <form action="{{ route('aset_loans.update', $asetLoan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Aset (hanya tampil) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Aset</label>
                        <input type="text" value="{{ $asetLoan->aset->nama }}" class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-100" disabled>
                    </div>

                    <!-- Jumlah (hanya tampil) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                        <input type="text" value="{{ $asetLoan->jumlah }}" class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-100" disabled>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 rounded-lg" required>
                            <option value="Menunggu Konfirmasi" @selected($asetLoan->status == 'Menunggu Konfirmasi')>Menunggu Konfirmasi</option>
                            <option value="Disetujui" @selected($asetLoan->status == 'Disetujui')>Disetujui</option>
                            <option value="Ditolak" @selected($asetLoan->status == 'Ditolak')>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('aset_loans.index') }}" 
                           class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
                        <button type="submit" 
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Simpan Status</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
