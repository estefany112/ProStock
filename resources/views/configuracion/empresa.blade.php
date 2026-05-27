@extends('layouts.principal')

@section('content')

<style>
    @keyframes reveal { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-reveal { animation: reveal 0.5s ease-out forwards; }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    <div class="max-w-4xl mx-auto relative z-10">

        {{-- HEADER --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em] mb-3 inline-block">
                    Configuración Global
                </span>
                <h1 class="text-4xl font-black text-white tracking-tighter">Datos de la Empresa</h1>
            </div>
        </header>

        {{-- MENSAJE DE ÉXITO --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium animate-reveal flex items-center gap-3">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                {{ session('success') }}
            </div>
        @endif

        {{-- ALERTAS DE ERRORES DE VALIDACIÓN --}}
        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm font-medium animate-reveal">
                <span class="font-bold block mb-1">¡Revisa los siguientes campos requeridos!</span>
                <ul class="list-disc list-inside text-xs text-slate-300 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO DE CONFIGURACIÓN --}}
        <form action="{{ route('empresa.update') }}" method="POST" class="animate-reveal space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-6 md:p-8 shadow-2xl">
                
                <div class="mb-6 pb-4 border-b border-white/5">
                    <p class="text-xs text-slate-400 font-medium">Esta información se cargará de forma automática en todas las cotizaciones del sistema, hojas membretadas y reportes fiscales.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Nombre de la Empresa --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Nombre de la Empresa *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $empresa->nombre) }}" placeholder="Ej. PROSERVE, S.A." class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-indigo-500 transition-all font-bold" required>
                    </div>

                    {{-- NIT Tributario --}}
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Nit Tributario *</label>
                        <input type="text" name="nit" value="{{ old('nit', $empresa->nit) }}" placeholder="Ej. 9876543-2" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white font-mono outline-none focus:border-indigo-500 transition-all" required>
                    </div>

                    {{-- Régimen del ISR --}}
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Régimen del ISR *</label>
                        <input type="text" name="regimen_isr" value="{{ old('regimen_isr', $empresa->regimen_isr) }}" placeholder="Ej. Opcional Simplificado Sobre Ingresos" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-indigo-500 transition-all text-sm" required>
                    </div>

                    {{-- Dirección Física --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Dirección Fiscal / Comercial *</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $empresa->direccion) }}" placeholder="Ej. Avenida Las Américas, Zona 14, Ciudad de Guatemala" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-indigo-500 transition-all text-sm" required>
                    </div>

                    {{-- Teléfonos --}}
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Teléfonos de Contacto *</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $empresa->telefono) }}" placeholder="Ej. +502 2000-0000 / 2000-0001" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white font-mono outline-none focus:border-indigo-500 transition-all" required>
                    </div>

                    {{-- Correo Electrónico --}}
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Correo Electrónico Institucional *</label>
                        <input type="email" name="correo" value="{{ old('correo', $empresa->correo) }}" placeholder="Ej. contacto@tuempresa.com" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-indigo-500 transition-all" required>
                    </div>

                    {{-- No. Cuenta Bancaria --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-indigo-400 mb-2">Instrucciones de Pago / No. Cuenta Bancaria *</label>
                        <textarea name="cuenta_bancaria" rows="3" placeholder="Ej. Monetaria Banco Industrial: 000-000000-0 a nombre de PROSERVE" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white font-mono text-sm outline-none focus:border-indigo-500 transition-all resize-none" required>{{ old('cuenta_bancaria', $empresa->cuenta_bancaria) }}</textarea>
                    </div>

                </div>
            </div>

            {{-- BOTÓN PROCESAR --}}
            <div class="flex justify-end">
                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-500 hover:to-fuchsia-500 text-white font-bold px-12 py-4 rounded-2xl shadow-xl transition-all transform hover:-translate-y-0.5 uppercase tracking-wider text-xs">
                    Guardar Cambios de la Empresa
                </button>
            </div>

        </form>
    </div>
</div>

@endsection