@props(['name' => ''])

<svg {{ $attributes->merge(['class' => 'w-5 h-5']) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
    @switch($name)
        @case('grid')
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h4v4H4V6zm6 0h4v4h-4V6zM4 14h4v4H4v-4zm6 0h4v4h-4v-4z" />
        @break

        @case('layers')
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 2l9 5-9 5-9-5 9-5zm0 13l9-5-4.5-2.5m-9 0L3 10l9 5z" />
        @break

        @default
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
    @endswitch
</svg>
