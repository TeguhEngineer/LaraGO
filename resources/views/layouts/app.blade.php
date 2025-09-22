<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="gowa-logo.svg" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alert Notfy --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        // Primary color scheme - easily customizable
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e'
                        },
                        // Secondary color scheme
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-secondary-50 dark:bg-secondary-900 transition-colors duration-300">
    <!-- Mobile Menu Overlay -->
    <div id="mobileMenuOverlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden lg:hidden"></div>

    @include('layouts.sidebar')

    <div class="lg:ml-64 flex flex-col min-h-screen">

        @include('layouts.navigation')

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @isset($header)
                <div class="mb-8 flex items-center gap-3">
                    {{-- <a href="{{ url()->previous() }}"
                        class="inline-flex items-center text-secondary-900 dark:text-white hover:text-secondary-700 dark:hover:text-gray-300 transition">
                        <!-- Icon panah kiri (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a> --}}

                    <h1 class="text-3xl font-bold text-secondary-900 dark:text-white">
                        {{ $header }}
                    </h1>
                </div>
            @endisset

            {{ $slot }}
        </main>
    </div>

    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Check for saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.classList.toggle('dark', savedTheme === 'dark');

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });

        // Profile dropdown functionality
        const profileDropdownToggle = document.getElementById('profileDropdownToggle');
        const profileDropdown = document.getElementById('profileDropdown');
        let isProfileDropdownOpen = false;

        profileDropdownToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleProfileDropdown();
        });

        function toggleProfileDropdown() {
            isProfileDropdownOpen = !isProfileDropdownOpen;

            if (isProfileDropdownOpen) {
                profileDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                profileDropdown.classList.add('opacity-100', 'visible', 'scale-100');
            } else {
                profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (isProfileDropdownOpen && !profileDropdown.contains(e.target) && !profileDropdownToggle.contains(e
                    .target)) {
                toggleProfileDropdown();
            }
        });

        // Mobile menu functionality
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            mobileMenuOverlay.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mobileMenuOverlay.classList.add('hidden');
        });

        mobileMenuOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mobileMenuOverlay.classList.add('hidden');
        });


        // Color Configuration System
        const colorConfig = {
            themes: {
                blue: {
                    primary: {
                        50: '#f0f9ff',
                        500: '#0ea5e9',
                        600: '#0284c7'
                    }
                },
                emerald: {
                    primary: {
                        50: '#ecfdf5',
                        500: '#10b981',
                        600: '#059669'
                    }
                },
                purple: {
                    primary: {
                        50: '#faf5ff',
                        500: '#a855f7',
                        600: '#9333ea'
                    }
                },
                rose: {
                    primary: {
                        50: '#fff1f2',
                        500: '#f43f5e',
                        600: '#e11d48'
                    }
                }
            },

            applyTheme(themeName) {
                const theme = this.themes[themeName];
                if (!theme) return;

                const root = document.documentElement;
                Object.entries(theme.primary).forEach(([shade, color]) => {
                    root.style.setProperty(`--color-primary-${shade}`, color);
                });

                // Save preference
                localStorage.setItem('colorTheme', themeName);
            },

            init() {
                const savedTheme = localStorage.getItem('colorTheme') || 'blue';
                this.applyTheme(savedTheme);
            }
        };

        // Initialize color configuration
        colorConfig.init();

        // Example: Change theme programmatically
        // colorConfig.applyTheme('emerald'); // Green theme
        // colorConfig.applyTheme('purple'); // Purple theme
        // colorConfig.applyTheme('rose'); // Pink/Rose theme
    </script>

    <style>
        /* Custom scrollbar for sidebar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 2px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }

        /* Dark mode scrollbar */
        .dark .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.3);
        }

        .dark .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.5);
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Custom CSS variables for easy color customization */
        :root {
            --color-primary-50: #f0f9ff;
            --color-primary-100: #e0f2fe;
            --color-primary-200: #bae6fd;
            --color-primary-300: #7dd3fc;
            --color-primary-400: #38bdf8;
            --color-primary-500: #0ea5e9;
            --color-primary-600: #0284c7;
            --color-primary-700: #0369a1;
            --color-primary-800: #075985;
            --color-primary-900: #0c4a6e;
        }
    </style>


    {{-- Alert Notfy --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        @if (session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                gravity: "top", // top atau bottom
                position: "center", // left, center atau right
                backgroundColor: "linear-gradient(to right, #ef4444, #b91c1c)", // merah gradient
                className: "rounded-lg shadow-md",
                style: {
                    margin: "0 auto", // biar benar-benar center
                }
            }).showToast();
        @endif
        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 4000,
                gravity: "top", // top atau bottom
                position: "center", // left, center atau right
                backgroundColor: "linear-gradient(to right, #22c55e, #16a34a)", // hijau gradient
                className: "rounded-lg shadow-md",
                style: {
                    margin: "0 auto", // biar benar-benar center
                }
            }).showToast();
        @endif

        @if (session('warning'))
            Toastify({
                text: "{{ session('warning') }}",
                duration: 4000,
                gravity: "top", // top atau bottom
                position: "center", // left, center atau right
                backgroundColor: "linear-gradient(to right, #f59e0b, #d97706)", // kuning gradient
                className: "rounded-lg shadow-md",
                style: {
                    margin: "0 auto", // biar benar-benar center
                }
            }).showToast();
        @endif
        @if (session('info'))
            Toastify({
                text: "{{ session('info') }}",
                duration: 4000,
                gravity: "top", // top atau bottom
                position: "center", // left, center atau right
                backgroundColor: "linear-gradient(to right, #3b82f6, #1e40af)", // biru gradient
                className: "rounded-lg shadow-md",
                style: {
                    margin: "0 auto", // biar benar-benar center
                }
            }).showToast();
        @endif


        @if (session('info_verify'))
            Toastify({
                text: "{{ session('info_verify') }}",
                duration: 4000,
                gravity: "top", // top atau bottom
                position: "center", // left, center atau right
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                className: "rounded-lg shadow-md",
                style: {
                    margin: "0 auto", // biar benar-benar center
                }
            }).showToast();
        @endif

        // @if ($errors->any())
        //     Toastify({
        //         text: "{{ $errors->first() }}",
        //         duration: 4000,
        //         gravity: "top",
        //         position: "right",
        //         backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        //         className: "rounded-lg shadow-md",
        //         style: {
        //             margin: "0 auto", // biar benar-benar center
        //         }
        //     }).showToast();
        // @endif
    </script>
</body>

</html>
