@extends('layouts.principal')

@section('content')

<h1 class="text-2xl font-semibold mb-2 text-white">
    Bienvenido, {{ auth()->user()->name }}
</h1>

<p class="mb-6 text-gray-400">
    Sistema empresarial de control de inventario para PROSERVE
</p>

<div class="max-w-6xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <a href="{{ route('categorias.index') }}"
       class="bg-slate-800 hover:bg-slate-700 transition rounded-xl p-6 border border-slate-700">
        <p class="text-lg font-semibold text-white">📁 Categorías</p>
        <p class="text-sm text-gray-400 mt-1">Gestionar tipos de productos</p>
    </a>

    <a href="{{ route('productos.index') }}"
       class="bg-slate-800 hover:bg-slate-700 transition rounded-xl p-6 border border-slate-700">
        <p class="text-lg font-semibold text-white">📦 Productos</p>
        <p class="text-sm text-gray-400 mt-1">Inventario general</p>
    </a>

    <a href="{{ route('entradas.index') }}"
       class="bg-slate-800 hover:bg-slate-700 transition rounded-xl p-6 border border-slate-700">
        <p class="text-lg font-semibold text-white">⬇️ Entradas</p>
        <p class="text-sm text-gray-400 mt-1">Ingreso de productos</p>
    </a>

    <a href="{{ route('salidas.index') }}"
       class="bg-slate-800 hover:bg-slate-700 transition rounded-xl p-6 border border-slate-700">
        <p class="text-lg font-semibold text-white">⬆️ Salidas</p>
        <p class="text-sm text-gray-400 mt-1">Despacho de productos</p>
    </a>

</div>

@endsection
