<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
            🧾 {{ __('Detail Penilaian Aset') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">

                {{-- 🧩 Informasi Penilaian --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                        🧩 Informasi Penilaian
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail lengkap hasil penilaian terhadap aset terkait.
                    </p>
                </div>

                <table class="w-full border-collapse text-sm mb-8">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th class="text-left w-1/3 py-3 text-gray-600 font-medium">Nama Aset</th>
                            <td class="py-3 text-gray-800 font-semibold">
                                {{ $assessment->aset->nama ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Kondisi</th>
                            <td class="py-3">
                                <span class="@if($assessment->condition == 'baik') text-green-600 
                                            @elseif($assessment->condition == 'rusak ringan') text-yellow-600
                                            @elseif($assessment->condition == 'rusak berat') text-red-600
                                            @else text-gray-600 @endif font-semibold capitalize">
                                    {{ $assessment->condition ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Skor</th>
                            <td class="py-3 text-blue-700 font-semibold">
                                {{ $assessment->score ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Catatan</th>
                            <td class="py-3 text-gray-800">{{ $assessment->notes ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-3 text-gray-600 font-medium">Tanggal Penilaian</th>
                            <td class="py-3 text-gray-800">
                                {{ $assessment->created_at ? $assessment->created_at->translatedFormat('d F Y H:i') : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between items-center">
                    <a href="{{ route('assessments.index') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('assessments.edit', $assessment) }}"
                            class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2.5 rounded-lg hover:bg-blue-600 transition">
                             Edit
                        </a>

                      
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
