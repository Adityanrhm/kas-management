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
                    <button type="button" x-on:click.prevent="$dispatch('open-modal', 'create-new-data')"
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
                                        <button class="text-white/50 hover:text-blue-400 transition wdshB duration-300"
                                            title="Edit" x-data
                                            x-on:click.prevent="
                                            $dispatch('pass-user-id', { id_siswa: {{ $user->id }} });
                                            $dispatch('open-modal', 'create-new-data');
                                        ">
                                            <i class="fa-solid fa-pen-to-square text-base"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-white/50 italic">
                                    No data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal name="create-new-data" x-data="{ id_siswa: null }" x-on:pass-user-id.window="id_siswa = $event.detail.id_siswa">
        <form method="POST" :action="id_siswa ? `/master/siswa/${id_siswa}` : '{{ route('master.store.siswa') }}'"
            enctype="multipart/form-data">
            @csrf

            <!-- Header -->
            <div class="bg-white/5 backdrop-blur-lg px-4 py-2 rounded-t-md">
                <h2 class="text-white font-semibold text-sm tracking-wide uppercase">
                    Data Siswa
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
                                    class="w-24 h-24 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center bg-gray-50 dark:bg-gray-700 overflow-hidden">
                                    <div id="preview-placeholder" class="text-center">
                                        <i class="fas fa-camera text-gray-400 dark:text-gray-500 text-xl mb-1"></i>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Preview</p>
                                    </div>
                                    <img id="preview-image" src="" alt="Preview"
                                        class="w-full h-full object-cover hidden">
                                </div>
                            </div>

                            <!-- Upload Area -->
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" id="photo" name="photo" accept="image/*" class="sr-only"
                                        onchange="previewPhoto(event)">
                                    <label for="photo" class="cursor-pointer">
                                        <div
                                            class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors duration-200 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <div class="space-y-2">
                                                <div class="mx-auto w-12 h-12 text-gray-400 dark:text-gray-500">
                                                    <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                                </div>
                                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                                    <span class="font-medium text-blue-600 dark:text-blue-400">Klik untuk
                                                        upload</span>
                                                    atau drag and drop
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    PNG, JPG, JPEG hingga 2MB
                                                </p>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Selected File Info -->
                                <div id="file-info" class="mt-2 hidden">
                                    <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-file-image text-blue-500"></i>
                                        <span id="file-name"></span>
                                        <button type="button" onclick="removePhoto()"
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

                {{-- Username --}}
                <div class="mb-4">
                    <x-input-label for="nis" :value="__('NIS')" />
                    <div class="relative mt-1">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50 text-white/50">
                            <i class="fas fa-hashtag"></i>
                        </span>
                        <x-text-input id="nis" type="text" name="nis" :value="old('nis', $nis_siswa)" required autofocus
                            readonly autocomplete="nis" />
                    </div>
                    <x-input-error :messages="$errors->get('nis')" />
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <div class="relative mt-1">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50 text-white/50">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <x-text-input id="email" name="email" type="email" :value="old('email')" required
                            autocomplete="email" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                {{-- Nama --}}
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nama')" />
                    <div class="relative mt-1">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50 text-white/50">
                            <i class="fas fa-user"></i>
                        </span>
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                            autocomplete="name" />
                    </div>
                    <x-input-error :messages="$errors->get('Username')" />
                </div>

                {{-- Dropdown kelas --}}
                <x-select-dropdown name="class" :options="['' => 'Piih kelas', 'XI RPL 1' => 'XI RPL 1']" label="Pilih Kelas" :selected="old('class')" />

                {{-- Password --}}
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative mt-1">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50 text-white/50">
                            <i class="fas fa-lock"></i>
                        </span>
                        <x-text-input id="password" type="password" name="password" required
                            autocomplete="current-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                {{-- Konfirmasi passsword --}}
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <div class="relative mt-1">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50 text-white/50">
                            <i class="fas fa-lock"></i>
                        </span>
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-primary-button class="">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.form-delete').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // 🔒 cegah submit langsung

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data akan hilang secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        background: '#1f2937',
                        color: '#f9fafb',
                        confirmButtonColor: cancelButtonColor:
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script> --}}


    @vite(['resources/modules/js/master_siswa.js'])
@endsection
