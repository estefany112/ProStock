@extends('layouts.principal')

@section('content')

{{-- pt-20 para asegurar la gran distancia solicitada con la barra de navegación --}}
<div class="max-w-3xl mx-auto pt-20 pb-12 px-4">
    
    {{-- TARJETA DE FORMULARIO --}}
    <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">
        
        {{-- HEADER DEL FORMULARIO --}}
        <div class="bg-slate-900/40 p-8 border-b border-slate-700">
            <div class="flex items-center gap-4">
                <span class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                <div>
                    <h1 class="text-2xl font-bold text-white">Nueva Categoría</h1>
                    <p class="text-slate-400 text-sm mt-1">Registra una nueva clasificación para tus productos en PROSERVE.</p>
                </div>
            </div>
        </div>

        {{-- CUERPO DEL FORMULARIO --}}
        <form action="{{ route('categorias.store') }}" method="POST" class="p-8">
            @csrf

            <div class="mb-8">
                <label class="block text-slate-300 font-semibold mb-3 ml-1">
                    Nombre de la categoría
                </label>
                <div class="relative group">
                    <input type="text"
                           name="nombre"
                           placeholder="Ej. Repuestos, Herramientas..."
                           class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white placeholder-slate-500
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                                  transition-all duration-300"
                           required
                           autofocus>
                </div>
                @error('nombre')
                    <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ACCIONES INTERNAS --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-700/50">
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-3 rounded-xl 
                               font-bold shadow-lg shadow-emerald-900/30 transition-all 
                               hover:-translate-y-0.5 active:scale-95">
                    Guardar Categoría
                </button>
            </div>
        </form>
    </div>

    {{-- BOTÓN REGRESAR (Acomodado abajo con estilo azul de "Ir a Productos") --}}
    <div class="mt-8 flex justify-start">
        <a href="{{ route('categorias.index') }}"
           class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-900/20 transition flex items-center gap-3 font-bold">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Regresar al listado
        </a>
    </div>
</div>

@endsection