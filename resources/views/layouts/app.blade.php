<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="gowa-logo.svg" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Alert Notfy --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
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

        @if ($errors->any())
            Toastify({
                text: "{{ $errors->first() }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                className: "rounded-lg shadow-md",
                style: {
                    margin: "0 auto", // biar benar-benar center
                }
            }).showToast();
        @endif
    </script>
</body>

</html>
