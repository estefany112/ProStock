@extends('layouts.principal')

@section('content')

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    <div class="max-w-4xl mx-auto relative z-10 animate-reveal">
        
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('cotizaciones.index') }}" class="bg-white/5 border border-white/10 text-slate-300 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-white/10 transition-all">
                ← Volver al Listado
            </a>
            
            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest
                @if($cotizacion->estado == 'aceptada') bg-emerald-500/10 border border-emerald-500/20 text-emerald-400
                @elseif($cotizacion->estado == 'pendiente') bg-amber-500/10 border border-amber-500/20 text-amber-400
                @elseif($cotizacion->estado == 'procesada') bg-cyan-500/10 border border-cyan-500/20 text-cyan-400
                @else bg-rose-500/10 border border-rose-500/20 text-rose-400 @endif">
                Estado: {{ $cotizacion->estado }}
            </span>
        </div>

        <div class="bg-slate-900/60 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-fuchsia-500 via-purple-500 to-indigo-500"></div>
            
            <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-white/5 pb-6 mb-6">
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight mb-1">COMPROBANTE DE COTIZACIÓN</h2>
                    <span class="font-mono text-fuchsia-400 text-lg font-bold">{{ $cotizacion->folio }}</span>
                </div>
                <div class="text-left sm:text-right font-mono text-sm text-slate-400">
                    <p><strong class="text-slate-500">Fecha de Emisión:</strong> {{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-5 mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Cliente</span>
        {{-- El operador ?-> evita que se rompa si cliente es null --}}
        <p class="text-base font-bold text-white">
            {{ $cotizacion->cliente?->nombre ?? 'Cliente no registrado o eliminado' }}
        </p>
    </div>
    <div class="space-y-1 text-xs text-slate-300">
        <p><strong class="text-slate-500 font-mono">NIT:</strong> {{ $cotizacion->cliente?->nit ?? 'C/F' }}</p>
        <p><strong class="text-slate-500 font-mono">Ubicación:</strong> {{ $cotizacion->cliente?->direccion ?? 'No disponible' }}</p>
    </div>
</div>

            <div class="space-y-4 mb-6">
                <div class="border border-white/5 rounded-xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] font-black text-slate-500 uppercase tracking-wider">
                                <th class="p-4 text-center">Cant.</th>
                                <th class="p-4">U. Medida</th>
                                <th class="p-4 w-1/2">Descripción</th>
                                <th class="p-4 text-right">P. Unitario</th>
                                <th class="p-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-slate-300 text-sm">
                            @foreach($cotizacion->items as $item)
                                <tr>
                                    <td class="p-4 text-center font-mono text-white font-bold">{{ $item->cantidad }}</td>
                                    <td class="p-4 text-slate-400 text-xs">{{ $item->unidad_medida }}</td>
                                    <td class="p-4 text-slate-200">{{ $item->descripcion }}</td>
                                    <td class="p-4 text-right font-mono text-xs">Q{{ number_format($item->precio_unitario, 2) }}</td>
                                    <td class="p-4 text-right font-mono font-bold text-white">Q{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <div class="w-full sm:w-64 bg-black/40 p-4 rounded-xl border border-white/5 space-y-2 text-sm">
                    <div class="flex justify-between text-slate-400 text-xs">
                        <span>Subtotal:</span>
                        <span class="font-mono text-slate-200">Q{{ number_format($cotizacion->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-400 text-xs border-b border-white/5 pb-2">
                        <span>IVA (12%):</span>
                        <span class="font-mono text-slate-200">Q{{ number_format($cotizacion->iva, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-baseline pt-1">
                        <span class="font-bold text-white text-xs uppercase">Total Neto:</span>
                        <span class="text-xl font-black font-mono text-fuchsia-400">Q{{ number_format($cotizacion->total, 2) }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection