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

<body class="@auth bg-slate-900 @else bg-gray-100 @endauth"
      @auth x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true }"
            x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))" @endauth>

    {{-- HEADER --}}
    <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-6 sticky top-0 z-50 shadow-sm transition-all duration-300">
        <div class="flex items-center gap-4">
            @auth
            <button @click="sidebarOpen = !sidebarOpen"
                class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-300 group">
                <svg class="w-6 h-6 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            @endauth

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/no-image.jpg') }}" class="w-8 h-8 object-cover">
                <span class="text-xl font-extrabold text-slate-900 tracking-tighter">PROSERVE</span>
            </div>
        </div>
        
        @auth
        <div x-data="{ openUser: false }" class="relative">
            <button @click="openUser = !openUser" class="flex items-center gap-3 group focus:outline-none transition-transform duration-300 hover:-translate-y-0.5">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] uppercase tracking-widest font-extrabold mt-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">
                        {{ auth()->user()->roles->first()->label ?? 'Usuario' }}
                    </p>
                </div>
                <div class="relative w-11 h-11 rounded-full overflow-hidden shadow-inner ring-2 ring-transparent group-hover:ring-emerald-300 transition-all duration-300">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-blue-500 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                </div>
            </button>

            <div x-show="openUser" @click.away="openUser = false"
                x-transition:enter="transition ease-out duration-100"
                class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-xl shadow-xl py-2 z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">Editar perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">Cerrar sesión</button>
                </form>
            </div>
        </div>
        @endauth
    </header>

    @auth
    <div class="flex">
        {{-- SIDEBAR RESPONSIVO --}}
        <aside x-show="sidebarOpen" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-slate-950 h-screen overflow-y-auto shadow-2xl">
            @include('layouts.partials.sidebar')
        </aside>

        <main class="flex-1 min-h-screen p-4 transition-all duration-300">
            @yield('content')
            @yield('scripts')
        </main>
    </div>
    @else
        <main class="min-h-screen">
            @yield('content')
            @yield('scripts')
        </main>
    @endauth

    {{-- Script de Notificaciones que tenías --}}
    @auth
        @php
            $user = auth()->user();
            $rol = $user->roles->pluck('name')->first();
            $hayNotificacion = false;
            $mensaje = '';

            if (in_array($rol, ['admin', 'supervisor'])) {
                $hayNotificacion = \App\Models\Solicitud::where('estado', 'pendiente')->exists();
                $mensaje = 'Hay solicitudes pendientes por aprobar.';
            } elseif ($rol === 'almacen') {
                $hayNotificacion = \App\Models\Solicitud::where('estado', 'aprobado')->exists();
                $mensaje = 'Hay solicitudes aprobadas pendientes de entrega.';
            }
        @endphp

        @if($hayNotificacion)
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            let alertaKey = 'alerta_solicitudes_{{ $rol }}';
            if (!sessionStorage.getItem(alertaKey)) {
                Swal.fire({ icon: 'info', title: 'Notificación', text: '{{ $mensaje }}', confirmButtonColor: '#2563eb' });
                sessionStorage.setItem(alertaKey, 'mostrada');
            }
        });
        </script>
        @endif
    @endauth
</body>
</html>