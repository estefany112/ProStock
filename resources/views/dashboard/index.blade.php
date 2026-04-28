@extends('layouts.principal')

@section('content')

{{-- BIENVENIDA EMPRESARIAL --}}
<div class="max-w-7xl mx-auto mb-8">
    <div class="bg-gradient-to-r from-blue-900 to-slate-900 rounded-2xl p-8 border border-blue-800/50 shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white tracking-tight">
                Hola, {{ auth()->user()->name }}
            </h1>
            <p class="text-blue-200 mt-2 max-w-2xl">
                Bienvenido al panel de control de <strong>{{ config('app.name') }}</strong>. 
                Gestiona la eficiencia de tus servicios de mantenimiento y supervisa tus recursos en tiempo real.
            </p>
            <div class="mt-6 flex gap-4">
                <span class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-300 text-sm font-medium rounded-lg border border-blue-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Última actualización: {{ now()->format('H:i') }}
                </span>
            </div>
        </div>

        <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
            <svg class="w-64 h-64" viewBox="0 0 200 200">
                <path fill="currentColor" d="M44.7,-76.4C58.9,-69.2,71.9,-59.1,81.3,-46.8C90.7,-34.5,96.5,-20.1,97.5,-5.5C98.5,9.1,94.7,23.9,87.3,36.5C79.9,49.1,68.9,59.5,56.5,67.6C44.1,75.7,30.3,81.5,16.1,83.1C1.9,84.7,-12.7,82.1,-26.1,76.5C-39.5,70.9,-51.7,62.3,-61.7,51.8C-71.7,41.3,-79.5,28.9,-83.4,15.6C-87.3,2.3,-87.3,-11.9,-82.2,-24.5C-77.1,-37.1,-66.9,-48.1,-55.4,-57.1C-43.9,-66.1,-31.1,-73.1,-17.5,-78.7C-3.9,-84.3,10.5,-88.5,23.7,-86.7C36.9,-84.9,44.7,-76.4,44.7,-76.4Z"/>
            </svg>
        </div>
    </div>
</div>

{{-- MÉTRICAS OPERATIVAS --}}
<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    @php
        $stats = [
            [
                'title' => 'Stock de Insumos',
                'value' => $stockTotal,
                'desc' => 'Unidades en bodega',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'
            ],
            [
                'title' => 'Alertas de Stock',
                'value' => $stockBajo,
                'desc' => 'Repuestos críticos',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
            ],
            [
                'title' => 'Personal Activo',
                'value' => $totalEmpleados,
                'desc' => 'Técnicos en campo',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>'
            ],
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-2xl hover:border-blue-500/50 transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">
                    {{ $stat['title'] }}
                </p>
                <div class="text-blue-500 group-hover:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $stat['icon'] !!}
                    </svg>
                </div>
            </div>

            <p class="text-3xl font-bold text-white mt-3">{{ $stat['value'] }}</p>
            <p class="text-xs text-slate-500 mt-1">{{ $stat['desc'] }}</p>
        </div>
    @endforeach
</div>

{{-- PANEL DE ACCIONES RÁPIDAS --}}
<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-slate-900 border border-slate-700 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
            <span class="w-1.5 h-6 bg-blue-500 rounded-full mr-3"></span>
            Gestión de Inventario
        </h2>

        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-slate-800 rounded-xl border border-slate-700">
                <p class="text-sm text-slate-400">Total Productos</p>
                <p class="text-2xl font-bold text-white mt-1">{{ $totalProductos }}</p>
            </div>

            <div class="p-4 bg-slate-800 rounded-xl border border-slate-700">
                <p class="text-sm text-slate-400">Categorías</p>
                <p class="text-2xl font-bold text-white mt-1">{{ $totalCategorias }}</p>
            </div>
        </div>
    </div>

    {{-- SOLO ADMINISTRADORES --}}
   @if(auth()->user()->hasAnyRole(['admin', 'auditor']))
    <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4">
            Acceso Administrativo
        </h2>

        <div class="space-y-3">
            <a href="{{ route('planillas.index') }}"
            class="flex items-center justify-between p-3 bg-slate-800 hover:bg-blue-600 hover:text-white rounded-xl transition text-slate-300">
                <span>Gestionar Planillas</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.users') }}"
            class="flex items-center justify-between p-3 bg-slate-800 hover:bg-blue-600 hover:text-white rounded-xl transition text-slate-300">
                <span>Configuración de Roles</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    @endif

</div>

@endsection