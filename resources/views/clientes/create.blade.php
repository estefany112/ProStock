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
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    {{-- EFECTO FONDO --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-cyan-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-5xl mx-auto relative z-10">

        {{-- HEADER --}}
        <div class="mb-10 animate-reveal">
            <span class="px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                Gestión Comercial
            </span>
            <h1 class="text-5xl font-black text-white tracking-tighter flex items-center gap-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-cyan-500/40 blur-2xl rounded-full animate-glow"></div>
                    <div class="relative z-10 p-4 bg-slate-900 border border-cyan-500/30 rounded-2xl text-cyan-400 shadow-2xl shadow-cyan-500/20">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            <path d="M4 14h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="animate-scan opacity-50"></path>
                        </svg>
                    </div>
                </div>
                Nuevo Cliente
            </h1>
            <p class="text-slate-400 mt-4">
                Registro de clientes para cotizaciones, servicios y facturación.
            </p>
        </div>

        {{-- ERRORES --}}
        @if($errors->any())
            <div class="mb-6 p-5 rounded-2xl bg-red-500/10 border border-red-500/20 animate-reveal">
                <ul class="space-y-2 text-red-400 text-sm">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO --}}
        <form action="{{ route('clientes.store') }}"
              method="POST"
              class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-10 shadow-2xl animate-reveal"
              style="animation-delay: 0.1s">
            
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- TIPO CLIENTE --}}
                <div>
                    <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                        Tipo Cliente
                    </label>
                    <select
                        name="tipo_cliente"
                        class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all">
                        <option value="">Seleccione</option>
                        <option value="Particular" {{ old('tipo_cliente') == 'Particular' ? 'selected' : '' }}>
                            Particular
                        </option>
                        <option value="Empresa Privada" {{ old('tipo_cliente') == 'Empresa Privada' ? 'selected' : '' }}>
                            Empresa Privada
                        </option>
                        <option value="Empresa Pública" {{ old('tipo_cliente') == 'Empresa Pública' ? 'selected' : '' }}>
                            Empresa Pública
                        </option>
                        <option value="Estatal" {{ old('tipo_cliente') == 'Estatal' ? 'selected' : '' }}>
                            Estatal
                        </option>
                    </select>
                </div>

                {{-- NOMBRE --}}
                <div>
                    <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                        Nombre Contacto
                    </label>
                    <input type="text"
                           name="nombre"
                           value="{{ old('nombre') }}"
                           placeholder="Ingrese nombre"
                           class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all">
                </div>

                {{-- EMPRESA --}}
                <div>
                    <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                        Empresa
                    </label>
                    <input type="text"
                           name="empresa"
                           value="{{ old('empresa') }}"
                           placeholder="Ingrese empresa"
                           class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all">
                </div>

                {{-- NIT --}}
                <div>
                    <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                        NIT
                    </label>
                    <input type="text"
                           name="nit"
                           value="{{ old('nit') }}"
                           placeholder="Ingrese NIT"
                           class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all">
                </div>

                {{-- TELÉFONO --}}
                <div>
                    <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                        Teléfono
                    </label>
                    <input type="text"
                           name="telefono"
                           value="{{ old('telefono') }}"
                           placeholder="Ingrese teléfono"
                           class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all">
                </div>

                {{-- CORREO --}}
                <div>
                    <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                        Correo Electrónico
                    </label>
                    <input type="email"
                           name="correo"
                           value="{{ old('correo') }}"
                           placeholder="Ingrese correo"
                           class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all">
                </div>

            </div>

            {{-- DIRECCIÓN --}}
            <div class="mt-8">
                <label class="block mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                    Dirección
                </label>
                <textarea
                    name="direccion"
                    rows="5"
                    placeholder="Ingrese dirección del cliente"
                    class="w-full bg-slate-900/70 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all resize-none">{{ old('direccion') }}</textarea>
            </div>

            {{-- BOTONES --}}
            <div class="flex items-center justify-end gap-4 pt-10">
                <a href="{{ route('clientes.index') }}"
                   class="px-6 py-3 rounded-2xl bg-white/5 border border-white/10 text-slate-300 hover:bg-white/10 transition-all">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-2xl bg-cyan-600 hover:bg-cyan-500 text-white font-bold shadow-xl shadow-cyan-900/30 transition-all transform hover:-translate-y-1">
                    Guardar Cliente
                </button>
            </div>

        </form>
    </div>
</div>

@endsection