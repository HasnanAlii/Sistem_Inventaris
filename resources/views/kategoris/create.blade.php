<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori Aset') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-6">

            <form action="{{ route('kategoris.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-semibold mb-1">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Kode</label>
                    <input type="text" name="kode" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" rows="4"></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('kategoris.index') }}" 
                       class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
