<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-white/80">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-white/50">
            {{ __('Setelah akun kamu dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Sebelum menghapus akun kamu, harap unduh data atau informasi yang ingin kamu simpan.') }}
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white/80">
                {{ __('Apakah kamu yakin ingin menghapus akun mu?') }}
            </h2>

            <p class="mt-1 text-sm text-white/50">
                {{ __('Setelah akun kamu dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Harap masukkan kata sandi kamu untuk mengonfirmasi bahwa kamu ingin menghapus akun kamu secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <div class="relative mt-1">
                    <span
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                        <i class="fas fa-lock"></i>
                    </span>

                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
