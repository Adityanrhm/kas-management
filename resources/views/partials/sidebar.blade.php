<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[100px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-50 flex h-screen w-[323px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 transition-all duration-300 ease-linear dark:border-gray-800 dark:bg-slate-900 lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">

    <!-- Sidebar Header -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-start'"
        class="sidebar-header flex items-center gap-3 pb-7 pt-7 transition-all duration-300">

        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="w-5 h-5 lg:w-12 lg:h-12 fill-current text-gray-500 ml-1" />
            <div x-show="!sidebarToggle && window.innerWidth >= 1024" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2"
                class="hidden lg:flex flex-col ml-3 leading-snug text-left font-semibold text-gray-700 dark:text-gray-100 text-lg font-sans">
                <span class="font-sans">Kas</span>
                <span class="pl-2 font-sans">Management</span>
            </div>
        </a>
    </div>

    <!-- Sidebar Content -->
    <div class="flex-1 overflow-y-auto">
        <nav x-data="{ selected: $persist('Dashboard') }">
            <div>
                <!-- Menu Title -->
                <h3 class="mt-6 mb-4 px-1 lg:mt-0 text-xs uppercase tracking-wider font-medium text-slate-400">
                    <span :class="sidebarToggle ? 'lg:hidden' : ''">MENU</span>
                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto text-slate-400"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.999 10.245c.966 0 1.75.783 1.75 1.75s-.784 1.75-1.75 1.75-1.75-.784-1.75-1.75.784-1.75 1.75-1.75Zm12 0c.967 0 1.75.783 1.75 1.75s-.783 1.75-1.75 1.75-1.75-.784-1.75-1.75.783-1.75 1.75-1.75ZM13.749 12c0-.967-.784-1.75-1.75-1.75s-1.75.783-1.75 1.75.784 1.75 1.75 1.75 1.75-.783 1.75-1.75Z"
                            fill="currentColor" />
                    </svg>
                </h3>

                <!-- Menu Items -->
                <ul class="mb-6 flex flex-col gap-1">
                    <!-- Di sini akan ditaruh item menu secara manual -->
                    <!-- Silakan paste menu manualmu kembali di sini, Adit -->
                </ul>
            </div>
        </nav>
    </div>
</aside>
