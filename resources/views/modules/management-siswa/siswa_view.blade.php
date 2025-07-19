@extends('layouts.app')

{{-- javacript calling --}}
@vite(['resources/modules/js/management-siswa.js'])

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

                                @role('admin')
                                    <th class="text-left py-3 px-3">Role</th>
                                    <th class="text-left py-3 px-3">Action</th>
                                @endrole

                                @role('bendahara')
                                    <th class="text-left py-3 px-3">Status Kas</th>
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

                                        @role('admin')
                                            <td class="text-left py-3 px-3 text-white/60">
                                                <span
                                                    class="inline-flex items-left  text-xs font-medium px-2.5 py-0.5 rounded-full"
                                                    x-text="user.roles[0]?.name ?? '-'"
                                                    :class="{
                                                        'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 wdsB': user
                                                            .roles[0]?.name === 'admin',
                                                    
                                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 wdsG': user
                                                            .roles[0]?.name === 'siswa',
                                                    
                                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-400 wdsY': user
                                                            .roles[0]?.name === 'bendahara',
                                                    
                                                    }"></span>
                                            </td>
                                        @endrole

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
                                                    <form :action="`/management-siswa/delete/${user.id}`" method="POST"
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

                    {{-- Pagination Component --}}
                    <x-pagination route="/management-siswa" label="siswa" />

                </div>
            </div>
        </div>

        {{-- Modal Store dan Update Siswa --}}
        <div x-data="siswaModal()" x-init="init()" x-on:reset-form.window="resetForm()"
            x-on:edit-form.window="editForm($event.detail)">
            <x-modal name="siswa-modal">

                @include('modules.management-siswa.siswa_form')

            </x-modal>
        </div>

        {{-- Set window varible untuk function javascript --}}
        <script>
            window.routes = {
                'store.management-siswa': '{{ route('store.management-siswa') }}'
            };
            window.defaultNis = '{{ $nis_siswa ?? '' }}';
            window.storageUrl = '{{ asset('storage') }}';
            window.initialData = @json($users_data);
        </script>
    @endsection
