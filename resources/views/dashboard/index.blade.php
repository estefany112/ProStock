@extends('layouts.principal')

@section('content')

@php
    $hora = now()->format('H');
    $saludo = $hora < 12 ? 'Buenos días' : ($hora < 18 ? 'Buenas tardes' : 'Buenas noches');
@endphp

{{-- HEADER --}}
<div class="max-w-7xl mx-auto mb-6">
    <h1 class="text-2xl font-semibold text-white">
        {{ $saludo }}, {{ auth()->user()->name }}
    </h1>

    <p class="text-sm text-slate-400 mt-1 text-white">
        Plataforma empresarial para la gestión operativa de
        <span class="text-white font-medium">
            {{ config('app.name') }}
        </span>
    </p>
</div>

{{-- SEPARADOR --}}
<div class="h-px bg-slate-700 max-w-7xl mx-auto mb-6"></div>

{{-- CONTENEDOR DASHBOARD --}}
<div class="max-w-7xl mx-auto bg-slate-900/60 border border-slate-700
            rounded-2xl p-8">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- CATEGORÍAS --}}
        <div class="rounded-xl p-6 border border-slate-600 bg-slate-900
                    hover:border-blue-400 hover:bg-slate-900/80 transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 text-white">
                Categorías
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalCategorias }}
            </p>
        </div>

        {{-- PRODUCTOS --}}
        <div class="rounded-xl p-6 border border-slate-600 bg-slate-900
                    hover:border-emerald-400 hover:bg-slate-900/80 transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 text-white">
                Productos
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalProductos }}
            </p>
        </div>

        {{-- STOCK TOTAL --}}
        <div class="rounded-xl p-6 border border-slate-600 bg-slate-900
                    hover:border-indigo-400 hover:bg-slate-900/80 transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 text-white">
                Stock total
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $stockTotal }}
            </p>
        </div>

        {{-- STOCK BAJO --}}
        <div class="rounded-xl p-6 border border-red-500/60 bg-slate-900
                    hover:border-red-400 hover:bg-slate-900/80 transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 text-white">
                Stock bajo
            </p>
            <p class="text-4xl font-bold text-red-400 mt-3">
                {{ $stockBajo }}
            </p>
        </div>

        {{-- EMPLEADOS --}}
        <div class="rounded-xl p-6 border border-slate-600 bg-slate-900
                    hover:border-cyan-400 hover:bg-slate-900/80 transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 text-white">
                Empleados
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalEmpleados }}
            </p>
        </div>

        {{-- USUARIOS --}}
        <div class="rounded-xl p-6 border border-slate-600 bg-slate-900
                    hover:border-purple-400 hover:bg-slate-900/80 transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 text-white">
                Usuarios
            </p>
            <p class="text-4xl font-bold text-white mt-3">
                {{ $totalUsuarios }}
            </p>
        </div>

    </div>
</div>

@endsection
