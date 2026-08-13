@extends('layouts.principal')

@section('content')

<style>
    /* Animación de entrada */
    @keyframes reveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-reveal { animation: reveal 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }

    /* Resplandor que "respira" */
    @keyframes glow {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.2); }
    }
    .animate-glow { animation: glow 4s ease-in-out infinite; }

    /* Línea de escaneo sutil */
    @keyframes scan {
        0%, 100% { opacity: 0.2; transform: translateY(-2px); }
        50% { opacity: 1; transform: translateY(2px); }
    }
    .animate-scan { animation: scan 3s ease-in-out infinite; }

    /* Efecto Hover en filas */
    .table-row-hover:hover {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(8px);
    }
</style>

<div class="min-h-screen py-12 px-6 relative overflow-hidden">

    <div class="max-w-7xl mx-auto relative z-10">
        
        {{-- HEADER --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Módulo de Auditoría y Control
                </span>
                <h1 class="text-4xl font-black text-white tracking-tighter flex items-center gap-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-indigo-500/40 blur-2xl rounded-full animate-glow"></div>
                        <div class="relative z-10 p-4 bg-slate-900 border border-indigo-500/30 rounded-2xl text-indigo-400 shadow-2xl shadow-indigo-500/20">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    Reportería de Productos
                    <span class="text-slate-700 font-light">—</span>
                    <span class="text-xl text-slate-400 font-medium tracking-normal mt-2">{{ $productos->total() ?? 0 }} registros</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('prostock.index') }}" 
                   class="bg-white/5 text-slate-300 px-6 py-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-all flex items-center gap-2 font-medium text-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('reportes.productos.excel', ['tipo' => $tipo]) }}"
                   class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-emerald-900/40 transition-all transform hover:-translate-y-1 flex items-center gap-2 font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exportar a Excel
                </a>
            </div>
        </header>

        {{-- BARRA DE FILTROS --}}
        <div class="mb-10 animate-reveal" style="animation-delay: 0.1s">
            <div class="relative bg-slate-900/50 backdrop-blur-2xl border border-white/10 p-5 rounded-[2.2rem] shadow-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <form method="GET" action="{{ route('reportes.productos') }}" class="flex items-center gap-4 w-full sm:w-auto">
                    <label for="tipo" class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Criterio de Filtrado:
                    </label>
                    <select name="tipo"
                            id="tipo"
                            onchange="this.form.submit()"
                            class="border border-white/10 bg-slate-950/60 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                        <option value="sin_precio" {{ $tipo == 'sin_precio' ? 'selected' : '' }} class="bg-slate-900">
                            Productos sin precio asignado
                        </option>
                        <option value="sin_imagen" {{ $tipo == 'sin_imagen' ? 'selected' : '' }} class="bg-slate-900">
                            Productos sin imagen registrada
                        </option>
                    </select>
                </form>

                <div class="flex items-center gap-2 text-xs font-semibold px-3.5 py-1.5 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Estado: <span class="text-white">Activo</span>
                </div>
            </div>
        </div>

        {{-- TABLA ESTILO CRISTAL --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl animate-reveal mb-12" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/10">
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Código</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Descripción del Producto</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Categoría</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Stock</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Precio Unitario</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Estado de Imagen</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse($productos as $producto)
                            <tr class="table-row-hover transition-all group">
                                <td class="px-6 py-6 font-mono font-semibold text-indigo-400 text-sm">
                                    {{ $producto->codigo }}
                                </td>
                                <td class="px-6 py-6 font-medium text-slate-200 group-hover:text-white transition-colors text-base">
                                    {{ $producto->descripcion }}
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-slate-400 font-medium bg-white/5 px-3 py-1 rounded-lg border border-white/5 text-xs">
                                        {{ $producto->categoria->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-right font-mono text-slate-300 font-bold">
                                    {{ number_format($producto->stock_actual) }}
                                </td>
                                <td class="px-6 py-6 text-right font-mono font-bold">
                                    @if($producto->precio_unitario > 0)
                                        <span class="text-slate-200">Q {{ number_format($producto->precio_unitario, 2) }}</span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                            Sin Precio
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 text-center">
                                    @if($producto->image)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <p class="text-slate-500 font-medium italic">No se encontraron registros que coincidan con los parámetros de la consulta actual.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($productos->hasPages())
                <div class="px-8 py-6 border-t border-white/10 bg-white/[0.01]">
                    {{ $productos->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        {{-- NAVEGACIÓN MODULAR --}}
        <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-8 animate-reveal" style="animation-delay: 0.4s">
            <div class="flex items-center gap-4">
                <div class="h-px w-12 bg-white/10"></div>
                <span class="text-slate-500 text-xs font-black uppercase tracking-[0.3em]">Continuar Flujo</span>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('salidas.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-white/5 rounded-3xl border border-white/10 text-slate-300 hover:bg-white/10 transition-all text-center">
                    <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Anterior</span>
                    <span class="font-bold tracking-tight italic">Salidas</span>
                </a>

                <a href="{{ route('prostock.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-slate-800 text-white rounded-3xl hover:bg-slate-700 transition-all text-center shadow-xl">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Finalizar</span>
                    <span class="font-black tracking-tight italic">Menú Inventario</span>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection