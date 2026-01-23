<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PROSERVE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-900 text-gray-100">

<div class="flex min-h-screen bg-slate-900">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- CONTENIDO --}}
    <main class="flex-1 p-6" style="background-color: #0f172a !important;">
        <div class="bg-slate-900 min-h-screen">
            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
