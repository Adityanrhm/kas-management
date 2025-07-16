<form method="POST" :action="formAction" enctype="multipart/form-data">
    @csrf
    <template x-if="isEdit">
        <input type="hidden" name="_method" value="PUT">
    </template>

    {{-- Header --}}
    <div class="bg-white/5 backdrop-blur-lg px-4 py-2 rounded-t-md">
        <h2 class="text-white font-semibold text-sm tracking-wide uppercase">
            <span x-text="isEdit ? 'Edit Data Siswa' : 'Tambah Data Siswa'"></span>
        </h2>
    </div>

    <div class="px-6 py-6">

        {{-- Photo Upload --}}
        <div class="mb-6">
            <x-input-label for="photo" :value="__('Foto Siswa')" />
            <div class="mt-2">

                <div class="flex items-start space-x-4">
                    {{-- Preview Image --}}
                    <div class="flex-shrink-0">
                        <div id="photo-preview"
                            class="w-24 h-24 border-2 border-dashed border-white/20 dark:border-white/20 rounded-lg flex items-center justify-center bg-white/5 dark:bg-white/5 overflow-hidden">
                            <div id="preview-placeholder" class="text-center" x-show="!previewImage">
                                <i class="fas fa-camera text-gray-400 dark:text-gray-500 text-xl mb-1"></i>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Preview</p>
                            </div>
                            <img id="preview-image" :src="previewImage" alt="Preview"
                                class="w-full h-full object-cover" x-show="previewImage">
                        </div>
                    </div>

                    {{-- Uploade area image --}}
                    <div class="flex-1">
                        <div class="relative">
                            <input type="file" id="photo" name="photo" accept="image/*" class="sr-only"
                                x-on:change="previewPhoto($event)" x-bind:required="!isEdit">
                            <label for="photo" class="cursor-pointer">
                                <div
                                    class="border-2 border-dashed border-white/20 dark:border-white/20 rounded-lg p-4 text-center hover:border-white/25 dark:hover:border-white/25 transition-colors duration-300 bg-white/5 dark:bg-white/5 hover:bg-white/5 dark:hover:bg-white/10">
                                    <div class="space-y-2">
                                        <div class="mx-auto w-12 h-12 text-gray-400 dark:text-gray-500">
                                            <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                        </div>
                                        <div class="text-sm text-white/50 dark:text-white/50">
                                            <span class="font-medium text-white/80 dark:text-white/80">Klik
                                                untuk
                                                upload</span>
                                            atau drag and drop
                                        </div>
                                        <p class="text-xs text-white/50 wds dark:text-white/50">
                                            PNG, JPG, JPEG hingga 2MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- Informasi file terpilih --}}
                        <div id="file-info" class="mt-2" x-show="fileName">
                            <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300">
                                <i class="fas fa-file-image text-blue-500"></i>
                                <span x-text="fileName"></span>
                                <button type="button" x-on:click="removePhoto()"
                                    class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('photo')" />
        </div>

        {{-- NIS --}}
        <div class="mb-4">
            <x-input-label for="nis" :value="__('NIS')" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                    <i class="fas fa-hashtag"></i>
                </span>
                <x-text-input id="nis" type="text" name="nis" x-model="formData.nis" required autofocus
                    :readonly="true" autocomplete="nis" />
            </div>
            <x-input-error :messages="$errors->get('nis')" />
        </div>

        <div class="grid grid-cols-2 gap-4">

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <x-text-input id="email" name="email" type="email" x-model="formData.email" required
                        autocomplete="email" />
                </div>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            {{-- Nama --}}
            <div>
                <x-input-label for="name" :value="__('Nama')" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                        <i class="fas fa-user"></i>
                    </span>
                    <x-text-input id="name" type="text" name="name" x-model="formData.name" required
                        autofocus autocomplete="name" />
                </div>
                <x-input-error :messages="$errors->get('name')" />
            </div>

            {{-- Dropdown kelas --}}
            <div class="mb-6">
                <x-input-label for="class" :value="__('Pilih Kelas')" />
                <div class="mt-1">
                    <x-select-dropdown name="class" :options="['' => 'Pilih Kelas', 'XI RPL 1' => 'XI RPL 1']" :selected="old('class')" x-model="formData.class"
                        required />
                </div>
                <x-input-error :messages="$errors->get('class')" />
            </div>

            {{-- Dropdown Roles --}}
            <div class="mb-6">
                <x-input-label for="role" :value="__('Pilih Role')" />
                <div class="mt-1">
                    <x-select-dropdown name="role" :options="[
                        'siswa' => 'Siswa',
                        'bendahara' => 'Bendahara',
                        'admin' => 'Admin',
                    ]" :selected="old('role')" x-model="formData.role"
                        required />
                </div>
                <x-input-error :messages="$errors->get('roles')" />
            </div>

        </div>
        {{-- Password (hanya tampil saat create} --}}
        <div class="mb-2" x-show="!isEdit">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password" type="password" name="password" :required="false"
                    autocomplete="current-password" x-bind:required="!isEdit" />
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        {{-- Konfirmasi password (hanya tampil saat create) --}}
        <div class="mb-6" x-show="!isEdit">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                    autocomplete="new-password" x-bind:required="!isEdit" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>


        <div class="flex gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Batal') }}
            </x-secondary-button>

            <x-primary-button>
                <span x-text="isEdit ? 'Update' : 'Simpan'"></span>
            </x-primary-button>
        </div>
    </div>
</form>
