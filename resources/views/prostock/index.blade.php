@extends('layouts.principal')

@section('content')

@php
    $hora = now()->format('H');
    $saludo = $hora < 12 ? 'Buenos días' : ($hora < 18 ? 'Buenas tardes' : 'Buenas noches');

    // Estructura de Módulos vinculada a datos reales
    $modulos = [
        ['ruta' => 'categorias.index', 'label' => 'Categorías', 'desc' => "Gestiona las $totalCategorias familias configuradas.", 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 'color' => 'from-blue-500 to-indigo-600'],
        ['ruta' => 'productos.index', 'label' => 'Productos', 'desc' => "Catálogo maestro con $totalProductos artículos.", 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'from-emerald-400 to-teal-600'],
        ['ruta' => 'entradas.index', 'label' => 'Entradas', 'desc' => "Hoy se registraron $entradasHoy ingresos.", 'icon' => 'M19 14l-7 7m0 0l-7-7m7 7V3', 'color' => 'from-violet-500 to-purple-700'],
        ['ruta' => 'salidas.index', 'label' => 'Salidas', 'desc' => "Hoy se procesaron $salidasHoy despachos.", 'icon' => 'M5 10l7-7m0 0l7 7m-7-7v18', 'color' => 'from-orange-400 to-rose-600'],
    ];
@endphp

<style>
    
    /* Animación de entrada suave */
    @keyframes reveal {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-reveal { animation: reveal 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }

    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow { animation: spin-slow 8s linear infinite; }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 overflow-hidden relative">
    
    {{-- DECORACIÓN AMBIENTAL --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/5 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        {{-- HEADER --}}
        <header class="mb-16 animate-reveal">
            <span class="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-blue-400 text-xs font-bold uppercase tracking-[0.2em] mb-6 inline-block">
                Terminal Operativa — {{ now()->translatedFormat('d M, Y') }}
            </span>
            <h1 class="text-6xl font-black text-white tracking-tighter mb-4">
                {{ $saludo }}, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-100 to-slate-400">
                    {{ explode(' ', auth()->user()->name)[0] }}
                </span>
            </h1>
        </header>

        {{-- MÉTRICAS EN TIEMPO REAL (CRISTAL) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16 animate-reveal" style="animation-delay: 0.2s">
            
            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 p-8 rounded-[2rem] hover:bg-white/10 transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-tighter">Stock Total</p>
                    <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-white tabular-nums">{{ number_format($totalProductos) }}</h3>
                <p class="text-slate-500 text-xs mt-2">Productos en inventario</p>
            </div>

            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 p-8 rounded-[2rem] hover:bg-white/10 transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-tighter">Actividad Hoy</p>
                    <div class="p-2 bg-blue-500/20 rounded-lg text-blue-400 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-white tabular-nums">{{ $entradasHoy + $salidasHoy }}</h3>
                <p class="text-slate-500 text-xs mt-2">Transacciones del día</p>
            </div>

            {{-- MÉTRICA CALCULADA / STATUS --}}
            <div class="md:col-span-2 bg-gradient-to-r from-indigo-600/20 to-transparent backdrop-blur-2xl border border-white/10 p-8 rounded-[2rem] flex items-center justify-between">
                <div>
                    <p class="text-indigo-300 text-sm font-bold uppercase tracking-widest">Estatus Operativo</p>
                    <h3 class="text-3xl font-bold text-white mt-1">
                        {{ ($entradasHoy + $salidasHoy) > 0 ? 'Sistema Activo' : 'En Espera' }}
                    </h3>
                    <p class="text-slate-400 text-sm mt-1 font-light">Sincronización de activos en tiempo real completada.</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-20 h-20 rounded-full border-4 border-indigo-500/30 border-t-indigo-500 animate-spin-slow"></div>
                </div>
            </div>
        </div>

        {{-- GRID DE TARJETAS BLANCAS (ACCIONES) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 animate-reveal" style="animation-delay: 0.4s">
            @foreach($modulos as $mod)
            <a href="{{ route($mod['ruta']) }}" 
               class="group relative bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.5)] transition-all duration-500 hover:-translate-y-4 hover:rotate-1">
                
                <div class="w-16 h-16 mb-8 rounded-2xl bg-gradient-to-br {{ $mod['color'] }} flex items-center justify-center text-white shadow-xl shadow-{{ explode('-', $mod['color'])[1] }}-500/20 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $mod['icon'] }}" />
                    </svg>
                </div>

                <div class="relative">
                    <h3 class="text-2xl font-black text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors uppercase tracking-tighter italic">
                        {{ $mod['label'] }}
                    </h3>
                    <p class="text-slate-500 leading-relaxed text-sm font-medium">
                        {{ $mod['desc'] }}
                    </p>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-slate-900 transition-colors">Entrar</span>
                    <svg class="w-5 h-5 text-slate-300 group-hover:translate-x-2 transition-transform group-hover:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</div>
@endsection