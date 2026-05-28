@extends('layouts.principal')

@section('content')
<div class="min-h-screen bg-slate-900 py-12 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto space-y-6">
        
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2rem] p-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <span class="text-fuchsia-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2 block">Ficha de Control Interno</span>
                <h2 class="text-4xl font-black text-white tracking-tight">Folio: {{ $cotizacion->folio }}</h2>
                <div class="flex items-center gap-2 mt-2">
                    <span class="px-2 py-0.5 rounded-lg bg-amber-500/10 text-amber-400 text-[10px] font-bold uppercase border border-amber-500/20">
                        {{ $cotizacion->estado }}
                    </span>
                    <span class="text-xs text-slate-500 font-mono">Creado el {{ \Carbon\Carbon::parse($cotizacion->created_at)->format('d/m/Y') }}</span>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 justify-center">
                <a href="{{ route('cotizaciones.index') }}" class="bg-white/5 border border-white/10 px-5 py-2.5 rounded-xl text-[10px] font-bold uppercase hover:bg-white/10 text-slate-300">Volver</a>
                @if(!$cotizacion->estaCongelada())
                    <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="bg-indigo-600 px-5 py-2.5 rounded-xl text-[10px] font-bold uppercase hover:bg-indigo-500 text-white">Editar</a>
                @endif
                <a href="{{ route('cotizaciones.pdf', $cotizacion) }}" target="_blank" class="bg-cyan-700 hover:bg-cyan-600 text-white px-5 py-2.5 rounded-xl text-[10px] font-bold uppercase">PDF</a>
                
                @if($cotizacion->estado === 'borrador')
                    <form action="{{ route('cotizaciones.congelar', $cotizacion) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-bold uppercase text-[10px]">Congelar</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-slate-950/50 p-6 rounded-2xl border border-white/5">
                        <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest block mb-3">Cliente</span>
                        <h3 class="text-white font-bold">{{ $cotizacion->cliente->empresa }}</h3>
                        <p class="text-xs text-slate-400 mt-1">{{ $cotizacion->cliente->nombre }}</p>
                    </div>
                    <div class="bg-slate-950/50 p-6 rounded-2xl border border-white/5">
                        <span class="text-[9px] font-black text-fuchsia-400 uppercase tracking-widest block mb-3">Emisión</span>
                        <p class="text-white font-mono font-bold text-lg">{{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') }}</p>
                        <p class="text-[10px] text-slate-500 mt-1 uppercase">Moneda: GTQ</p>
                    </div>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-white/5 pb-2">Oferta Económica</h4>
                    <div class="space-y-4">
                        @foreach($itemsComerciales as $item)
                            <div class="flex justify-between items-center text-sm border-b border-white/5 pb-2">
                                <span class="text-slate-300">{{ $item->descripcion }}</span>
                                <span class="font-mono font-bold text-white">Q {{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-4 border-t border-white/10 flex justify-between text-lg font-black text-fuchsia-400">
                        <span>TOTAL</span>
                        <span>Q {{ number_format($cotizacion->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-950/50 p-6 rounded-2xl border border-white/5 h-full">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Condiciones</h4>
                    <div class="space-y-4 text-xs text-slate-300">
                        <div><span class="block text-slate-500 text-[9px] uppercase">Entrega</span>{{ $cotizacion->lugar_entrega }}</div>
                        <div><span class="block text-slate-500 text-[9px] uppercase">Plazo</span>{{ $cotizacion->tiempo_entrega }}</div>
                        <div class="text-fuchsia-400 font-bold"><span class="block text-slate-500 text-[9px] uppercase">Forma de Pago</span>{{ $cotizacion->forma_pago }}</div>
                        <div><span class="block text-slate-500 text-[9px] uppercase">Garantía</span>{{ $cotizacion->garantia }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($detallesTecnicos->count() > 0)
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Detalle Técnico</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($detallesTecnicos as $det)
                    <div class="p-4 rounded-xl {{ $det->tipo == 'material' ? 'bg-emerald-500/5' : 'bg-indigo-500/5' }} border border-white/5">
                        <span class="text-[9px] font-bold uppercase {{ $det->tipo == 'material' ? 'text-emerald-400' : 'text-indigo-400' }}">{{ $det->tipo }}</span>
                        <p class="text-xs text-slate-300 mt-1">{{ $det->descripcion }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection