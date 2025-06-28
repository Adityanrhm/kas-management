@extends('layouts.app')

@section('content')
    <div class="px-6 py-6">
        <div
            class="rounded-2xl shadow-xl shadow-white/10 p-6 bg-white/5 backdrop-blur-lg border border-white/20 ">
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
                                    @if ($user->avatar)
                                        <x-user-avatar :src="$user->avatar" class="h-10 w-10" image-class="rounded-lg" />
                                    @else
                                        <span class="text-white/50">-</span>
                                    @endif
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
                                        <button class="text-white/50 hover:text-red-500 transition wdshR duration-300" title="Hapus">
                                            <i class="fa-solid fa-trash text-base"></i>
                                        </button>

                                        <!-- Edit Button -->
                                        <button class="text-white/50 hover:text-blue-400 transition wdshB duration-300" title="Edit">
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

    <x-modal name="create-new-data">
        <form method="POST" action="{{ route('master.store.siswa') }}">
            @csrf

            <!-- Header -->
            <div class="bg-white/5 backdrop-blur-lg px-4 py-2 rounded-t-md">
                <h2 class="text-white font-semibold text-sm tracking-wide uppercase">
                    Data Siswa
                </h2>
            </div>

            <div class="px-6 py-6">
                <!-- Username -->
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

                <x-select-dropdown name="class" :options="['' => 'Piih kelas', 'XI RPL 1' => 'XI RPL 1']" label="Pilih Kelas" :selected="old('class')" />

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
        </form>
    </x-modal>
@endsection
