<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-2xl border border-gray-100">

                <!-- Header -->
                <div class="p-6 border-b bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-2xl">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i data-feather="edit-3" class="w-6 h-6 text-blue-600"></i>
                        Form Edit Employee
                    </h3>
                </div>

                <!-- Form -->
                <form action="{{ route('employees.update', $karyawan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-5">

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $karyawan->name) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $karyawan->email) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Jabatan
                            </label>

                            <input type="text"
                                   name="position"
                                   value="{{ old('position', $karyawan->position) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                            @error('position')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-between rounded-b-2xl">

                        <a href="{{ route('employees.index') }}"
                           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                            Kembali
                        </a>

                        <button type="submit"
                                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                            <i data-feather="save" class="w-4 h-4"></i>
                            Update
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        feather.replace();
    </script>
</x-app-layout>
