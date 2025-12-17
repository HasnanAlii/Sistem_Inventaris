<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Aset') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi Halaman -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">

        @hasrole('petugas')
        <a href="{{ route('asets.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('asets.*') 
                      ? 'bg-amber-200 border-amber-600 text-amber-900 shadow-lg' 
                      : 'border-amber-400 text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-500 hover:text-amber-800' }}">
            <i data-feather='package' class="w-6 h-6"></i>
            List Inventaris
        </a>

        <a href="{{ route('maintenance.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('maintenance.*') 
                      ? 'bg-green-200 border-green-600 text-green-900 shadow-lg' 
                      : 'border-green-400 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-500 hover:text-green-800' }}">
            <i data-feather="tool" class="w-6 h-6"></i>
            Riwayat Perbaikan
        </a>

        <a href="{{ route('assessments.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('assessments.*') 
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-lg' 
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="check-circle" class="w-6 h-6"></i>
            Penilaian Kelayakan
        </a>
        @endhasrole

        <a href="{{ route('aset_loans.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('aset_loans.*') 
                      ? 'bg-cyan-200 border-cyan-600 text-cyan-900 shadow-lg' 
                      : 'border-cyan-400 text-cyan-700 bg-cyan-50 hover:bg-cyan-100 hover:border-cyan-500 hover:text-cyan-800' }}">
            <i data-feather="clipboard" class="w-6 h-6"></i>
            Peminjaman Aset
        </a>
    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header Tabel -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-cyan-50 to-sky-50 rounded-t-2xl shadow-sm">

                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="clipboard" class="w-6 h-6 text-cyan-600"></i>
                        Daftar Peminjaman Aset
                    </h3>
                    @role('pegawai')
                    <a href="{{ route('aset_loans.create') }}"
                       class="flex items-center gap-2 bg-cyan-600 text-white px-5 py-2 rounded-xl font-medium 
                              hover:bg-cyan-700 hover:shadow-lg transition-all duration-200">
                        <i data-feather="plus-circle" class="w-5 h-5"></i>
                        Tambah Peminjaman
                    </a>
                    @endhasrole
                </div>


                <!-- ✅ Pesan sukses -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-700 bg-green-50 border border-green-200 rounded-lg shadow-sm text-base">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- 📋 Tabel Data -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200 text-base">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Nama Aset</th>
                                <th class="px-5 py-3 text-left">Pemohon</th>
                                {{-- <th class="px-5 py-3 text-center">Jumlah</th> --}}
                                <th class="px-5 py-3 text-center">Tanggal Pinjam</th>
                                <th class="px-5 py-3 text-center">Tanggal Kembali</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr class="hover:bg-cyan-50 transition duration-150">
                                    <td class="px-5 py-3">{{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}</td>
                                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $loan->aset->nama ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-600">{{ $loan->user->name ?? '-' }}</td>
                                    {{-- <td class="px-5 py-3 text-center">{{ $loan->jumlah }}</td> --}}
                                    <td class="px-5 py-3 text-center text-gray-600">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td class="px-5 py-3 text-center text-gray-600">
                                        {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') : '-' }}
                                    </td>

                                    <td class="px-5 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($loan->status == 'Disetujui') bg-green-100 text-green-800
                                            @elseif($loan->status == 'Ditolak') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <div class="flex justify-center gap-3 flex-wrap">
                                            @role('petugas')
                                            @if($loan->status == 'Menunggu Konfirmasi')
                                                <a href="{{ route('aset_loans.edit', $loan) }}" 
                                                   class="text-yellow-600 hover:text-yellow-800 font-medium transition">
                                                   Edit
                                                </a>
                                            @elseif($loan->status == 'Dikembalikan')
                                                   <button onclick="openbuktiModal('{{ asset('storage/' . $loan->bukti) }}')" 
                                                            class="text-blue-600 hover:text-blue-800 font-medium transition flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        Lihat Bukti
                                                    </button>
                                            @endif
                                            @endrole

                                            @role('pegawai')
                                                @if($loan->status == 'Disetujui')
                                                    <button onclick="openReturnModal('{{ route('aset_loans.return', $loan) }}')" 
                                                            class="text-green-600 hover:text-green-800 font-medium transition">
                                                        Kembalikan
                                                    </button>
                                                @elseif($loan->status == 'Dikembalikan')
                                                   <button onclick="openbuktiModal('{{ asset('storage/' . $loan->bukti) }}')" 
                                                            class="text-blue-600 hover:text-blue-800 font-medium transition flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        Lihat Bukti
                                                    </button>
                                                @endif
                                            @endrole
                                            <div id="buktiModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300" onclick="closeBuktiModal()">
    
                                                <div class="relative w-full max-w-3xl transform rounded-2xl bg-white p-2 shadow-2xl transition-all scale-95 opacity-0" id="buktiModalContent" onclick="event.stopPropagation()">
                                                    
                                                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                                                        <h3 class="text-lg font-bold text-gray-800">Bukti Pengembalian</h3>
                                                        <button onclick="closeBuktiModal()" class="rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-red-500 transition">
                                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>

                                                    <div class="flex items-center justify-center bg-gray-50 p-4 rounded-b-xl min-h-[300px]">
                                                        <img id="modalBuktiImage" src="" alt="Bukti Aset" 
                                                            class="max-h-[70vh] w-auto max-w-full rounded-lg shadow-sm border border-gray-200 object-contain">
                                                            
                                                        <p id="noImageText" class="hidden text-gray-500 text-sm">Gambar tidak dapat dimuat.</p>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Modal Pengembalian -->
                                            <div id="returnModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300">
                                                <div class="relative w-full max-w-lg transform rounded-2xl bg-white p-8 shadow-2xl transition-all sm:scale-100">
                                                    
                                                    <div class="mb-6 flex items-center justify-between">
                                                        <div>
                                                            <h2 class="text-2xl font-bold text-gray-800">Kembalikan Aset</h2>
                                                            <p class="text-sm text-gray-500 mt-1">Unggah bukti kondisi aset saat ini.</p>
                                                        </div>
                                                        <button onclick="closeReturnModal()" class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600">
                                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>

                                                    <form id="returnForm" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="mb-6">
                                                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                                                Bukti Pengembalian <span class="text-red-500">*</span>
                                                            </label>
                                                            
                                                            <div class="relative flex min-h-[200px] w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                                                                
                                                                <input type="file" name="bukti" id="buktiInput" accept="image/*" 
                                                                    class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
                                                                    required onchange="handleFilePreview(this)">

                                                                <div id="uploadPlaceholder" class="flex flex-col items-center justify-center text-center p-4">
                                                                    <div class="mb-3 rounded-full bg-blue-100 p-3 text-blue-600 group-hover:scale-110 transition-transform">
                                                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                    </div>
                                                                    <p class="text-sm font-medium text-gray-700">Klik untuk upload foto</p>
                                                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG (Max. 10MB)</p>
                                                                </div>

                                                                <div id="imagePreviewContainer" class="absolute inset-0 z-20 hidden h-full w-full items-center justify-center rounded-xl bg-gray-100 p-2">
                                                                    <img id="imagePreview" src="" alt="Preview" class="h-full w-full rounded-lg object-contain">
                                                                    
                                                                    <button type="button" onclick="removeFile()" class="absolute top-2 right-2 rounded-full bg-white p-1 shadow-md hover:bg-red-50 hover:text-red-600 z-30 border border-gray-200" title="Hapus foto">
                                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                                            <button type="button" onclick="closeReturnModal()"
                                                                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-100 transition">
                                                                Batal
                                                            </button>
                                                            <button type="submit"
                                                                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg shadow-blue-500/30 transition">
                                                                Konfirmasi Kembalikan
                                                            </button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>


                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-6">Belum ada peminjaman aset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl text-base">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
    function openbuktiModal(imageUrl) {
        const modal = document.getElementById('buktiModal');
        const modalContent = document.getElementById('buktiModalContent');
        const imageEl = document.getElementById('modalBuktiImage');
        const noImageText = document.getElementById('noImageText');

        // Reset state
        imageEl.classList.remove('hidden');
        noImageText.classList.add('hidden');

        // Set source gambar
        if (imageUrl) {
            imageEl.src = imageUrl;
            
            // Error handling jika gambar broken
            imageEl.onerror = function() {
                imageEl.classList.add('hidden');
                noImageText.classList.remove('hidden');
            };
        } else {
            imageEl.classList.add('hidden');
            noImageText.classList.remove('hidden');
        }

        // Tampilkan Modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Animasi Masuk
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeBuktiModal() {
        const modal = document.getElementById('buktiModal');
        const modalContent = document.getElementById('buktiModalContent');
        const imageEl = document.getElementById('modalBuktiImage');

        // Animasi Keluar
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            imageEl.src = ''; // Bersihkan src agar tidak flashing saat dibuka lagi
        }, 300);
    }

    // Menutup modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeBuktiModal();
        }
    });

    function openReturnModal(url) {
        document.getElementById('returnForm').action = url;
        document.getElementById('returnModal').classList.remove('hidden');
        document.getElementById('returnModal').classList.add('flex');
    }

    function closeReturnModal() {
        document.getElementById('returnModal').classList.add('hidden');
        document.getElementById('returnModal').classList.remove('flex');
        document.getElementById('bukti').value = "";
    }
    function handleFilePreview(input) {
    const placeholder = document.getElementById('uploadPlaceholder');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            // Sembunyikan placeholder, tampilkan preview
            placeholder.classList.add('hidden'); // Sembunyikan teks upload
            previewContainer.classList.remove('hidden'); // Munculkan gambar
            previewContainer.classList.add('flex');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function removeFile() {
    const input = document.getElementById('buktiInput');
    const placeholder = document.getElementById('uploadPlaceholder');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');

    // Reset value input file
    input.value = '';
    previewImage.src = '';

    // Kembalikan ke tampilan awal
    previewContainer.classList.add('hidden');
    previewContainer.classList.remove('flex');
    placeholder.classList.remove('hidden');
}

// Pastikan fungsi close reset form juga
function closeReturnModal() {
    const modal = document.getElementById('returnModal');
    if(modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Reset form & preview saat ditutup
        document.getElementById('returnForm').reset();
        removeFile(); 
    }
}
    </script>

</x-app-layout>
