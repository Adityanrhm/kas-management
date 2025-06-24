@extends('layouts.app')

@section('content')
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-6 dark:bg-gray-800 shadow sm:rounded-lg flex items-center space-x-6">
                <img src="data:image/png;base64,{{ Auth::user()->user_avatar }}" alt="Avatar"
                    class="w-16 h-16 rounded-full shadow">

                <div>
                    <h2 class="text-xl font-semibold text-white">{{ Auth::user()->username }}</h2>

                    <div class="flex items-center space-x-2 text-sm text-gray-400 font-normal">
                        <span>{{ Auth::user()->email }}</span>
                        <span class="text-gray-600 dark:text-gray-500">|</span>
                        <span class="capitalize ">{{ Auth::user()->roles->name }}</span>
                    </div>

                </div>

            </div>
        </div>
    </div> --}}
@endsection
