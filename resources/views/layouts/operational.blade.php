<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Control de Viajes'))</title>

    {{-- Favicon (mantiene el favicon habitual o puedes cambiarlo también) --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 selection:bg-emerald-500 selection:text-white antialiased flex flex-col justify-between">

    {{-- HEADER MODERNO CON EFECTO GLASS --}}
    <header class="sticky top-0 z-50 bg-slate-900/80 backdrop-blur-xl border-b border-slate-800/80 shadow-lg shadow-black/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                {{-- LOGOTIPO UBICADO AQUÍ --}}
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-md shadow-emerald-900/30 overflow-hidden border border-emerald-500/20">
                    @if(strtoupper(config('app.name')) === 'PROSTOCK')
                        <img src="{{ asset('assets/img/fondo.jpg') }}" alt="Logo ProStock" class="w-full h-full object-cover">
                    @else
                        <span class="text-white font-black text-lg">
                            {{ substr(config('app.name', 'ProStock'), 0, 1) }}
                        </span>
                    @endif
                </div>

                <div>
                    <div class="font-extrabold text-lg text-white tracking-tight flex items-center gap-2">
                        {{ config('app.name', 'ProStock') }}

                        @if(strtoupper(config('app.name')) === 'PROSTOCK')
                            <span class="text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full px-2 py-0.5 font-semibold">
                                Fleet
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-400 font-medium">
                        Control de Vehículos
                    </div>
                </div>
            </div>

            {{-- Estado del sistema --}}
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <span class="block text-xs font-semibold text-slate-300">Sistema Activo</span>
                    <span class="block text-[10px] text-emerald-400 flex items-center justify-end gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> En línea
                    </span>
                </div>
            </div>

        </div>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER SUTIL --}}
    <footer class="border-t border-slate-900 bg-slate-950/60 py-6 mt-12 text-center text-xs text-slate-400">
        <p>{{ config('app.name', 'ProStock') }} &copy; {{ date('Y') }} — Todos los derechos reservados.</p>
    </footer>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>
</html>