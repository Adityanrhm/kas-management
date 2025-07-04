<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}"
        class="rounded-lg max-w-md mx-auto p-8 bg-[rgba(0,0,0,0.5)] bg-gradient-to-[145deg] from-black/15 to-white/50 shadow-[0_0_16px_rgba(255,255,255,0.20)] rounded-[1em] border border-[rgba(255,255,255,0.25)] backdrop-blur-xl">
        @csrf

        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-6">
            {{ __('Mohon masukkan email kamu') }}
        </h2>

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <span
                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                    <i class="fas fa-envelope"></i>
                </span>

                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        {{-- Password Reset Link --}}
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
