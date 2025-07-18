<header
    class="sticky top-0 z-50 flex w-full bg-white rounded-2xl lg:rounded-none border-b dark:border-[rgba(255,255,255,0.25)] dark:bg-black">
    <div class="flex grow flex-col items-center justify-between lg:flex-row lg:px-4">
        <div
            class="flex w-full items-center justify-between gap-2 px-3 py-2 sm:gap-4 lg:justify-normal lg:border-b-0 lg:px-0 lg:py-3 dark:border-gray-800">
            <!-- Hamburger Toggle BTN -->
            <button :class="sidebarToggle ? 'lg:bg-transparent dark:lg:bg-transparent bg-white/5 dark:bg-white/5' : ''"
                class="z-50 flex h-9 w-9 items-center justify-center rounded-lg bg-white/5 text-gray-500 lg:h-10 lg:w-10 \ 
                    wdsh transition-all duration-300 border dark:border-[rgba(255,255,255,0.25)] dark:text-gray-400"
                @click.stop="sidebarToggle = !sidebarToggle">
                <svg class="hidden fill-current lg:block" width="14" height="10" viewBox="0 0 16 12" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
                        fill="" />
                </svg>

                <svg :class="sidebarToggle ? 'hidden' : 'block lg:hidden'" class="fill-current lg:hidden" width="20"
                    height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
                        fill="" />
                </svg>

                <!-- cross icon -->
                <svg :class="sidebarToggle ? 'block lg:hidden' : 'hidden'" class="fill-current" width="20"
                    height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                        fill="" />
                </svg>
            </button>
            <!-- Hamburger Toggle BTN -->

            <a href="{{ route('dashboard') }}" class="lg:hidden">
                <x-application-logo class="w-10 h-10 fill-current text-white/50" />
            </a>

            <!-- Application nav menu button -->
            <button
                class="z-50 flex h-9 w-9 items-center justify-center rounded-lg text-white/60 bg-white/5 hover:bg-black lg:hidden dark:text-white/60 border border-[rgba(255,255,255,0.25)] hover:dark:border-[rgba(255,255,255,0.25)]"
                :class="menuToggle ? 'bg-gray-100 dark:bg-white/5' : ''" @click.stop="menuToggle = !menuToggle">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
                        fill="" />
                </svg>
            </button>
            <!-- Application nav menu button -->

        </div>

        <div :class="menuToggle ? 'flex' : 'hidden'"
            class="shadow-theme-md w-full items-center justify-between gap-4 px-4 py-3 lg:flex lg:justify-end lg:px-0 lg:shadow-none">
            <!-- User Area -->
            <div class="relative ml-auto" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                <a class="flex items-center text-white dark:text-white/70 hover:text-white dark:hover:text-white transition-colors duration-300 group wdsh"
                    href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
                    <!-- Avatar with enhanced styling -->
                    <x-user-avatar :src="Auth::user()->avatar" class="mr-2 h-8 w-8" image-class="rounded-lg" />
                    <!-- Username with better typography -->
                    <span class="text-sm mr-1 block font-medium tracking-wide">
                        {{ Auth::user()->username }}
                    </span>

                    <!-- Enhanced chevron icon -->
                    <svg :class="dropdownOpen && 'rotate-180'"
                        class="stroke-gray-500 dark:stroke-gray-400 group-hover:stroke-gray-700 dark:group-hover:stroke-gray-300 transition-all duration-200"
                        width="16" height="16" viewBox="0 0 18 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.3125 8.65625L9 13.3437L13.6875 8.65625" stroke="" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>

                <!-- Enhanced Dropdown -->
                <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                    class="absolute right-0 mt-6 w-72 bg-white/10 rounded-xl shadow-2xl border border-gray-100 dark:border-white/20 overflow-hidden backdrop-blur-lg">

                    <!-- Header Section with gradient background -->
                    <div class="p-4 border-b border-gray-100 dark:border-white/20">
                        <div class="flex items-center space-x-3">
                            <x-user-avatar :src="Auth::user()->avatar" class="ring-white h-10 w-10" image-class="rounded-lg" />
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-bold text-gray-900 dark:text-white truncate">
                                    {{ Auth::user()->username }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-300 truncate">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="p-2">
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white dark:text-white/80 transition-all duration-300 transform wdsh hover:scale-[1.01]">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center transition duration-300">
                                        <svg class="w-4 h-4 fill-white/50 dark:fill-white/50 group-hover:fill-white dark:group-hover:fill-white transition-colors duration-300"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium">Edit Profile</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Update your information
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>

                        <!-- Divider -->
                        <div class="my-2 border-t border-gray-100 dark:border-white/20"></div>

                        <!-- Logout Section -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="group w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 transform hover:scale-[1.01] wdsR">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-red-50 dark:bg-red-900/30 rounded-lg flex items-center justify-center group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors duration-200">
                                    <svg class="w-4 h-4 fill-red-500 dark:fill-red-400 transition-colors duration-200"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.1007 19.247C14.6865 19.247 14.3507 18.9112 14.3507 18.497L14.3507 14.245H12.8507V18.497C12.8507 19.7396 13.8581 20.747 15.1007 20.747H18.5007C19.7434 20.747 20.7507 19.7396 20.7507 18.497L20.7507 5.49609C20.7507 4.25345 19.7433 3.24609 18.5007 3.24609H15.1007C13.8581 3.24609 12.8507 4.25345 12.8507 5.49609V9.74501L14.3507 9.74501V5.49609C14.3507 5.08188 14.6865 4.74609 15.1007 4.74609L18.5007 4.74609C18.9149 4.74609 19.2507 5.08188 19.2507 5.49609L19.2507 18.497C19.2507 18.9112 18.9149 19.247 18.5007 19.247H15.1007ZM3.25073 11.9984C3.25073 12.2144 3.34204 12.4091 3.48817 12.546L8.09483 17.1556C8.38763 17.4485 8.86251 17.4487 9.15549 17.1559C9.44848 16.8631 9.44863 16.3882 9.15583 16.0952L5.81116 12.7484L16.0007 12.7484C16.4149 12.7484 16.7507 12.4127 16.7507 11.9984C16.7507 11.5842 16.4149 11.2484 16.0007 11.2484L5.81528 11.2484L9.15585 7.90554C9.44864 7.61255 9.44847 7.13767 9.15547 6.84488C8.86248 6.55209 8.3876 6.55226 8.09481 6.84525L3.52309 11.4202C3.35673 11.5577 3.25073 11.7657 3.25073 11.9984Z" />
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="font-medium">Sign Out</div>
                                    <div class="text-xs text-red-400 dark:text-red-300">End your session</div>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- User Area -->
        </div>
    </div>
</header>
