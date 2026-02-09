@extends('layouts.principal')

@section('content')

@php
    $hora = now()->format('H');
    $saludo = $hora < 12 ? 'Buenos días' : ($hora < 18 ? 'Buenas tardes' : 'Buenas noches');
@endphp

{{-- HEADER --}}
<div class="max-w-7xl mx-auto mb-8">
    <h1 class="text-2xl font-semibold text-white">
        {{ $saludo }}, {{ auth()->user()->name }}
    </h1>

    <p class="text-sm text-slate-400 mt-1">
        Plataforma empresarial para la gestión operativa de
        <span class="text-white font-medium">
            {{ config('app.name') }}
        </span>
    </p>
</div>

{{-- CONTENEDOR DASHBOARD --}}
<div class="bg-[#111827] rounded-2xl p-8 max-w-7xl mx-auto border border-slate-700 mt-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- CATEGORÍAS --}}
        <div class="bg-gradient-to-br from-blue-600/20 to-blue-400/5
                    rounded-xl p-6 border border-blue-500/30
                    hover:scale-[1.02] hover:shadow-lg transition">
            <p class="text-sm text-blue-300 uppercase tracking-wide"
               title="Total de categorías registradas">
                Categorías
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalCategorias }}
            </p>
        </div>

        {{-- PRODUCTOS --}}
        <div class="bg-gradient-to-br from-emerald-600/20 to-emerald-400/5
                    rounded-xl p-6 border border-emerald-500/30
                    hover:scale-[1.02] hover:shadow-lg transition">
            <p class="text-sm text-emerald-300 uppercase tracking-wide"
               title="Productos activos en el sistema">
                Productos
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalProductos }}
            </p>
        </div>

        {{-- STOCK TOTAL --}}
        <div class="bg-gradient-to-br from-indigo-600/20 to-indigo-400/5
                    rounded-xl p-6 border border-indigo-500/30
                    hover:scale-[1.02] hover:shadow-lg transition">
            <p class="text-sm text-indigo-300 uppercase tracking-wide"
               title="Cantidad total de unidades en inventario">
                Stock total
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $stockTotal }}
            </p>
        </div>

        {{-- STOCK BAJO --}}
        <div class="bg-gradient-to-br from-red-600/30 to-red-400/10
                    rounded-xl p-6 border border-red-500/40
                    hover:scale-[1.02] hover:shadow-lg transition">
            <p class="text-sm text-red-300 uppercase tracking-wide"
               title="Productos que requieren reposición">
                Stock bajo
            </p>
            <p class="text-4xl font-bold text-red-400 mt-3">
                {{ $stockBajo }}
            </p>
        </div>

        {{-- EMPLEADOS --}}
        <div class="bg-gradient-to-br from-cyan-600/20 to-cyan-400/5
                    rounded-xl p-6 border border-cyan-500/30
                    hover:scale-[1.02] hover:shadow-lg transition">
            <p class="text-sm text-cyan-300 uppercase tracking-wide"
               title="Empleados registrados en el sistema">
                Empleados
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalEmpleados }}
            </p>
        </div>

        {{-- USUARIOS --}}
        <div class="bg-gradient-to-br from-purple-600/20 to-purple-400/5
                    rounded-xl p-6 border border-purple-500/30
                    hover:scale-[1.02] hover:shadow-lg transition">
            <p class="text-sm text-purple-300 uppercase tracking-wide"
               title="Usuarios con acceso al sistema">
                Usuarios
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalUsuarios }}
            </p>
        </div>

    </div>
</div>

@endsection
