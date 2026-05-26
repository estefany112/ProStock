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

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    {{-- EFECTO FONDO --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        {{-- HEADER --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Gestión Comercial
                </span>
                <h1 class="text-5xl font-black text-white tracking-tighter flex items-center gap-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-cyan-500/40 blur-2xl rounded-full animate-glow"></div>
                        <div class="relative z-10 p-4 bg-slate-900 border border-cyan-500/30 rounded-2xl text-cyan-400 shadow-2xl shadow-cyan-500/20">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                <path d="M4 15h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="animate-scan opacity-50"></path>
                            </svg>
                        </div>
                    </div>
                    Clientes
                    <span class="text-slate-700 font-light">—</span>
                    <span class="text-xl text-slate-400 font-medium tracking-normal mt-2">{{ $clientes->count() }} registros</span>
                </h1>
            </div>

            {{-- BOTÓN NUEVO --}}
            <div>
                <a href="{{ route('clientes.create') }}"
                   class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-cyan-900/30 transition-all transform hover:-translate-y-1 flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Cliente
                </a>
            </div>
        </header>

        {{-- ALERTA --}}
        @if(session('success'))
            <div class="mb-8 p-5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 animate-reveal">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUSCADOR REDISEÑADO --}}
        <div class="mb-10 animate-reveal" style="animation-delay: 0.1s">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500/20 to-teal-500/20 rounded-[2.5rem] blur opacity-25 group-focus-within:opacity-100 transition duration-1000"></div>
                <div class="relative bg-slate-900/50 backdrop-blur-2xl border border-white/10 p-3 rounded-[2.2rem] shadow-2xl flex items-center gap-4 pl-6">
                    <x-search-bar action="{{ route('clientes.index') }}" placeholder="Buscar por nombre, empresa, NIT o correo..." />
                </div>
            </div>
        </div>

        {{-- TABLA ESTILO CRISTAL --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl animate-reveal" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1200px]">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/10">
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Tipo</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Nombre / Empresa</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">NIT</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Teléfono</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Correo</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Dirección</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse ($clientes as $cliente)
                            <tr class="table-row-hover transition-all group">
                                {{-- TIPO --}}
                                <td class="px-6 py-6">
                                    <span class="px-3 py-1 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-bold whitespace-nowrap">
                                        {{ $cliente->tipo_cliente }}
                                    </span>
                                </td>

                                {{-- NOMBRE / EMPRESA --}}
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-white font-bold text-lg tracking-tight group-hover:text-cyan-400 transition-colors">
                                            {{ $cliente->nombre }}
                                        </span>
                                        <span class="text-slate-400 font-mono text-xs mt-0.5">
                                            {{ $cliente->empresa ?? '—' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- NIT --}}
                                <td class="px-6 py-6 text-slate-300 font-mono text-sm">
                                    {{ $cliente->nit ?? '—' }}
                                </td>

                                {{-- TELÉFONO --}}
                                <td class="px-6 py-6 text-slate-300 text-sm">
                                    {{ $cliente->telefono ?? '—' }}
                                </td>

                                {{-- CORREO --}}
                                <td class="px-6 py-6 text-slate-300 text-sm">
                                    {{ $cliente->correo ?? '—' }}
                                </td>

                                {{-- DIRECCIÓN --}}
                                <td class="px-6 py-6 text-slate-400 text-sm max-w-xs truncate">
                                    {{ $cliente->direccion ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <p class="text-slate-500 font-medium italic">No hay clientes registrados.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection