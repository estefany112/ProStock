@extends('layouts.principal')

@section('content')

<style>
    /* Animación */
    @keyframes reveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-reveal {
        animation: reveal 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    /* Glow */
    @keyframes glow {
        0%,100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.15); }
    }

    .animate-glow {
        animation: glow 4s ease-in-out infinite;
    }

    /* Scan */
    @keyframes scan {
        0%,100% { opacity: .2; transform: translateY(-2px);}
        50% { opacity: 1; transform: translateY(2px);}
    }

    .animate-scan {
        animation: scan 3s ease-in-out infinite;
    }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">

    {{-- EFECTO --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-6xl mx-auto relative z-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-reveal">

            <div>

                <span class="px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Gestión Comercial
                </span>

                <h1 class="text-5xl font-black text-white tracking-tighter flex items-center gap-6">

                    <div class="relative">

                        <div class="absolute inset-0 bg-cyan-500/40 blur-2xl rounded-full animate-glow"></div>

                        <div class="relative z-10 p-4 bg-slate-900 border border-cyan-500/30 rounded-2xl text-cyan-400 shadow-2xl shadow-cyan-500/20">

                            <svg class="w-10 h-10"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                <path d="M4 15h16"
                                      stroke="currentColor"
                                      stroke-width="2"
                                      stroke-linecap="round"
                                      class="animate-scan opacity-50"></path>

                            </svg>

                        </div>

                    </div>

                    Cliente

                </h1>

                <p class="text-slate-400 mt-4">
                    Información general y comercial del cliente.
                </p>

            </div>

            {{-- BOTONES --}}
            <div class="flex items-center gap-3">

                {{-- REGRESAR --}}
                <a href="{{ route('clientes.index') }}"
                   class="group bg-white/5 text-slate-300 px-6 py-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-all flex items-center gap-2">

                    <svg class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 19l-7-7 7-7"/>

                    </svg>

                    Regresar

                </a>

                {{-- EDITAR --}}
                <a href="{{ route('clientes.edit', $cliente) }}"
                   class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-cyan-900/30 transition-all transform hover:-translate-y-1 flex items-center gap-2 font-bold">

                    <svg class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                              a2 2 0 112.828 2.828L11.828 15H9v-2.828
                              l8.586-8.586z"/>

                    </svg>

                    Editar Cliente

                </a>

            </div>

        </div>

        {{-- CARD PRINCIPAL --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl animate-reveal">

            {{-- TOP --}}
            <div class="p-10 border-b border-white/10">

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                    <div>

                        <span class="px-4 py-2 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-black uppercase tracking-[0.2em]">

                            {{ $cliente->tipo_cliente }}

                        </span>

                        <h2 class="text-4xl font-black text-white mt-6 tracking-tight">

                            {{ $cliente->nombre }}

                        </h2>

                        <p class="text-slate-400 mt-2 text-lg">

                            {{ $cliente->empresa ?? 'Sin empresa registrada' }}

                        </p>

                    </div>

                    {{-- ID --}}
                    <div class="bg-slate-900/70 border border-white/10 rounded-3xl px-8 py-6">

                        <span class="block text-slate-500 text-xs uppercase tracking-[0.2em] font-bold mb-2">
                            ID Cliente
                        </span>

                        <span class="text-white text-3xl font-black">
                            #{{ $cliente->id }}
                        </span>

                    </div>

                </div>

            </div>

            {{-- DATOS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-10">

                {{-- NIT --}}
                <div class="bg-slate-900/40 border border-white/5 rounded-3xl p-6">

                    <span class="text-slate-500 text-xs uppercase tracking-[0.2em] font-bold">
                        NIT
                    </span>

                    <p class="text-white text-xl font-bold mt-3">
                        {{ $cliente->nit ?? 'No registrado' }}
                    </p>

                </div>

                {{-- TELEFONO --}}
                <div class="bg-slate-900/40 border border-white/5 rounded-3xl p-6">

                    <span class="text-slate-500 text-xs uppercase tracking-[0.2em] font-bold">
                        Teléfono
                    </span>

                    <p class="text-white text-xl font-bold mt-3">
                        {{ $cliente->telefono ?? 'No registrado' }}
                    </p>

                </div>

                {{-- CORREO --}}
                <div class="bg-slate-900/40 border border-white/5 rounded-3xl p-6">

                    <span class="text-slate-500 text-xs uppercase tracking-[0.2em] font-bold">
                        Correo Electrónico
                    </span>

                    <p class="text-white text-lg font-semibold mt-3 break-all">
                        {{ $cliente->correo ?? 'No registrado' }}
                    </p>

                </div>

                {{-- FECHA --}}
                <div class="bg-slate-900/40 border border-white/5 rounded-3xl p-6">

                    <span class="text-slate-500 text-xs uppercase tracking-[0.2em] font-bold">
                        Fecha Registro
                    </span>

                    <p class="text-white text-lg font-semibold mt-3">
                        {{ $cliente->created_at->format('d/m/Y H:i') }}
                    </p>

                </div>

            </div>

            {{-- DIRECCIÓN --}}
            <div class="px-10 pb-10">

                <div class="bg-slate-900/40 border border-white/5 rounded-3xl p-8">

                    <span class="text-slate-500 text-xs uppercase tracking-[0.2em] font-bold">
                        Dirección
                    </span>

                    <p class="text-slate-300 text-lg leading-relaxed mt-4">
                        {{ $cliente->direccion ?? 'No registrada' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection