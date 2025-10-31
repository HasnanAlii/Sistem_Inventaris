<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Barang ATK') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded-lg">
            <table class="w-full text-sm">
                <tr><td class="font-semibold w-40">Kode Barang</td><td>{{ $atk->kode_barang }}</td></tr>
                <tr><td class="font-semibold">Nama Barang</td><td>{{ $atk->nama_barang }}</td></tr>
                <tr><td class="font-semibold">Satuan</td><td>{{ $atk->satuan }}</td></tr>
                <tr><td class="font-semibold">Stok</td><td>{{ $atk->stok }}</td></tr>
                <tr><td class="font-semibold">Stok Minimum</td><td>{{ $atk->stok_minimum }}</td></tr>
                <tr><td class="font-semibold">Harga Satuan</td><td>Rp {{ number_format($atk->harga_satuan, 0, ',', '.') }}</td></tr>
                {{-- <tr><td class="font-semibold">Kondisi</td><td class="capitalize">{{ $atk->kondisi }}</td></tr> --}}
                <tr><td class="font-semibold">Tanggal Masuk</td><td>{{ $atk->tanggal_masuk }}</td></tr>
                <tr><td class="font-semibold">Keterangan</td><td>{{ $atk->keterangan }}</td></tr>
            </table>

            <div class="mt-4 flex justify-end">
                <a href="{{ route('atks.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
