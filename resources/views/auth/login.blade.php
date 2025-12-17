<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-10">
            
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Masuk ke Sistem Inventaris</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                  type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Lupa Kata Sandi?') }}
                        </a>
                    @endif
                </div> --}}

                <!-- Buttons -->
                <div class="flex flex-col gap-4">
                    <x-primary-button class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white  font-semibold rounded-lg transition">
                        {{ __('Log in') }}
                    </x-primary-button>

                    <a href="{{ route('register') }}" class="w-full py-3 text-left  text-blue-500">
                        Daftar Disini
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
