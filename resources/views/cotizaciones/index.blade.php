@extends('layouts.principal')

@section('content')

<style>
    /* Animación de entrada fluida */
    @keyframes reveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-reveal { 
        animation: reveal 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; 
    }

    /* Resplandor neón de fondo lento */
    @keyframes glow {
        0%, 100% { opacity: 0.15; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(1.1); }
    }
    .animate-glow { 
        animation: glow 8s ease-in-out infinite; 
    }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    
    {{-- LUZ AMBIENTAL DE FONDO --}}
    <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-fuchsia-500/5 blur-[150px] rounded-full animate-glow"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        {{-- MENSAJES DE ALERTA DE LARAVEL (Flash Session) --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium flex items-center gap-3 animate-reveal">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- HEADER DEL ÍNDICE --}}
        <header class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Módulo de Ventas
                </span>

                <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tighter flex items-end gap-4">
                    <div class="relative flex-shrink-0">
                        <div class="absolute inset-0 bg-fuchsia-500/30 blur-2xl rounded-full animate-glow"></div>
                        <div class="relative z-10 p-4 bg-slate-900 border border-fuchsia-500/30 rounded-2xl text-fuchsia-400 shadow-xl shadow-fuchsia-500/10">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </div>
                    </div>

                    <span class="flex items-end gap-2 flex-wrap">
                        Cotizaciones
                        <span class="text-slate-700 font-light leading-none">—</span>
                        <span class="text-xl text-slate-400 font-medium tracking-normal pb-1">
                            {{ $cotizaciones->total() }} registros
                        </span>
                    </span>
                </h1>
            </div>

            {{-- BOTÓN CREAR NUEVA COTIZACIÓN --}}
            <div class="w-full lg:w-auto flex flex-row items-center justify-end self-end">
                <a href="{{ route('cotizaciones.create') }}"
                   class="w-full sm:w-auto bg-gradient-to-r from-fuchsia-600 to-indigo-600 hover:from-fuchsia-500 hover:to-indigo-500 text-white px-6 py-3.5 rounded-2xl shadow-lg shadow-fuchsia-950/40 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 font-bold whitespace-nowrap">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Cotización
                </a>
            </div>
        </header>

        {{-- BARRA DE FILTROS Y BÚSQUEDA RÁPIDA --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-4 mb-8 animate-reveal" style="animation-delay: 0.1s">
            <form action="{{ route('cotizaciones.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                {{-- Búsqueda por Folio o Cliente --}}
                <div class="relative w-full sm:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por folio o cliente..." 
                           class="w-full bg-slate-950/60 border border-white/5 p-3 pl-10 rounded-xl text-white text-sm outline-none focus:border-fuchsia-500 transition-all">
                    <svg class="absolute left-3 top-3.5 w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                {{-- Filtro de Estado Directo --}}
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <select name="estado" onchange="this.form.submit()" class="w-full sm:w-44 bg-slate-950/60 border border-white/5 p-3 rounded-xl text-slate-300 text-sm outline-none focus:border-fuchsia-500 transition-all">
                        <option value="">Todos los estados</option>
                        <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borradores</option>
                        <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptadas</option>
                        <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazadas</option>
                        <option value="procesada" {{ request('estado') == 'procesada' ? 'selected' : '' }}>Procesadas</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- TABLA CENTRAL CRISTALÍZADA --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] shadow-2xl overflow-hidden animate-reveal" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="p-5">Folio</th>
                            <th class="p-5">Cliente</th>
                            <th class="p-5 text-center">Fecha Emisión</th>
                            <th class="p-5 text-right">Total Monto</th>
                            <th class="p-5 text-center">Estado</th>
                            <th class="p-5 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300">
                        @forelse($cotizaciones as $cotizacion)
                            <tr class="hover:bg-white/[0.01] transition-colors group">
                                
                                {{-- FOLIO --}}
                                <td class="p-5 font-mono text-fuchsia-400 font-bold text-sm tracking-wide">
                                    {{ $cotizacion->folio }}
                                </td>

                                {{-- CLIENTE RELACIONADO --}}
                                <td class="p-5">
                                    <div class="flex flex-col">
                                        <span class="text-white font-bold text-sm">{{ $cotizacion->cliente->empresa }}</span>
                                        <span class="text-slate-500 text-xs font-mono">{{ $cotizacion->cliente->nit ?? 'C/F' }}</span>
                                    </div>
                                </td>

                                {{-- FECHA EMISIÓN --}}
                                <td class="p-5 text-center font-mono text-sm text-slate-400">
                                    {{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') }}
                                </td>

                                {{-- TOTAL (Moneda formateada) --}}
                                <td class="p-5 text-right font-mono font-bold text-white text-base">
                                    Q{{ number_format($cotizacion->total, 2) }}
                                </td>

                                {{-- ESTADO (Badge semántico dinámico basado en tu ENUM) --}}
                                <td class="p-5 text-center">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider inline-block
                                        @if($cotizacion->estado == 'congelada') bg-emerald-500/10 border border-emerald-500/20 text-emerald-400
                                        @elseif($cotizacion->estado == 'borrador') bg-amber-500/10 border border-amber-500/20 text-amber-400
                                        @elseif($cotizacion->estado == 'anulada') bg-cyan-500/10 border border-cyan-500/20 text-cyan-400
                                        @else bg-rose-500/10 border border-rose-500/20 text-rose-400 @endif">
                                        {{ $cotizacion->estado }}
                                    </span>
                                </td>

                                {{-- ACCIONES DE FILA SIMÉTRICAS --}}
                                <td class="p-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        
                                        {{-- BOTÓN: SHOW --}}
                                        <a href="{{ route('cotizaciones.show', $cotizacion) }}" 
                                           class="p-2 bg-white/5 border border-white/5 rounded-xl hover:bg-fuchsia-500/20 hover:border-fuchsia-500/30 text-slate-400 hover:text-fuchsia-400 transition-all"
                                           title="Visualizar Comprobante">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        @if(!$cotizacion->estaCongelada())
                                        {{-- BOTÓN: EDIT --}}
                                        <a href="{{ route('cotizaciones.edit', $cotizacion) }}" 
                                           class="p-2 bg-white/5 border border-white/5 rounded-xl hover:bg-amber-500/20 hover:border-amber-500/30 text-slate-400 hover:text-amber-400 transition-all"
                                           title="Modificar Cotización">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @endif

                                        {{-- BOTÓN: DESTROY (Con confirmación preventiva nativa) --}}
                                        <form action="{{ route('cotizaciones.destroy', $cotizacion) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar la cotización {{ $cotizacion->folio }} permanentemente de la base de datos?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-white/5 border border-white/5 rounded-xl hover:bg-rose-500/20 hover:border-rose-500/30 text-slate-400 hover:text-rose-400 transition-all"
                                                    title="Eliminar Registro">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22m-5-3H8m1 0V2h6v2"/></svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-500 italic text-sm">
                                    No se encontraron cotizaciones registradas en este momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN CON ESTILO RESPONSIVO ADAPTADO --}}
            @if($cotizaciones->hasPages())
                <div class="bg-white/[0.01] border-t border-white/5 px-6 py-4">
                    {{ $cotizaciones->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

    </div>
</div>

@endsection