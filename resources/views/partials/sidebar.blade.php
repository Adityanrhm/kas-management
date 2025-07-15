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
            'submenus' => [
                [
                    'name' => 'Data Siswa',
                    'route' => 'master.siswa',
                    'roles' => ['admin', 'bendahara'],
                ],
            ],
            'roles' => [],
        ],
    ];

    function canAccessMenu($menu, $user)
    {
        if (empty($menu['roles'])) {
            return true;
        }

        return $user->hasAnyRole($menu['roles']);
    }
@endphp

<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[80px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-50 flex h-screen w-[280px] flex-col overflow-y-hidden border-r \ 
        border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]
            bg-white px-4 transition-all duration-300 ease-linear  dark:bg-black lg:static lg:translate-x-0">

    <!-- Sidebar Header -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-start'"
        class="sidebar-header flex items-center gap-3 py-6 transition-all duration-300">

        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="w-8 h-8 lg:w-10 lg:h-10 fill-current text-gray-500 transition-all duration-300" />
            <div x-show="!sidebarToggle && window.innerWidth >= 1024" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-2"
                class="hidden lg:flex flex-col ml-3 leading-tight text-left font-semibold text-gray-700 dark:text-gray-100 text-lg font-sans">
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
                <h3 class="mb-4 px-2 text-xs uppercase tracking-wider font-medium text-white/50">
                    <span :class="sidebarToggle ? 'lg:hidden' : ''">MENU</span>
                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto text-white/50"
                        width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.999 10.245c.966 0 1.75.783 1.75 1.75s-.784 1.75-1.75 1.75-1.75-.784-1.75-1.75.784-1.75 1.75-1.75Zm12 0c.967 0 1.75.783 1.75 1.75s-.783 1.75-1.75 1.75-1.75-.784-1.75-1.75.783-1.75 1.75-1.75ZM13.749 12c0-.967-.784-1.75-1.75-1.75s-1.75.783-1.75 1.75.784 1.75 1.75 1.75 1.75-.783 1.75-1.75Z"
                            fill="currentColor" />
                    </svg>
                </h3>

                <ul class="flex flex-col text-[15px] space-y-2">
                    @foreach ($menus as $menu)
                        @php
                            $canAccessMainMenu = canAccessMenu($menu, auth()->user());

                            $accessibleSubmenus = [];
                            if (!empty($menu['submenus'])) {
                                foreach ($menu['submenus'] as $submenu) {
                                    if (canAccessMenu($submenu, auth()->user())) {
                                        $accessibleSubmenus[] = $submenu;
                                    }
                                }
                            }

                            if (!$canAccessMainMenu && empty($accessibleSubmenus)) {
                                continue;
                            }

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
                            @if ($canAccessMainMenu)
                                <li>
                                    <a href="{{ route($menu['route']) }}"
                                        :class="sidebarToggle ? 'justify-center px-3 py-3' : 'justify-start px-4 py-3'"
                                        class="flex items-center gap-3 rounded-lg font-medium transition-all duration-200 bg-white/5 \
                                        border border-[rgba(255,255,255,0.15)] dark:border-[rgba(255,255,255,0.15)] wdsh
                                           \ {{ $isActive
                                               ? 'bg-white/5 border wds2 text-white'
                                               : 'text-slate-200 hover:bg-white/5 hover:border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]' }}">
                                        <i class="{{ $menu['icon'] }} text-[16px] w-5 h-5 flex-shrink-0"></i>
                                        <span x-show="!sidebarToggle"
                                            class="transition-all duration-300 whitespace-nowrap">{{ $menu['name'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @else
                            @if (!empty($accessibleSubmenus))
                                <li x-data="{
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
                                        :class="sidebarToggle ? 'justify-center px-3 py-3' : 'justify-between px-4 py-3'"
                                        class="flex w-full items-center rounded-lg font-medium transition-all duration-200 wdsh \ 
                                                border border-[rgba(255,255,255,0.15)] dark:border-[rgba(255,255,255,0.15)] bg-white/5 \ 
                                                hover:border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]
                                            {{ $isActive ? 'bg-black-700 text-white' : 'text-slate-200 hover:bg-white/5' }}">
                                        <div class="flex items-center gap-3">
                                            <i class="{{ $menu['icon'] }} text-[16px] w-5 h-5 flex-shrink-0"></i>
                                            <span x-show="!sidebarToggle"
                                                class="whitespace-nowrap">{{ $menu['name'] }}</span>
                                        </div>

                                        <i x-show="!sidebarToggle"
                                            class="fas fa-chevron-left w-4 h-4 transition-transform duration-300 ease-in-out"
                                            :class="open ? 'transform rotate-[-90deg]' : 'transform rotate-0'"
                                            style="transform-origin: center;"></i>
                                    </button>

                                    <div x-show="open && !sidebarToggle"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-screen"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 max-h-screen"
                                        x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden">
                                        <ul class="mt-2 space-y-1 pl-8 text-slate-400 text-[14px] font-normal">
                                            @foreach ($accessibleSubmenus as $submenu)
                                                <li>
                                                    <a href="{{ route($submenu['route']) }}"
                                                        class="block rounded-md px-3 py-2.5 wdsh text-white/50 hover:bg-white/5 hover:text-white transition-all duration-300 \
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
