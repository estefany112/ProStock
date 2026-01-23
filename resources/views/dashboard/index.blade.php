@extends('layouts.principal')

@section('content')

<h1 class="text-2xl font-semibold mb-6 text-white">Dashboard</h1>

<div style="background-color:#111827;"
     class="rounded-2xl p-8 max-w-6xl border border-slate-700">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-slate-800 rounded-xl p-6 border border-slate-700">
            <p class="text-sm text-gray-400 uppercase tracking-wide">Categorías</p>
            <p class="text-4xl font-bold text-white mt-2">{{ $totalCategorias }}</p>
        </div>

        <div class="bg-slate-800 rounded-xl p-6 border border-slate-700">
            <p class="text-sm text-gray-400 uppercase tracking-wide">Productos</p>
            <p class="text-4xl font-bold text-white mt-2">{{ $totalProductos }}</p>
        </div>

        <div class="bg-slate-800 rounded-xl p-6 border border-slate-700">
            <p class="text-sm text-gray-400 uppercase tracking-wide">Stock total</p>
            <p class="text-4xl font-bold text-white mt-2">{{ $stockTotal }}</p>
        </div>

        <div class="bg-slate-800 rounded-xl p-6 border-l-4 border-red-500">
            <p class="text-sm text-gray-400 uppercase tracking-wide">Stock bajo</p>
            <p class="text-4xl font-bold text-red-400 mt-2">{{ $stockBajo }}</p>
        </div>

    </div>
</div>

@endsection
