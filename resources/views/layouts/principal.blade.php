<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PROSERVE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: true }" class="bg-slate-900">
 
    {{-- TOPBAR (FIJA EN TODAS LAS VISTAS) --}}
    <header class="h-16 bg-white border-b border-slate-200
                flex items-center justify-between px-6
                sticky top-0 z-50
                text-slate-800">

        {{-- IZQUIERDA: BOTÓN + LOGO --}}
        <div class="flex items-center gap-4">

            {{-- BOTÓN SIDEBAR --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="flex items-center justify-center w-10 h-10
                    rounded-md border border-slate-300
                    text-slate-600 hover:bg-slate-100 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- LOGO / NOMBRE --}}
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-slate-800 tracking-wide">
                    PROSERVE
                </span>
            </div>
        </div>

        {{-- DERECHA: USUARIO --}}
        <div class="flex items-center gap-4">

            <div class="text-right leading-tight hidden sm:block">
                <p class="text-sm font-medium text-slate-800">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-slate-500">
                    {{ auth()->user()->roles->first()->label ?? 'Usuario' }}
                </p>
            </div>

            <div class="w-9 h-9 rounded-full bg-slate-800
                        flex items-center justify-center text-sm font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

        </div>

    </header>

    <div class="flex">

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
