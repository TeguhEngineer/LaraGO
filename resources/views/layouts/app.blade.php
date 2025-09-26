<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        // Fix for dark mode flicker
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <link rel="shortcut icon" href="gowa-logo.svg" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Flat Icon --}}
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    {{-- Alert Notfy --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-secondary-50 dark:bg-secondary-900 transition-colors duration-100">
    <!-- Mobile Menu Overlay -->
    <div id="mobileMenuOverlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden lg:hidden"></div>

    @include('layouts.sidebar')

    <div class="lg:ml-64 flex flex-col min-h-screen">

        @include('layouts.navigation')

        <main class="flex-1 p-4 sm:p-6 lg:p-6">
            @isset($header)
                <div class="mb-5 flex items-center gap-3">
                    {{-- <a href="{{ url()->previous() }}"
                        class="inline-flex items-center text-secondary-900 dark:text-white hover:text-secondary-700 dark:hover:text-gray-300 transition">
                        <!-- Icon panah kiri (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a> --}}

                    <h1 class="text-2xl font-bold text-secondary-900 dark:text-white">
                        {{ $header }}
                    </h1>
                </div>
            @endisset

            {{ $slot }}
        </main>
    </div>

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

    @stack('scripts')
</body>

</html>
