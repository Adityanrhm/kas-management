@props(['src' => null, 'class' => '', 'imageClass' => ''])


@php
    if (!$src) {
        $username = Auth::user()->username ?: 'User';
        $src = 'https://ui-avatars.com/api/?name=' . urlencode($username) . '&background=0D8ABC&color=fff';
    }
@endphp

<div
    class="relative overflow-hidden rounded-full ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-blue-300 dark:group-hover:ring-blue-600 transition-all duration-200 {{ $class }}">
    <img src="{{ str_starts_with($src, 'http') ? $src : asset('storage/' . $src) }}" alt="Avatar"
        class="w-full h-full object-cover {{ $imageClass }}">
</div>
