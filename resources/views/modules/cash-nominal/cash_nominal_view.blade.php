@extends('layouts.app')

@section('content')
    {{-- javacript calling --}}
    @vite(['resources/modules/js/cash-nominal.js'])

@section('content')
    <div class="px-6 py-6">

        {{-- Component alert untuk insert dan update --}}
        <x-alert />

        <div class="rounded-2xl shadow-xl shadow-white/10 p-6 bg-white/5 backdrop-blur-lg border border-white/20">
            <div x-data="searchData()" x-init="init()">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-white">Nominal Kas</h2>
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

                        <button type="button"
                            x-on:click.prevent="
                                    $dispatch('reset-form');
                                    $dispatch('open-modal', 'cash-nominal-modal');
                                    "
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold backdrop-blur-lg bg-white/5 border border-white/20 text-white hover:bg-white/10 hover:border-white/30 transition-all duration-300 shadow-lg shadow-black/20 hover:shadow-black/40 hover:scale-[1.02] active:scale-95 group">
                            <i class="fa-solid fa-plus text-xs group-hover:rotate-90 transition-transform duration-300"></i>
                            Nominal Baru
                        </button>

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
                                {{-- <th class="text-left py-3 px-3">Photo</th> --}}
                                <th class="text-left py-3 px-6">NIS</th>
                                <th class="text-left py-3 px-1">Nama Siswa</th>
                                <th class="text-left py-3 px-4">Minggu</th>
                                <th class="text-left py-3 px-4">Bulan</th>
                                <th class="text-left py-3 px-4">Tahun</th>
                                <th class="text-left py-3 px-4">Nominal</th>
                                <th class="text-left py-3">Status Pembayaran</th>
                                <th class="text-left py-3 px-3">Jatuh Tempo</th>
                                <th class="text-left py-3 px-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <template x-if="results.length > 0">
                                <template x-for="cashNomiData in results" :key="cashNomiData.id">
                                    <tr class="border-b border-white/20 hover:bg-white/5 transition duration-300">
                                        {{-- <td class="text-left py-3 px-3">
                                            <img :src="`{{ asset('storage') }}/` + cashNomiData.student.user.avatar"
                                                class="h-10 w-10 rounded-full" />
                                        </td> --}}
                                        <td class="text-left py-3 px-5 text-white/60"
                                            x-text="cashNomiData.student?.nis ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-1 text-white/60"
                                            x-text="cashNomiData.student.user.username"></td>
                                        <td class="text-left py-3 px-6 text-white/60"
                                            x-text="cashNomiData.week ? 'Ke - ' + cashNomiData.week : 'Ke - ' + '-'"></td>
                                        <td class="text-left py-3 px-6 text-white/60" x-text="cashNomiData.month ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-6 text-white/60" x-text="cashNomiData.year ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-6 text-white/60" x-text="cashNomiData.nominal ?? '-'">
                                        </td>
                                        <td class="text-left py-3 px-8 text-white/60">
                                            <span
                                                class="capitalize inline-flex items-left  text-xs font-medium px-2.5 py-0.5 rounded-full"
                                                x-text="cashNomiData.status ?? '-'"
                                                :class="{
                                                    'bg-blue-100 text-red-800 dark:bg-red-900 dark:text-red-300 wdsR': cashNomiData
                                                        .status === 'rejected',
                                                
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 wdsG': cashNomiData
                                                        .status === 'verified',
                                                
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-400 wdsY': cashNomiData
                                                        .status === 'pending',
                                                
                                                }"></span>
                                        </td>
                                        <td class="text-left py-3 px-5 text-white/60" x-text="cashNomiData.due_date ?? '-'">
                                        </td>

                                        @role('admin')
                                            <td class="py-3 px-4">
                                                <div class="gap-3 flex">

                                                    {{-- Edit button --}}
                                                    <button
                                                        class="text-white/50 hover:text-blue-400 transition duration-300 edit-btn wdsB"
                                                        title="Edit" :data-id="cashNomiData.id"
                                                        :data-nis="cashNomiData.student?.nis ?? ''"
                                                        :data-name="cashNomiData.student.user.username ?? ''"
                                                        :data-week="cashNomiData.week ?? ''"
                                                        :data-month="cashNomiData.month ?? ''"
                                                        :data-year="cashNomiData.year ?? ''"
                                                        :data-nominal="cashNomiData.nominal ?? ''"
                                                        :data-due-date="cashNomiData.due_date ?? ''"
                                                        x-on:click.prevent="
                                                        $dispatch('edit-form', {
                                                            id: cashNomiData.id,
                                                            nis: cashNomiData.student?.nis ?? '',
                                                            name: cashNomiData.student.user.username ?? '',
                                                            week: cashNomiData.week ?? '',
                                                            month: cashNomiData.month ?? '',
                                                            year: cashNomiData.year ?? '',
                                                            nominal: cashNomiData.nominal ?? '',
                                                            due-date: cashNomiData.due_date ?? '',
                                                        });
                                                        $dispatch('open-modal', 'cash-nominal-modal');
                                                    ">
                                                        <i class="fa-solid fa-pen-to-square text-base"></i>
                                                    </button>

                                                    {{-- Delete button --}}
                                                    <form :action="`/cash-amount/delete/${cashNomiData.id}`" method="POST"
                                                        class="form-delete-cash-nominal">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-white/50 hover:text-red-500 transition duration-300 wdsR"
                                                            title="Hapus">
                                                            <i class="fa-solid fa-trash text-base"></i>
                                                        </button>
                                                    </form>
                                                    <x-swal-delete selector=".form-delete-cash-nominal" />

                                                </div>
                                            </td>
                                        @endrole

                                    </tr>
                                </template>
                            </template>

                            {{-- Data ketika kosong --}}
                            <template x-if="results.length === 0 && !loading">
                                <tr>
                                    <td colspan="9" class="p-4 text-center text-white/50 italic">
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
                                    <button x-on:click="changePage(`/management-siswa/siswa?page=${page}&q=${query}`)"
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
                                            x-on:click="changePage(`/management-siswa/siswa?page=${pagination.last_page}&q=${query}`)"
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

    <div x-data="cashNominalModal()" x-init="init()" x-on:reset-form.window="resetForm()"
        x-on:edit-form.window="editForm($event.detail)">
        <x-modal name="cash-nominal-modal">

            @include('modules.cash-nominal.cash_nominal_form')

        </x-modal>
    </div>

    {{-- Set window varible untuk function javascript --}}
    <script>
        window.routes = {
            'store.cash-nominal': '{{ route('store.cash-nominal') }}'
        };
        // window.defaultNis = '{{ $nis_siswa ?? '' }}';
        window.storageUrl = '{{ asset('storage') }}';
        window.initialData = @json($cash_nominal_data);
    </script>
@endsection
