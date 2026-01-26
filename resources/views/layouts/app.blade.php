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

<body class="font-sans antialiased bg-slate-900">
<div x-data="{ openSidebar: false }" class="min-h-screen flex">

    @include('layouts.partials.sidebar')

    <div class="flex-1 flex flex-col">

        <header class="bg-slate-800 text-white px-6 py-3 flex items-center justify-between">

            <!-- ☰ SOLO EN MÓVIL -->
           <button
                @click="openSidebar = true"
                class="lg:hidden p-2 text-white text-2xl">
                ☰
           </button>

            <span>{{ Auth::user()->name }}</span>

        </header>

        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

    </div>
</div>
</body>

</html>
