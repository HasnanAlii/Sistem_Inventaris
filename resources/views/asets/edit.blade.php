<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            🛠️ {{ __('Edit Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8">

                {{-- 🧾 Judul Form --}}
                <h3 class="text-xl font-semibold text-gray-800 mb-6 pl-4 border-l-4 border-blue-500">
                    Form Edit Aset
                </h3>

                <form method="POST" action="{{ route('asets.update', $aset) }}" class="space-y-6">
                    @csrf
                    @method('PUT')                    
                    {{-- Grid: Harga & Kondisi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           {{-- Lokasi --}}
                           <div>
                               <label class="block font-semibold text-gray-700 mb-2">Lokasi</label>
                               <select name="lokasi_id"
                                   class="w-full border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                   required>
                                   @foreach ($lokasis as $lokasi)
                                       <option value="{{ $lokasi->id }}" {{ $aset->lokasi_id == $lokasi->id ? 'selected' : '' }}>
                                           {{ $lokasi->nama }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                        

                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Kondisi</label>
                            <select name="kondisi"
                                class="w-full border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                required>
                                @foreach (['baru' => 'Baru', 'baik' => 'Baik', 'rusak_ringan' => 'Rusak Ringan', 'rusak_berat' => 'Rusak Berat'] as $key => $label)
                                    <option value="{{ $key }}" {{ $aset->kondisi == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-3 pt-4">
                        <a href="{{ route('asets.index') }}"
                            class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
