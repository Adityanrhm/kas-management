@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="w-full max-w-sm mx-auto lg:max-w-7xl lg:p-6 p-4 dark:bg-gray-800 shadow rounded-lg flex items-center space-x-6">
                <x-user-avatar :src="Auth::user()->avatar" class="h-16 w-16" image-class="rounded-lg" />

                <div>
                    <h2 class="text-xl font-semibold text-white">{{ $user->username }}</h2>

                    <div class="flex items-center space-x-2 text-sm text-gray-400 font-normal">
                        <span>{{ $user->email }}</span>
                        <span class="text-gray-600 dark:text-gray-500">|</span>
                        <span class="capitalize">{{ $user->role->name }}</span>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-sm mx-auto lg:max-w-7xl lg:p-6 p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="w-full max-w-sm mx-auto lg:max-w-7xl lg:p-6 p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="w-full max-w-sm mx-auto lg:max-w-7xl lg:p-6 p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
