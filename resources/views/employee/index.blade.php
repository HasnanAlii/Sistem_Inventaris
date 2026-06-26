<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Data Employees') }}
        </h2>
    </x-slot>

    <!-- 🔹 Navigasi -->
    <nav class="bg-white shadow-md border border-gray-200 px-6 py-4 flex flex-wrap items-center gap-4 rounded-xl mb-8">
        <a href="{{ route('employees.index') }}"
           class="flex items-center gap-3 px-6 py-3 rounded-lg border-2 font-semibold text-base transition-all duration-200
                  {{ request()->routeIs('employees.*')
                      ? 'bg-blue-200 border-blue-600 text-blue-900 shadow-lg'
                      : 'border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-500 hover:text-blue-800' }}">
            <i data-feather="users" class="w-6 h-6"></i>
            Employees
        </a>
    </nav>

    <!-- 🔹 Konten -->
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 border-b border-gray-200 
                    bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-2xl shadow-sm">

                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="users" class="w-6 h-6 text-blue-600"></i>
                        Daftar Employees
                    </h3>

                    <a href="{{ route('employees.create') }}"
                       class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium 
                       hover:bg-blue-700 hover:shadow-md transition-all duration-200">
                        <i data-feather="plus-circle" class="w-5 h-5"></i>
                        Tambah Employee
                    </a>
                </div>

                <!-- Pesan -->
                @if(session('success'))
                    <div class="p-4 mx-6 my-4 text-green-800 bg-green-50 border border-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tabel -->
                <div class="overflow-x-auto p-6">
                    <table class="min-w-[900px] w-full border border-gray-200 divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Nama</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-left">Jabatan</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($employees as $i => $emp)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-5 py-3">
                                    {{ $i + 1 }}
                                </td>

                                <td class="px-5 py-3">{{ $emp->name }}</td>
                                <td class="px-5 py-3">{{ $emp->email }}</td>
                                <td class="px-5 py-3">{{ $emp->position }}</td>

                                <td class="px-5 py-3 text-center flex justify-center gap-3">
                                    <a href="{{ route('employees.edit', $emp->id) }}"
                                       class="text-yellow-600 hover:text-yellow-800">
                                        Edit
                                    </a>

                                    <form action="{{ route('employees.destroy', $emp->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-6">
                                    Belum ada data employees
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- <!-- Pagination -->
                <div class="p-6 border-t bg-gray-50">
                    {{ $employees->links() }}
                </div> --}}

            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
