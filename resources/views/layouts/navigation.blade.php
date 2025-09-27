<header class="bg-white dark:bg-secondary-900 border-b border-secondary-200 dark:border-secondary-700 sticky top-0 z-30">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
        <div class="flex items-center">
            <button id="openSidebar" class="lg:hidden p-2 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-700">
                <svg class="w-6 h-6 text-secondary-600 dark:text-secondary-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Theme Toggle -->
            <button id="themeToggle"
                class="p-2 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors">
                <svg id="sunIcon" class="w-5 h-5 text-secondary-600 dark:text-secondary-300 hidden dark:block"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <svg id="moonIcon" class="w-5 h-5 text-secondary-600 dark:text-secondary-300 block dark:hidden"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                    </path>
                </svg>
            </button>

            <!-- Notifications -->
            {{-- <button class="p-2 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-700 relative">
                <svg class="w-5 h-5 text-secondary-600 dark:text-secondary-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5V17z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19c-5 0-8-3-8-9s3-9 8-9 8 3 8 9-3 9-8 9z"></path>
                </svg>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button> --}}

            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profileDropdownToggle"
                    class="flex items-center space-x-2 p-1 rounded-xl hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-primary-400 to-primary-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">AD</span>
                    </div>
                    <svg class="w-4 h-4 text-secondary-600 dark:text-secondary-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdown"
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-secondary-800 rounded-xl shadow-lg border border-secondary-200 dark:border-secondary-700 z-50 opacity-0 invisible transform scale-95 transition-all duration-200">
                    <div class="p-4 border-b border-secondary-100 dark:border-secondary-700">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-primary-400 to-primary-500 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-white">AD</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-secondary-900 dark:text-white">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-secondary-500 dark:text-secondary-400">{{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="py-2">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-4 py-3 text-sm text-secondary-700 dark:text-secondary-300 hover:bg-secondary-50 dark:hover:bg-secondary-700 transition-colors">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                            Profile Settings
                        </a>
                    </div>

                    <div class="border-t border-secondary-100 dark:border-secondary-700 py-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
