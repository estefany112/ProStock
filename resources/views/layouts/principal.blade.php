<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PROSERVE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Ocultar scrollbar del sidebar para evitar el error visual en producción */
        .custom-sidebar-scroll::-webkit-scrollbar { width: 0px; background: transparent; }
        .custom-sidebar-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Prevenir vibración horizontal */
        body { overflow-x: hidden; }
    </style>
</head>

<body class="bg-slate-900" 
      x-data="{ 
            sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false', 
            openUser: false 
      }">

    {{-- HEADER FIJO --}}
    <header class="fixed top-0 left-0 w-full h-16 bg-white border-b border-slate-200 z-50 flex items-center justify-between px-6 shadow-sm">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)"
                class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-300">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <span class="text-xl font-extrabold text-slate-900 tracking-tight uppercase">PROSERVE</span>
            </div>
        </div>

        {{-- USUARIO --}}
        <div class="relative">
            <button @click="openUser = !openUser" class="flex items-center gap-3 focus:outline-none group">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] uppercase tracking-widest font-extrabold bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">
                        {{ auth()->user()->roles->first()->label ?? 'Usuario' }}
                    </p>
                </div>
                <div class="relative w-11 h-11 rounded-full overflow-hidden ring-2 ring-transparent group-hover:ring-emerald-300 transition-all">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-blue-500 flex items-center justify-center text-white font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                </div>
            </button>
            <div x-show="openUser" @click.away="openUser = false" x-transition class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-xl shadow-xl py-2 z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Editar perfil</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>

    {{-- WRAPPER PRINCIPAL --}}
    <div class="flex pt-16 min-h-screen">
        {{-- SIDEBAR COMPONENTE --}}
        @include('layouts.partials.sidebar')

        {{-- CONTENIDO DINÁMICO --}}
        <main class="flex-1 transition-all duration-300 overflow-x-hidden" 
              :class="sidebarOpen ? 'md:ml-64' : 'ml-0'">
            <div class="p-4 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>