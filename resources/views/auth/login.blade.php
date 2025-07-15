<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}"
        class="rounded-lg max-w-md mx-auto p-8 bg-white/5 bg-gradient-to-[145deg] from-black/15 to-white/50 shadow-[0_0_16px_rgba(255,255,255,0.20)] rounded-[1em] border border-[rgba(255,255,255,0.25)] backdrop-blur-xl">
        @csrf

        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-6">
            {{ __('Welcome to Login') }}
        </h2>

        <!-- Username-->
        <div class="mb-4">
            <x-input-label for="login" :value="__('Username')" />
            <div class="relative mt-1">
                <span
                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                    <i class="fas fa-user"></i>
                </span>
                <x-text-input id="login" type="text" name="login" :value="old('login')" required autofocus
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('login')" />
        </div>

        <!-- Password-->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <span
                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-4">
            <input id="remember_me" type="checkbox"
                class="rounded backdrop-blur-xl dark:bg-black border-[rgba(255,255,255,0.25)] dark:border-[rgba(255,255,255,0.30)] text-[rgba(255,255,255,0.25)] shadow-sm focus:ring-[rgba(255,255,255,0.50)] dark:focus:ring-[rgba(255,255,255,0.50)] dark:focus:ring-offset-gray-800"
                name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Remember me') }}
            </label>
        </div>

        {{-- Link forgot password --}}
        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-white dark:text-white glow-on-hover" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
