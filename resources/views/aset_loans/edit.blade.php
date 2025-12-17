<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
             {{ __('Konfirmasi Peminjaman Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">
                
                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Konfirmasi Status Peminjaman
                </h3>

                <form action="{{ route('aset_loans.update', $asetLoan) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Aset --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nama Aset</label>
                        <input type="text" value="{{ $asetLoan->aset->nama }}"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 bg-gray-100 focus:outline-none" disabled>
                    </div>

                    {{-- Jumlah --}}
                    {{-- <div>
                        <label class="block font-semibold text-gray-700 mb-2">Jumlah</label>
                        <input type="text" value="{{ $asetLoan->jumlah }}"
                            class="w-full border-gray-300 rounded-lg py-2 px-3 bg-gray-100 focus:outline-none" disabled>
                    </div> --}}
                    <input type="hidden" name="jumlah" id="jumlah" value="1">


                    {{-- Status --}}
                    <div>
                        <label for="status" class="block font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" id="status"
                            class="w-full border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                            <option value="Disetujui" @selected($asetLoan->status == 'Disetujui')>
                                Setujui
                            </option>
                            {{-- <option value="Menunggu Konfirmasi" @selected($asetLoan->status == 'Menunggu Konfirmasi')>
                                Menunggu Konfirmasi
                            </option> --}}
                            <option value="Ditolak" @selected($asetLoan->status == 'Ditolak')>
                                Tolak
                            </option>
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-4">
                        <a href="{{ route('aset_loans.index') }}"
                            class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Perbarui Status
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
