@extends('layouts.app')

{{-- javacript calling --}}
@vite(['resources/modules/js/master_siswa.js'])

@section('content')
    <div class="px-6 py-6">

        {{-- Component alert untuk insert dan update --}}
        <x-alert />

        <div class="rounded-2xl shadow-xl shadow-white/10 p-6 bg-white/5 backdrop-blur-lg border border-white/20">
            <div x-data="searchData()" x-init="init()">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-white">Data Siswa</h2>
                    <div class="flex gap-3">

                        {{-- Search --}}
                        <div class="relative">
                            <input type="text" placeholder="Search..." x-model="query"
                                x-on:input.debounce.300ms="performSearch()"
                                class="bg-white/5 text-white placeholder-white/15 px-4 py-2 pl-10 rounded-xl border border-white/20 
                                   shadow-inner shadow-black/20 w-full
                                   focus:outline-none focus:border-white/40 focus:ring-1 focus:ring-white/20" />
                            <svg class="w-4 h-4 text-white/50 absolute left-3 top-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        @role('admin')
                            <button type="button"
                                x-on:click.prevent="
                                    $dispatch('reset-form');
                                    $dispatch('open-modal', 'siswa-modal');
                                    "
                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold backdrop-blur-lg bg-white/5 border border-white/20 text-white hover:bg-white/10 hover:border-white/30 transition-all duration-300 shadow-lg shadow-black/20 hover:shadow-black/40 hover:scale-[1.02] active:scale-95 group">
                                <i class="fa-solid fa-plus text-xs group-hover:rotate-90 transition-transform duration-300"></i>
                                Data Baru
                            </button>
                        @endrole

                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl">

                    {{-- Loading Indicator --}}
                    <div x-show="loading" class="text-center py-4">
                        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-white/60">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Loading...
                        </div>
                    </div>

                    {{-- Table utama siswa --}}
                    <table class="w-full text-sm" x-show="!loading">
                        <thead>
                            <tr
                                class="backdrop-blur-lg bg-white/5 text-white/80 uppercase text-xs tracking-widest border-b border-white/20">
                                <th class="text-left py-3 px-3">Photo</th>
                                <th class="text-left py-3 px-12">NIS</th>
                                <th class="text-left py-3 px-3">Email</th>
                                <th class="text-left py-3 px-3">Nama</th>
                                <th class="text-left py-3 px-3">Kelas</th>
                                <th class="text-left py-3 px-3">Role</th>

                                @role('bendahara')
                                    <th class="text-left py-3 px-3">Status Kas</th>
                                @endrole

                                @role('admin')
                                    <th class="text-left py-3 px-3">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <template x-if="results.length > 0">
                                <template x-for="user in results" :key="user.id">
                                    <tr class="border-b border-white/20 hover:bg-white/5 transition duration-300">
                                        <td class="text-left py-3 px-3">
                                            <img :src="`{{ asset('storage') }}/` + user.avatar"
                                                class="h-10 w-10 rounded-full" />
                                        </td>
                                        <td class="text-left py-3 px-12 text-white/60" x-text="user.student?.nis ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-3 text-white/60" x-text="user.email"></td>
                                        <td class="text-left py-3 px-3 text-white/60" x-text="user.username ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-3 text-white/60" x-text="user.student?.class ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-3 text-white/60">
                                            <span
                                                class="inline-flex items-left  text-xs font-medium px-2.5 py-0.5 rounded-full"
                                                x-text="user.roles[0]?.name ?? '-'"
                                                :class="{
                                                    // 🟦 admin = biru
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 wdsB': user
                                                        .roles[0]?.name === 'admin',
                                                
                                                    // 🟢 siswa = hijau
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 wdsG': user
                                                        .roles[0]?.name === 'siswa',
                                                
                                                    // 🟡 bendahara = kuning
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 wdsY': user
                                                        .roles[0]?.name === 'bendahara',
                                                
                                                }"></span>
                                        </td>


                                        @role('bendahara')
                                            <td class="text-left py-3 px-3 text-white/60">
                                                <span
                                                    class="inline-flex items-left wdsR bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                    belum bayar
                                                </span>
                                            @endrole
                                        </td>

                                        @role('admin')
                                            <td class="py-3 px-3">
                                                <div class="gap-3 flex">

                                                    {{-- Edit button --}}
                                                    <button
                                                        class="text-white/50 hover:text-blue-400 transition duration-300 edit-btn wdsB"
                                                        title="Edit" :data-id="user.id"
                                                        :data-nis="user.student?.nis ?? ''" :data-email="user.email ?? ''"
                                                        :data-name="user.username ?? ''" :data-class="user.student?.class ?? ''"
                                                        :data-avatar="user.avatar ?? ''"
                                                        :data-avatar="user.roles[0]?.name ?? ''"
                                                        x-on:click.prevent="
                                                        $dispatch('edit-form', {
                                                            id: user.id,
                                                            nis: user.student?.nis ?? '',
                                                            email: user.email ?? '',
                                                            name: user.username ?? '',
                                                            class: user.student?.class ?? '',
                                                            avatar: user.avatar ?? '',
                                                            role: user.roles[0]?.name ?? '',
                                                        });
                                                        $dispatch('open-modal', 'siswa-modal');
                                                    ">
                                                        <i class="fa-solid fa-pen-to-square text-base"></i>
                                                    </button>

                                                    {{-- Delete button --}}
                                                    <form :action="`/master/siswa/${user.id}`" method="POST"
                                                        class="form-delete-siswa">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-white/50 hover:text-red-500 transition duration-300 wdsR"
                                                            title="Hapus">
                                                            <i class="fa-solid fa-trash text-base"></i>
                                                        </button>
                                                    </form>
                                                    <x-swal-delete selector=".form-delete-siswa" />

                                                </div>
                                            </td>
                                        @endrole

                                    </tr>
                                </template>
                            </template>

                            {{-- Data ketika kosong --}}
                            <template x-if="results.length === 0 && !loading">
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-white/50 italic">
                                        <span
                                            class="inline-flex items-center justify-center px-4 py-2 rounded-md 
                                               text-sm font-semibold text-red-200 bg-red-500/10 border border-red-400/20 
                                               shadow-md shadow-red-500/30 ring-1 ring-red-400/40 
                                               animate-pulse backdrop-blur-sm">
                                            Tidak ada data yang tersedia
                                        </span>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="flex justify-between items-center text-white mt-4 mx-2" x-show="!loading">

                        <div class="text-white text-sm mt-2">
                            Menampilkan ke
                            <span x-text="pagination.from ?? 0"></span> -
                            <span x-text="pagination.to ?? 0"></span> data dari
                            <span x-text="pagination.total ?? 0"></span> data siswa.
                        </div>

                        <div>
                            <button x-on:click="changePage(pagination.prev_page_url)"
                                class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 disabled:opacity-30"
                                :disabled="!pagination.prev_page_url">Previous</button>

                            <div class="inline-flex space-x-1">

                                {{-- Halaman yang terlihat --}}
                                <template x-for="page in visiblePages" :key="page">
                                    <button x-on:click="changePage(`/master/siswa?page=${page}&q=${query}`)"
                                        class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 glow-white-hover"
                                        :class="{ 'bg-white/10 text-white font-bold': page === pagination.current_page }"
                                        x-text="page"></button>
                                </template>

                                {{-- Total button page tersedia --}}
                                <template x-if="visiblePages[visiblePages.length - 1] < pagination.last_page">
                                    <div class="inline-flex items-center space-x-1">
                                        <template x-if="visiblePages[visiblePages.length - 1] < pagination.last_page - 1">
                                            <span class="px-2 text-sm">...</span>
                                        </template>
                                        <button
                                            x-on:click="changePage(`/master/siswa?page=${pagination.last_page}&q=${query}`)"
                                            class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 glow-white-hover"
                                            :class="{
                                                'bg-white/10 text-white font-bold': pagination.last_page === pagination
                                                    .current_page
                                            }"
                                            x-text="pagination.last_page"></button>
                                    </div>
                                </template>

                            </div>

                            <button x-on:click="changePage(pagination.next_page_url)"
                                class="px-3 py-1 text-sm border border-white/20 rounded hover:bg-white/10 disabled:opacity-30"
                                :disabled="!pagination.next_page_url">Next</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Store dan Update Siswa --}}
    <div x-data="siswaModal()" x-init="init()" x-on:reset-form.window="resetForm()"
        x-on:edit-form.window="editForm($event.detail)">
        <x-modal name="siswa-modal">

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
                                        <input type="file" id="photo" name="photo" accept="image/*"
                                            class="sr-only" x-on:change="previewPhoto($event)"
                                            x-bind:required="!isEdit">
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
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <x-text-input id="nis" type="text" name="nis" x-model="formData.nis" required
                                autofocus :readonly="true" autocomplete="nis" />
                        </div>
                        <x-input-error :messages="$errors->get('nis')" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        {{-- Nama --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <div class="relative mt-1">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                    <i class="fas fa-user"></i>
                                </span>
                                <x-text-input id="name" type="text" name="name" x-model="formData.name"
                                    required autofocus autocomplete="name" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <div class="relative mt-1">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <x-text-input id="email" name="email" type="email" x-model="formData.email"
                                    required autocomplete="email" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" />
                        </div>

                        {{-- Dropdown kelas --}}
                        <div class="mb-6">
                            <x-input-label for="class" :value="__('Pilih Kelas')" />
                            <div class="mt-1">
                                <x-select-dropdown name="class" :options="['' => 'Pilih Kelas', 'XI RPL 1' => 'XI RPL 1']" :selected="old('class')"
                                    x-model="formData.class" required />
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
                                ]" :selected="old('role')"
                                    x-model="formData.role" required />
                            </div>
                            <x-input-error :messages="$errors->get('roles')" />
                        </div>

                    </div>
                    {{-- Password (hanya tampil saat create} --}}
                    <div class="mb-2" x-show="!isEdit">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
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
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/50">
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
        </x-modal>
    </div>

    {{-- Set window varible untuk function javascript --}}
    <script>
        window.routes = {
            'master.store.siswa': '{{ route('master.store.siswa') }}'
        };
        window.defaultNis = '{{ $nis_siswa ?? '' }}';
        window.storageUrl = '{{ asset('storage') }}';
        window.initialData = @json($users_data);
    </script>
@endsection
