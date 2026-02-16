<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PROSERVE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="@auth bg-slate-900 @else bg-gray-100 @endauth"
      @auth 
        x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true }"
        x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))" 
      @endauth>

    {{-- HEADER --}}
    <header class="h-16 bg-white border-b border-slate-200
                flex items-center justify-between px-6
                sticky top-0 z-50 text-slate-800">

        <div class="flex items-center gap-4">

            @auth
            {{-- BOTÓN SIDEBAR SOLO SI ESTÁ LOGEADO --}}
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
            @endauth

            <span class="text-xl font-bold tracking-wide">
                PROSERVE
            </span>

        </div>

        @auth
        {{-- USUARIO SOLO SI ESTÁ LOGEADO --}}
        <div class="flex items-center gap-4">

            <div class="text-right leading-tight hidden sm:block">
                <p class="text-sm font-medium">
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
        @endauth

    </header>

    @auth
    {{-- SISTEMA INTERNO --}}
    <div class="flex">
        @include('layouts.partials.sidebar')

        <main class="flex-1 p-6 bg-slate-900 min-h-screen">
            @yield('content')
        </main>
    </div>
    @else
    {{-- VISTA PUBLICA --}}
    <main class="p-6 min-h-screen">
        @yield('content')
    </main>
    @endauth

</body>
</html>
