@extends('layouts.principal')

@section('content')

@php
    $hora = now()->format('H');
    $saludo = $hora < 12 ? 'Buenos días' : ($hora < 18 ? 'Buenas tardes' : 'Buenas noches');
@endphp

<div class="h-8"></div>

{{-- HEADER CON IMPACTO VISUAL --}}
<div class="max-w-7xl mx-auto mb-12">
    <h1 class="text-4xl font-extrabold text-white tracking-tighter">
        {{ $saludo }}, <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-cyan-400">{{ auth()->user()->name }}</span>
    </h1>
    <p class="text-slate-400 mt-3 text-lg">
        Centro de control operativo: <span class="text-slate-200 font-medium">{{ config('app.name') }}</span>
    </p>
</div>

{{-- GRID DE ACCIONES: ESTILO "GLOW" --}}
<div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    @php
        $modulos = [
            ['ruta' => 'categorias.index', 'label' => 'Categorías', 'desc' => 'Organización de equipos', 'icon' => 'tag', 'color' => 'blue'],
            ['ruta' => 'productos.index', 'label' => 'Productos', 'desc' => 'Inventario detallado', 'icon' => 'cube', 'color' => 'emerald'],
            ['ruta' => 'entradas.index', 'label' => 'Entradas', 'desc' => 'Ingreso de insumos', 'icon' => 'arrow-down-tray', 'color' => 'indigo'],
            ['ruta' => 'salidas.index', 'label' => 'Salidas', 'desc' => 'Despacho y servicios', 'icon' => 'arrow-up-tray', 'color' => 'amber'],
        ];
    @endphp

    @foreach($modulos as $mod)
    <a href="{{ route($mod['ruta']) }}" 
       class="group relative bg-slate-900 border border-slate-700/50 p-6 rounded-3xl transition-all duration-500 hover:border-{{$mod['color']}}-500/30 hover:scale-[1.02] overflow-hidden">
        
        {{-- Efecto de luz difusa detrás de la tarjeta --}}
        <div class="absolute inset-0 bg-gradient-to-br from-{{$mod['color']}}-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10 flex flex-col h-full">
            {{-- Icono con sombra de color --}}
            <div class="mb-6 w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center text-{{$mod['color']}}-400 shadow-inner group-hover:shadow-{{$mod['color']}}-500/20 group-hover:bg-{{$mod['color']}}-900/20 transition-all">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="{{ $mod['icon'] == 'tag' ? 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z' : 
                               ($mod['icon'] == 'cube' ? 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' : 
                               ($mod['icon'] == 'arrow-down-tray' ? 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4' : 
                               'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12')) }}"></path>
                </svg>
            </div>
            
            <h3 class="text-white font-bold text-xl group-hover:text-{{$mod['color']}}-300 transition-colors">
                {{ $mod['label'] }}
            </h3>
            <p class="text-slate-400 text-sm mt-2 flex-grow font-light leading-relaxed">
                {{ $mod['desc'] }}
            </p>
            
            <div class="mt-6 flex items-center text-xs font-bold text-slate-500 uppercase tracking-widest group-hover:text-{{$mod['color']}}-400 transition-colors">
                Ingresar al módulo <span class="ml-2 transition-transform group-hover:translate-x-2">→</span>
            </div>
        </div>
    </a>
    @endforeach

</div>

@endsection