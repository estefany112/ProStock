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
        <div x-data="{ openUser: false }" class="relative">

            <div class="flex items-center gap-4">

                <div class="text-right leading-tight hidden sm:block">
                    <p class="text-sm font-medium">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->roles->first()->label ?? 'Usuario' }}
                    </p>
                </div>

                <!-- Avatar -->
                <button @click="openUser = !openUser"
                    class="w-9 h-9 rounded-full bg-slate-800
                        flex items-center justify-center
                        text-sm font-bold text-white focus:outline-none">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </button>

            </div>

            <!-- Dropdown -->
            <div x-show="openUser"
                @click.away="openUser = false"
                x-transition
                class="absolute right-0 mt-3 w-48 bg-white
                        border border-slate-200 rounded-lg shadow-lg
                        py-2 z-50">

                <!-- Editar Perfil -->
                <a href="{{ route('profile.edit') }}"
                class="block px-4 py-2 text-sm text-slate-700
                        hover:bg-slate-100 transition">
                    Editar perfil
                </a>

                <!-- Divider -->
                <div class="border-t border-slate-200 my-1"></div>

                <!-- Cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm
                            text-red-600 hover:bg-red-50 transition">
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>
        @endauth

    </header>

    @auth
    {{-- SISTEMA INTERNO --}}
    <div class="flex">
        @include('layouts.partials.sidebar')

        @else
        <main class="min-h-screen">
            @yield('content')
        </main>
    @endauth
    </div>

    @auth
        @php
            $user = auth()->user();
            $rol = $user->roles->pluck('name')->first();

            $hayNotificacion = false;
            $mensaje = '';

            if ($rol === 'admin' || $rol === 'supervisor') {
                $hayNotificacion = \App\Models\Solicitud::where('estado', 'pendiente')->exists();
                $mensaje = 'Hay solicitudes pendientes por aprobar.';
            }

            if ($rol === 'almacen') {
                $hayNotificacion = \App\Models\Solicitud::where('estado', 'aprobado')->exists();
                $mensaje = 'Hay solicitudes aprobadas pendientes de entrega.';
            }
        @endphp

        @if($hayNotificacion)
        <script>
        document.addEventListener('DOMContentLoaded', function () {

            // clave única por tipo de rol
            let alertaKey = 'alerta_solicitudes_{{ $rol }}';

            if (!sessionStorage.getItem(alertaKey)) {

                Swal.fire({
                    icon: 'info',
                    title: 'Notificación',
                    text: '{{ $mensaje }}',
                    confirmButtonColor: '#2563eb'
                });

                sessionStorage.setItem(alertaKey, 'mostrada');
            }

        });
        </script>
        @endif
    @endauth
</body>
</html>
