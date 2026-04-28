<!DOCTYPE html>
<html lang="es" translate="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="es">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

    <script>
        setInterval(() => {
            fetch('/check-session')
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = '/';
                    }
                })
                .catch(error => {
                    console.error('Error verificando sesión:', error);
                });
        }, 60000); // cada 1 minuto
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const originalFetch = window.fetch;

            window.fetch = function () {
                return originalFetch.apply(this, arguments)
                    .then(response => {
                        if (response.status === 401) {
                            window.location.href = '/';
                        }
                        return response;
                    });
            };

        });
    </script>

<body class="font-sans antialiased bg-[#0B1120] text-slate-200">
    <div x-data="{ openSidebar: false }" class="min-h-screen flex">
        @include('layouts.partials.sidebar')
        <div class="flex-1 flex flex-col">
            <header class="h-16 border-b border-slate-800/50 bg-[#0B1120]/80 backdrop-blur-md sticky top-0 z-40"></header>
            <main class="flex-1 p-8">
                {{ $slot ?? '' }} @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
