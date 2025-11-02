<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 ">
        <div class="w-full max-w-md md:max-w-xl bg-white shadow-xl rounded-2xl p-10">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-8">Daftar Akun Sistem Inventaris</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" class="mt-2 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-2 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="mt-2 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="mt-2 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Buttons -->
                <div class="flex flex-col gap-4 mt-4">
                    <x-primary-button class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition text-center">
                        {{ __('Register') }}
                    </x-primary-button>

                    <a href="{{ route('login') }}" class="w-full py-3 text-center text-blue-500 font-semibold hover:underline">
                        Sudah punya akun? Masuk Disini
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
