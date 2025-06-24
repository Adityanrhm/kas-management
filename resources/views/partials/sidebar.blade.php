@php
    $menus = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-simple',
            'route' => 'dashboard',
            'submenus' => [],
        ],
        [
            'name' => 'Master',
            'icon' => 'fa-solid fa-circle-user',
            'route' => 'master',
            'submenus' => [
                ['name' => 'Data Siswa', 'route' => 'master.siswa'],
                ['name' => 'Data Guru', 'route' => 'master.guru'],
            ],
        ],
    ];
@endphp


<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[100px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-50 flex h-screen w-[323px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 transition-all duration-300 ease-linear dark:border-gray-800 dark:bg-slate-900 lg:static lg:translate-x-0">

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
                <h3 class="mt-6 mb-4 px-1 lg:mt-1 text-xs uppercase tracking-wider font-medium text-slate-400">
                    <span :class="sidebarToggle ? 'lg:hidden' : ''">MENU</span>
                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto text-slate-400"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.999 10.245c.966 0 1.75.783 1.75 1.75s-.784 1.75-1.75 1.75-1.75-.784-1.75-1.75.784-1.75 1.75-1.75Zm12 0c.967 0 1.75.783 1.75 1.75s-.783 1.75-1.75 1.75-1.75-.784-1.75-1.75.783-1.75 1.75-1.75ZM13.749 12c0-.967-.784-1.75-1.75-1.75s-1.75.783-1.75 1.75.784 1.75 1.75 1.75 1.75-.783 1.75-1.75Z"
                            fill="currentColor" />
                    </svg>
                </h3>

                <ul class="flex flex-col px-2 text-[16px]">
                    @foreach ($menus as $menu)
                        @php
                            // Menentukan apakah menu utama aktif
                            $isActive = false;

                            if (isset($menu['route']) && request()->routeIs($menu['route'])) {
                                $isActive = true;
                            } elseif (!empty($menu['submenus'])) {
                                foreach ($menu['submenus'] as $submenu) {
                                    if (request()->routeIs($submenu['route'])) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if (empty($menu['submenus']))
                            <!-- Menu tanpa submenu -->
                            <li class="my-1">
                                <a href="{{ route($menu['route']) }}"
                                    :class="sidebarToggle ? 'justify-center px-2 py-3' : 'justify-start px-5 py-3'"
                                    class="flex items-center gap-4 rounded-lg font-semibold transition-all duration-200
                                        {{ $isActive ? 'bg-indigo-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                                    <i class="{{ $menu['icon'] }} text-[18px] w-6 h-6"></i>
                                    <span x-show="!sidebarToggle"
                                        class="transition-all duration-300">{{ $menu['name'] }}</span>
                                </a>
                            </li>
                        @else
                            <!-- Menu dengan submenu -->
                            <li class="my-1" x-data="{ open: {{ $isActive ? 'true' : 'false' }} }" x-effect="if (sidebarToggle) open = false">
                                <button @click="open = !open"
                                    :class="sidebarToggle ? 'justify-center px-2 py-3' : 'justify-between px-4 py-3'"
                                    class="flex w-full items-center rounded-lg font-semibold transition-all duration-200
                                        {{ $isActive ? 'bg-indigo-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
                                    <div class="flex items-center gap-4">
                                        <i class="{{ $menu['icon'] }} text-[18px] w-6 h-6"></i>
                                        <span x-show="!sidebarToggle"
                                            class="transition-all duration-300">{{ $menu['name'] }}</span>
                                    </div>
                                    <i x-show="!sidebarToggle"
                                        class="fas fa-chevron-right w-4 h-4 transition-transform duration-200"
                                        :class="{ 'rotate-90': open }"></i>
                                </button>

                                <!-- Submenu -->
                                <ul x-show="open && !sidebarToggle" x-collapse
                                    class="mt-2 space-y-1 pl-10 text-slate-400 text-[15px] font-normal">
                                    @foreach ($menu['submenus'] as $submenu)
                                        <li>
                                            <a href="{{ route($submenu['route']) }}"
                                                class="block rounded-md px-3 py-2 hover:bg-slate-700 hover:text-white transition-all
                                                    {{ request()->routeIs($submenu['route']) ? 'text-white bg-slate-700' : '' }}">
                                                {{ $submenu['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>

            </div>
        </nav>
    </div>
</aside>
