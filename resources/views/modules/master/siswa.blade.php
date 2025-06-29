@extends('layouts.app')

@section('content')
    <div class="px-6 py-6">
        <div class="rounded-2xl shadow-xl shadow-white/10 p-6 bg-white/5 backdrop-blur-lg border border-white/20 ">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-white">Data Siswa</h2>
                <div class="flex gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="bg-white/5 text-white placeholder-white/15 px-4 py-2 pl-10 rounded-xl border border-white/20 shadow-inner shadow-black/20">
                        <svg class="w-4 h-4 text-white/50 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="button"
                        x-on:click.prevent="
                            $dispatch('open-modal', 'siswa-modal');
                            $dispatch('reset-form');
                        "
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold backdrop-blur-lg bg-white/5 border border-white/20 text-white">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Data Baru
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            class="backdrop-blur-lg bg-white/5 text-white/80 uppercase text-xs tracking-widest border-b border-white/20 ">
                            <th class="text-left py-3 px-3">Photo</th>
                            <th class="text-left py-3 px-12">NIS</th>
                            <th class="text-left py-3 px-3">Email</th>
                            <th class="text-left py-3 px-3">Nama</th>
                            <th class="text-left py-3 px-3">Kelas</th>
                            <th class="text-left py-3 px-3">Status Kas</th>
                            <th class="text-left py-3 px-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        @forelse ($users_data as $user)
                            <tr class="border-b border-white/20 hover:bg-white/5 transition duration-300">
                                <td class="text-left py-3 px-3">
                                    <x-user-avatar :src="$user->avatar" class="h-10 w-10" image-class="rounded-lg" />
                                </td>
                                <td class="text-left py-3 px-12 text-white/60">{{ $user->student->nis ?? '-' }}</td>
                                <td class="text-left py-3 px-3 text-white/60">{{ $user->email ?? '-' }}</td>
                                <td class="text-left py-3 px-3 text-white/60">{{ $user->student->name ?? '-' }}</td>
                                <td class="text-left py-3 px-3 text-white/60">{{ $user->student->class ?? '-' }}</td>
                                <td class="text-left py-3 px-3 text-white/60">
                                    <span
                                        class="inline-flex items-left wdsR bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        belum bayar
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-3">
                                        <!-- Delete Button -->
                                        <form action="{{ route('master.destroy.siswa', $user->id) }}" method="POST"
                                            class="form-delete">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-white/50 hover:text-red-500 transition wdshR duration-300"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash text-base"></i>
                                            </button>
                                        </form>
                                        <x-swal-delete selector=".form-delete" />

                                        <!-- Edit Button -->
                                        <button
                                            class="text-white/50 hover:text-blue-400 transition wdshB duration-300 edit-btn"
                                            title="Edit" data-id="{{ $user->id }}"
                                            data-nis="{{ $user->student->nis ?? '' }}" data-email="{{ $user->email ?? '' }}"
                                            data-name="{{ $user->student->name ?? '' }}"
                                            data-class="{{ $user->student->class ?? '' }}"
                                            data-avatar="{{ $user->avatar ?? '' }}"
                                            x-on:click.prevent="
                                                $dispatch('open-modal', 'siswa-modal');
                                                $dispatch('edit-form', {
                                                    id: $event.target.closest('.edit-btn').dataset.id,
                                                    nis: $event.target.closest('.edit-btn').dataset.nis,
                                                    email: $event.target.closest('.edit-btn').dataset.email,
                                                    name: $event.target.closest('.edit-btn').dataset.name,
                                                    class: $event.target.closest('.edit-btn').dataset.class,
                                                    avatar: $event.target.closest('.edit-btn').dataset.avatar
                                                });
                                            ">
                                            <i class="fa-solid fa-pen-to-square text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-white/50 italic">
                                    No data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Create/Edit Siswa -->
    <div x-data="siswaModal()" x-on:reset-form.window="resetForm()" x-on:edit-form.window="editForm($event.detail)">
        <x-modal name="siswa-modal">
            <form method="POST" :action="formAction" enctype="multipart/form-data">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>


                <!-- Header -->
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
                            <!-- Photo Preview Container -->
                            <div class="flex items-start space-x-4">
                                <!-- Preview Image -->
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

                                <!-- Upload Area -->
                                <div class="flex-1">
                                    <div class="relative">
                                        <input type="file" id="photo" name="photo" accept="image/*" class="sr-only"
                                            x-on:change="previewPhoto($event)">
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

                                    <!-- Selected File Info -->
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
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <x-text-input id="nis" type="text" name="nis" x-model="formData.nis" required
                                autofocus :readonly="true" autocomplete="nis" />
                        </div>
                        <x-input-error :messages="$errors->get('nis')" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <x-text-input id="email" name="email" type="email" x-model="formData.email" required
                                autocomplete="email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    {{-- Nama --}}
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                <i class="fas fa-user"></i>
                            </span>
                            <x-text-input id="name" type="text" name="name" x-model="formData.name" required
                                autofocus autocomplete="name" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    {{-- Dropdown kelas --}}
                    <div class="mb-4">
                        <x-input-label for="class" :value="__('Pilih Kelas')" />
                        <div class="mt-1">
                            <x-select-dropdown name="class" :options="['' => 'Pilih Kelas', 'XI RPL 1' => 'XI RPL 1']" :selected="old('class')"
                                x-model="formData.class" />
                        </div>
                        <x-input-error :messages="$errors->get('class')" />
                    </div>

                    {{-- Password (hanya tampil saat create) --}}
                    <div class="mb-4" x-show="!isEdit">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                <i class="fas fa-lock"></i>
                            </span>
                            <x-text-input id="password" type="password" name="password" :required="false"
                                autocomplete="current-password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    {{-- Konfirmasi password (hanya tampil saat create) --}}
                    <div class="mb-4" x-show="!isEdit">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                <i class="fas fa-lock"></i>
                            </span>
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                autocomplete="new-password" />
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
        </x-modal>
    </div>

    <script>
        function siswaModal() {
            return {
                isEdit: false,
                formAction: '{{ route('master.store.siswa') }}',
                previewImage: '',
                fileName: '',
                formData: {
                    id: '',
                    nis: '{{ $nis_siswa ?? '' }}',
                    email: '',
                    name: '',
                    class: ''
                },

                resetForm() {
                    this.isEdit = false;
                    this.formAction = '{{ route('master.store.siswa') }}';
                    this.previewImage = '';
                    this.fileName = '';
                    this.formData = {
                        id: '',
                        nis: '{{ $nis_siswa ?? '' }}',
                        email: '',
                        name: '',
                        class: ''
                    };

                    // Reset form fields
                    document.getElementById('photo').value = '';
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                },

                editForm(data) {
                    this.isEdit = true;
                    this.formAction = `/master/siswa/${data.id}`;
                    this.formData = {
                        id: data.id,
                        nis: data.nis,
                        email: data.email,
                        name: data.name,
                        class: data.class
                    };

                    // Set preview image if exists
                    if (data.avatar) {
                        this.previewImage = '{{ asset('storage') }}/' + data.avatar;
                    }
                },

                previewPhoto(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.fileName = file.name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewImage = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                removePhoto() {
                    this.previewImage = '';
                    this.fileName = '';
                    document.getElementById('photo').value = '';
                }
            }
        }
    </script>

    @vite(['resources/modules/js/master_siswa.js'])
@endsection
