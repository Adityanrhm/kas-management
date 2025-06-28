<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white/5 backdrop-blur-lg border border-white/20 rounded-md font-semibold text-xs \
    text-white/50 uppercase tracking-widest shadow-sm hover:bg-white/10 dark:hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
