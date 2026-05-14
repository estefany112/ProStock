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

    .bg-mesh {
        background-color: #0f172a;
        background-image: 
            radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
    }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    {{-- Decoración de fondo --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        {{-- HEADER --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Registro de Suministros
                </span>
                <h1 class="text-5xl font-black text-white tracking-tighter flex items-center gap-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-emerald-500/40 blur-2xl rounded-full animate-glow"></div>
                        <div class="relative z-10 p-4 bg-slate-900 border border-emerald-500/30 rounded-2xl text-emerald-400 shadow-2xl shadow-emerald-500/20">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                                <path d="M7 13h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="animate-scan opacity-50"></path>
                            </svg>
                        </div>
                    </div>
                    Entradas
                    <span class="text-slate-700 font-light">—</span>
                    <span class="text-xl text-slate-400 font-medium tracking-normal mt-2">{{ $entradas->total() }} registros</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('prostock.index') }}"
                   class="group bg-white/5 text-slate-300 px-6 py-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('entradas.create') }}"
                   class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-emerald-900/40 transition-all transform hover:-translate-y-1 flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Entrada
                </a>
            </div>
        </header>

        {{-- BUSCADOR REDISEÑADO --}}
        <div class="mb-10 animate-reveal" style="animation-delay: 0.1s">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500/20 to-teal-500/20 rounded-[2.5rem] blur opacity-25 group-focus-within:opacity-100 transition duration-1000"></div>
                <div class="relative bg-slate-900/50 backdrop-blur-2xl border border-white/10 p-3 rounded-[2.2rem] shadow-2xl flex items-center gap-4 pl-6">
                    <x-search-bar action="{{ route('entradas.index') }}" placeholder="Buscar por producto, motivo o categoría..." />
                </div>
            </div>
        </div>

        {{-- TABLA ESTILO CRISTAL --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl animate-reveal" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/10">
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Item</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Producto / Código</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Categoría</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Cantidad</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Motivo</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Fecha Registro</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse ($entradas as $entrada)
                            <tr class="table-row-hover transition-all group">
                                <td class="px-6 py-6 text-center">
                                    <span class="text-slate-500 font-mono text-xs">#{{ $entradas->total() - (($entradas->currentPage() - 1) * $entradas->perPage()) - $loop->index }}</span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-emerald-400 font-mono font-bold text-xs tracking-wider mb-1">{{ $entrada->producto->codigo ?? '—' }}</span>
                                        <span class="text-slate-200 font-bold text-lg tracking-tight group-hover:text-white transition-colors">
                                            {{ $entrada->producto->descripcion ?? '—' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-slate-400 font-medium bg-white/5 px-3 py-1 rounded-lg border border-white/5">
                                        {{ $entrada->producto->categoria->nombre ?? 'Sin categoría' }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="text-white font-black text-xl tracking-tighter">
                                        +{{ $entrada->cantidad }}
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-slate-400 italic text-sm">{{ $entrada->motivo }}</span>
                                </td>
                                <td class="px-6 py-6 text-right font-mono text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <p class="text-slate-500 font-medium italic">No se encontraron entradas registradas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($entradas->hasPages())
                <div class="px-8 py-6 border-t border-white/10 bg-white/[0.01]">
                    {{ $entradas->appends(request()->query())->links() }}
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
                <a href="{{ route('productos.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-white/5 rounded-3xl border border-white/10 text-slate-300 hover:bg-white/10 transition-all text-center">
                    <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Anterior</span>
                    <span class="font-bold tracking-tight italic">Productos</span>
                </a>

                <a href="{{ route('salidas.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-emerald-600 text-white rounded-3xl hover:bg-emerald-500 transition-all text-center shadow-xl shadow-emerald-900/20">
                    <span class="block text-[10px] text-emerald-300 font-bold uppercase tracking-widest mb-1">Siguiente</span>
                    <span class="font-black tracking-tight italic">Gestión de Salidas</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection