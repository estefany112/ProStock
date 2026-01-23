<!DOCTYPE html>
<html lang="es" translate="no">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Language" content="es">
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <script>
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('hidden');
    }

    // Cierra el menú al hacer click fuera
    document.addEventListener('click', function (e) {
        const button = document.querySelector('[data-user-menu-button]');
        const menu = document.getElementById('userMenu');

        if (!menu || !button) return;

        if (!button.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>

    <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">

        @include('layouts.partials.sidebar')

        <div class="flex-1">

            <header class="bg-slate-800 text-white px-6 py-3 flex justify-end">
                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center gap-2">
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="userMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded shadow">
                        <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 hover:bg-gray-100">
                            Editar perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
