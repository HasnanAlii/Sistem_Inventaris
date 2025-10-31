<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">🔍 Detail Penilaian</h2>

            <table class="w-full border-collapse">
                <tr>
                    <td class="py-2 font-semibold w-1/3">Nama Aset</td>
                    <td class="py-2">{{ $assessment->aset->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Kondisi</td>
                    <td class="py-2 capitalize">{{ $assessment->condition }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Skor</td>
                    <td class="py-2 font-semibold text-blue-700">{{ $assessment->score }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Catatan</td>
                    <td class="py-2">{{ $assessment->notes ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Tanggal Penilaian</td>
                    <td class="py-2">{{ $assessment->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('assessments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">⬅️ Kembali</a>
                <a href="{{ route('assessments.edit', $assessment) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
            </div>
        </div>
    </div>
</x-app-layout>
