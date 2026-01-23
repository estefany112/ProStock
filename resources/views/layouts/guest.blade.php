<!DOCTYPE html>
<html lang="es" translate="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="es">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
   
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="relative min-h-screen font-sans antialiased">

    <!-- FONDO CLICKEABLE -->
    <div 
        class="absolute inset-0 z-0 cursor-pointer pointer-events-auto"
        onclick="location.href='{{ url('/') }}'">

        <img 
            src="{{ asset('assets/img/icono.png') }}" 
            class="w-full h-full object-cover pointer-events-none"
        >
    </div>

    <!-- GRADIENTE -->
    <div 
        class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/40 z-0 pointer-events-none">
    </div>

    <!-- CONTENEDOR DEL FORMULARIO (NO BLOQUEA EL FONDO) -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 pointer-events-none">

        <!-- FORMULARIO CENTRADO Y CLICKEABLE -->
        <div class="pointer-events-auto w-full max-w-md">
            {{ $slot }}
        </div>

    </div>

</body>

</html>
