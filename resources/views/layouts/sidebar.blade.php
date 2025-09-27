<!-- Sidebar -->
<div id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-secondary-900 border-r border-secondary-200 dark:border-secondary-700 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-secondary-200 dark:border-secondary-700">
            <div class="flex items-center space-x-3">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <span class="text-xl font-bold text-secondary-800 dark:text-white">LaraGO</span>
            </div>
            <button id="closeSidebar"
                class="lg:hidden p-2 rounded-lg hover:bg-secondary-100 dark:hover:bg-secondary-700">
                <svg class="w-5 h-5 text-secondary-600 dark:text-secondary-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <hr class="border-secondary-200 dark:border-secondary-700">

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 font-medium {{ request()->routeIs('dashboard') ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600' : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors' }} rounded ">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                Dasbor
            </a>

            <a href="{{ route('devices.index') }}"
                class="flex items-center px-4 py-3 font-medium {{ request()->routeIs('devices.index') ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600' : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors' }} rounded">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
                Perangkat
            </a>

            <a href="{{ route('contacts.index') }}"
                class="flex items-center px-4 py-3 font-medium {{ request()->routeIs('contacts.index') ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600' : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors' }} rounded">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
                Kontak
            </a>

            <a href="{{ route('message.index') }}"
                class="flex items-center px-4 py-3 font-medium {{ request()->routeIs('message.index') ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600' : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors' }} rounded">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                Kirim Pesan
            </a>

            <a href="{{ route('reminders.index') }}"
                class="flex items-center px-4 py-3 font-medium {{ request()->routeIs('reminders.index') ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600' : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700 transition-colors' }} rounded">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
                Jadwal Pesan
            </a>

            {{-- Dropdown Manajemen --}}
            @php
                $isManajemenActive = request()->routeIs('dashboard');
            @endphp
            <div x-data="{ open: {{ $isManajemenActive ? 'true' : 'false' }} }">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 font-medium rounded transition-colors
        {{ $isManajemenActive
            ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600'
            : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12H8m0 0l4-4m-4 4l4 4"></path>
                        </svg>
                        Manajemen
                    </span>
                    <svg class="w-4 h-4 transform transition-transform {{ $isManajemenActive ? 'rotate-90' : '' }}"
                        :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                {{-- Submenu --}}
                <div x-show="open" x-transition.opacity.duration.300ms class="ml-8 mt-2 space-y-1"
                    @if (!$isManajemenActive) style="display: none;" @endif>
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-2 rounded
            {{ request()->routeIs('dashboard')
                ? 'text-white bg-gradient-to-r from-primary-500 to-primary-600'
                : 'text-secondary-600 dark:text-secondary-300 hover:bg-secondary-100 dark:hover:bg-secondary-700' }}">
                        Users
                    </a>
                </div>
            </div>

        </nav>

        <!-- User Profile -->
        <div class="p-4 border-t border-secondary-200 dark:border-secondary-700">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-primary-400 to-primary-500 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">AD</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-secondary-900 dark:text-white truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-secondary-500 dark:text-secondary-400 truncate">{{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
