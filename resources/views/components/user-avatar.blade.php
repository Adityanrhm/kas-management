@props(['src' => null, 'class' => '', 'imageClass' => ''])


@php
    use Illuminate\Support\Facades;

    if (!$src || !Storage::disk('public')->exists($src)) {
        $username = Auth::user()->username ?: 'User';
        $src = 'https://ui-avatars.com/api/?name=' . urlencode($username) . '&background=0D8ABC&color=fff';
    }
@endphp

<div
    class="relative overflow-hidden rounded-full ring-2 ring-gray-200 dark:ring-white/30 group-hover:ring-white dark:group-hover:ring-white/50  transition-all duration-300 {{ $class }}">
    <img src="{{ str_starts_with($src, 'http') ? $src : asset('storage/' . $src) }}" alt="Avatar"
        class="w-full h-full object-cover {{ $imageClass }}">
</div>
