<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PROSERVE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

{{-- Usamos x-data con persistencia para que el sidebar recuerde su estado --}}
<body class="bg-slate-900" 
      x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false', openUser: false }">

    {{-- HEADER FIJO --}}
    <header class="fixed top-0 left-0 w-full h-16 bg-white border-b border-slate-200 z-50 flex items-center justify-between px-6 shadow-sm">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)"
                class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-xl font-extrabold text-slate-900">PROSERVE</span>
        </div>
        
        {{-- Aquí iría tu botón de usuario que se eliminó --}}
        <div class="relative">
            <button @click="openUser = !openUser" class="flex items-center gap-3 focus:outline-none">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] uppercase tracking-widest font-extrabold bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">
                        {{ auth()->user()->roles->first()->label ?? 'Usuario' }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold shadow-inner">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </button>

            {{-- MENÚ DESPLEGABLE --}}
            <div x-show="openUser" 
                 @click.away="openUser = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-xl shadow-xl py-2 z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">Editar perfil</a>
                <div class="border-t border-slate-100 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>

    {{-- CONTENEDOR PRINCIPAL --}}
    {{-- pt-16 es fundamental para que el contenido no quede oculto bajo el header --}}
    <div class="flex pt-16 min-h-screen">
        
        {{-- SIDEBAR: Posición relativa al contenedor flex --}}
        <aside class="w-64 bg-slate-950 h-[calc(100vh-4rem)] overflow-y-auto transition-all duration-300 flex-shrink-0"
               :class="sidebarOpen ? 'block' : 'hidden'">
            @include('layouts.partials.sidebar')
        </aside>

        {{-- CONTENIDO: Ocupa todo el espacio restante --}}
        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>