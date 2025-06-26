<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-white text-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-100 focus:bg-white/10 focus:backdrop-blur-md focus:border-white/40 focus:border-2 focus:text-white active:bg-white/10 active:backdrop-blur-md active:border-white/40 active:border active:text-white transition ease-in-out duration-250 btn-active-glow'
]) }}>
    {{ $slot }}
</button>
