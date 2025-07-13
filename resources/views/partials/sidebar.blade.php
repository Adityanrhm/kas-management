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
            // 'roles' => ['bendahara'],
            'submenus' => [
                [
                    'name' => 'Data Siswa',
                    'route' => 'master.siswa',
                    'roles' => ['admin'], // Hanya admin yang bisa akses
                ],
            ],
            'roles' => [], // Parent menu bisa diakses semua role
        ],
    ];

    // Function untuk check access berdasarkan roles saja
    function canAccessMenu($menu, $user)
    {
        // Jika tidak ada roles yang didefinisikan, berarti semua bisa akses
        if (empty($menu['roles'])) {
            return true;
        }

        // Check roles
        return $user->hasAnyRole($menu['roles']);
    }
@endphp

<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[100px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-50 flex h-screen w-[323px] flex-col overflow-y-hidden border-r \ 
        border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]
            bg-white px-5 transition-all duration-300 ease-linear  dark:bg-black lg:static lg:translate-x-0">

    <!-- Sidebar Header -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-start'"
        class="sidebar-header flex items-center gap-3 pb-7 pt-7 transition-all duration-300">

        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo
                class="w-5 h-5 lg:w-12 lg:h-12 fill-current text-gray-500 ml-1 wdsh transition-all duration-300" />
            <div x-show="!sidebarToggle && window.innerWidth >= 1024" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2"
                class="hidden lg:flex flex-col ml-3 leading-snug text-left font-semibold text-gray-700 dark:text-gray-100 text-lg font-sans">
                <span class="font-sans">Kas</span>
                <span class="font-sans">Management</span>
            </div>
        </a>
    </div>

    <!-- Sidebar Content -->
    <div class="flex-1 overflow-y-auto">
        <nav x-data="{ selected: $persist('Dashboard') }">
            <div>
                <!-- Menu Title -->
                <h3 class="mt-6 mb-4 px-2 lg:mt-1 text-xs uppercase tracking-wider font-medium text-white/50">
                    <span :class="sidebarToggle ? 'lg:hidden' : ''">MENU</span>
                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto text-white/50"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.999 10.245c.966 0 1.75.783 1.75 1.75s-.784 1.75-1.75 1.75-1.75-.784-1.75-1.75.784-1.75 1.75-1.75Zm12 0c.967 0 1.75.783 1.75 1.75s-.783 1.75-1.75 1.75-1.75-.784-1.75-1.75.783-1.75 1.75-1.75ZM13.749 12c0-.967-.784-1.75-1.75-1.75s-1.75.783-1.75 1.75.784 1.75 1.75 1.75 1.75-.783 1.75-1.75Z"
                            fill="currentColor" />
                    </svg>
                </h3>

                <ul class="flex flex-col px-2 text-[16px]">
                    @foreach ($menus as $menu)
                        @php
                            // Check jika user bisa akses menu utama
                            $canAccessMainMenu = canAccessMenu($menu, auth()->user());

                            // Check submenu yang bisa diakses
                            $accessibleSubmenus = [];
                            if (!empty($menu['submenus'])) {
                                foreach ($menu['submenus'] as $submenu) {
                                    if (canAccessMenu($submenu, auth()->user())) {
                                        $accessibleSubmenus[] = $submenu;
                                    }
                                }
                            }

                            // Jika menu utama tidak bisa diakses DAN tidak ada submenu yang bisa diakses, skip
                            if (!$canAccessMainMenu && empty($accessibleSubmenus)) {
                                continue;
                            }

                            // Menentukan apakah menu utama aktif
                            $isActive = false;
                            if (isset($menu['route']) && request()->routeIs($menu['route'])) {
                                $isActive = true;
                            } elseif (!empty($accessibleSubmenus)) {
                                foreach ($accessibleSubmenus as $submenu) {
                                    if (request()->routeIs($submenu['route'])) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if (empty($menu['submenus']))
                            <!-- Menu tanpa submenu -->
                            @if ($canAccessMainMenu)
                                <li class="my-1">
                                    <a href="{{ route($menu['route']) }}"
                                        :class="sidebarToggle ? 'justify-center px-2 py-3' : 'justify-start px-5 py-3'"
                                        class="flex items-center gap-4 rounded-lg font-semibold transition-all duration-200 bg-white/5 \
                                        border border-[rgba(255,255,255,0.15)] dark:border-[rgba(255,255,255,0.15)] wdsh
                                           \ {{ $isActive
                                               ? 'bg-white/5 border wds2 text-white'
                                               : 'text-slate-200 hover:bg-white/5 hover:border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]' }}">
                                        <i class="{{ $menu['icon'] }} text-[18px] w-6 h-6"></i>
                                        <span x-show="!sidebarToggle"
                                            class="transition-all duration-300">{{ $menu['name'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @else
                            <!-- Menu dengan submenu -->
                            @if (!empty($accessibleSubmenus))
                                <li class="my-1" x-data="{
                                    open: {{ $isActive ? 'true' : 'false' }},
                                    isRotating: false,
                                    toggleOpen() {
                                        if (!sidebarToggle) {
                                            this.isRotating = true;
                                            this.open = !this.open;
                                            // Reset rotating state after animation
                                            setTimeout(() => { this.isRotating = false; }, 300);
                                        }
                                    }
                                }"
                                    x-effect="if (sidebarToggle) { open = false; isRotating = false; }">
                                    <button @click="toggleOpen()"
                                        :class="sidebarToggle ? 'justify-center px-2 py-3' : 'justify-between px-4 py-3'"
                                        class="flex w-full items-center rounded-lg font-semibold transition-all duration-200 wdsh \ 
                                                border border-[rgba(255,255,255,0.15)] dark:border-[rgba(255,255,255,0.15)] bg-white/5 \ 
                                                hover:border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]
                                            {{ $isActive ? 'bg-black-700 text-white' : 'text-slate-200 hover:bg-white/5' }}">
                                        <div class="flex items-center gap-4">
                                            <i class="{{ $menu['icon'] }} text-[18px] w-6 h-6 flex-shrink-0"></i>
                                            <span x-show="!sidebarToggle"
                                                class="whitespace-nowrap">{{ $menu['name'] }}</span>
                                        </div>
                                        <!-- Rotasi hanya saat button diklik, bukan saat navigasi -->
                                        <i x-show="!sidebarToggle"
                                            class="fas fa-chevron-left w-4 h-4 transition-transform duration-300 ease-in-out"
                                            :class="open ? 'transform rotate-[-90deg]' : 'transform rotate-0'"
                                            style="transform-origin: center;"></i>
                                    </button>

                                    <!-- Submenu dengan animasi smooth untuk buka dan tutup -->
                                    <div x-show="open && !sidebarToggle"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-screen"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 max-h-screen"
                                        x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden">
                                        <ul class="mt-2 space-y-1 pl-10 text-slate-400 text-[15px] font-normal ">
                                            @foreach ($accessibleSubmenus as $submenu)
                                                <li>
                                                    <a href="{{ route($submenu['route']) }}"
                                                        class="block rounded-md px-3 py-2 wdsh text-white/50 hover:bg-white/5 hover:text-white transition-all duration-300 \
                                                            border border-[rgba(255,255,255,0.15)] dark:border-[rgba(255,255,255,0.15)] \
                                                            hover:border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]
                                                            {{ request()->routeIs($submenu['route']) ? 'text-white bg-white/5 ' : '' }}">
                                                        {{ $submenu['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</aside>
