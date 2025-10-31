<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Detail Permintaan ATK') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

                <div>
                    <label class="block font-semibold mb-1">Nama Barang</label>
                    <input type="text" value="{{ $atkLog->atk->nama_barang ?? '-' }}"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Pemohon</label>
                    <input type="text" value="{{ $atkLog->user->name ?? 'Tidak diketahui' }}"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Jumlah Diminta</label>
                    <input type="text" value="{{ $atkLog->jumlah }}"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tanggal Permintaan</label>
                    <input type="text" value="{{ $atkLog->tanggal_permintaan ? $atkLog->tanggal_permintaan->format('d/m/Y') : '-' }}"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tanggal Persetujuan</label>
                    <input type="text" value="{{ $atkLog->tanggal_persetujuan ? $atkLog->tanggal_persetujuan->format('d/m/Y') : '-' }}"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Status Permintaan</label>
                    @php
                        $statusColors = [
                            'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700',
                            'Disetujui' => 'bg-green-100 text-green-700',
                            'Ditolak' => 'bg-red-100 text-red-700',
                            'Selesai' => 'bg-blue-100 text-blue-700',
                        ];
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-lg font-semibold text-sm {{ $statusColors[$atkLog->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $atkLog->status }}
                    </span>
                </div>

                <div class="flex justify-end mt-6 space-x-2">
                    <a href="{{ route('logs.list') }}"
                       class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">
                        Kembali
                    </a>

                    {{-- Jika admin, tampilkan tombol konfirmasi --}}
                    {{-- @if(Auth::user() && Auth::user()->role === 'admin' && $atkLog->status === 'Menunggu Konfirmasi') --}}
                  @if ($atkLog->status === 'Menunggu Konfirmasi')
                    <div class="flex space-x-3">
                        <!-- Tombol Tolak -->
                        <form action="{{ route('atk_logs.reject', $atkLog) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                Tolak
                            </button>
                        </form>
                        <!-- Tombol Setujui -->
                        <form action="{{ route('atk_logs.approve', $atkLog) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Setujui
                            </button>
                        </form>

                    </div>
                @endif

                    {{-- @endif --}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
