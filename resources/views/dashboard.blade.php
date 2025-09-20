<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl p-6 shadow-sm border border-secondary-100 dark:border-secondary-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Total Ruangan</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white">25</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-sm text-green-600 dark:text-green-400 font-medium">+12%</span>
                <span class="text-sm text-secondary-500 dark:text-secondary-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl p-6 shadow-sm border border-secondary-100 dark:border-secondary-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Total Users</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white">142</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-sm text-green-600 dark:text-green-400 font-medium">+8%</span>
                <span class="text-sm text-secondary-500 dark:text-secondary-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl p-6 shadow-sm border border-secondary-100 dark:border-secondary-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Booking Aktif</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white">18</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m-10 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-sm text-red-600 dark:text-red-400 font-medium">-5%</span>
                <span class="text-sm text-secondary-500 dark:text-secondary-400 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-secondary-800 rounded-2xl p-6 shadow-sm border border-secondary-100 dark:border-secondary-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Revenue</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white">Rp 2.4M</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-sm text-green-600 dark:text-green-400 font-medium">+18%</span>
                <span class="text-sm text-secondary-500 dark:text-secondary-400 ml-2">dari bulan lalu</span>
            </div>
        </div>
    </div>

</x-app-layout>
