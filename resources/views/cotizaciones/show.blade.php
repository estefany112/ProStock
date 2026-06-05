@extends('layouts.principal')

@section('content')
<div class="min-h-screen py-12 px-4 bg-slate-900">
    
    <div class="max-w-3xl mx-auto bg-stone-50 border border-stone-200 shadow-[0_20px_50px_rgba(0,0,0,0.3)] animate-in fade-in slide-in-from-bottom-8 duration-700 overflow-hidden">
        
        <div class="p-12 border-b-4 border-sky-900 bg-white">
            <div class="flex justify-between items-center">
                <div>
                    <div class="w-12 h-12 bg-sky-900 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h1 class="text-4xl font-black text-stone-900 tracking-tighter uppercase">CTZ_{{ $cotizacion->folio }}</h1>
                </div>
                <div class="text-right border-l-2 border-stone-200 pl-6">
                    <div class="text-[9px] font-black text-stone-400 uppercase tracking-widest">Estado</div>
                    <div class="text-sky-900 font-black text-xs uppercase">{{ strtoupper($cotizacion->estado) }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 bg-stone-100 border-b border-stone-200">
            <div class="p-8 border-r border-stone-200">
                <div class="text-[9px] font-black text-stone-500 uppercase mb-1">Cliente Industrial</div>
                <div class="text-stone-900 font-bold text-lg">{{ $cotizacion->cliente->empresa }}</div>
            </div>
            <div class="p-8">
                <div class="text-[9px] font-black text-stone-500 uppercase mb-1">Fecha de Emisión</div>
                <div class="text-stone-900 font-bold text-lg">{{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') }}</div>
            </div>
            @if(
                $cotizacion->cliente &&
                in_array($cotizacion->cliente->tipo_cliente, ['Empresa Pública', 'Estatal'])
            )
            <div class="p-8 border-t border-stone-200 col-span-2">
                <div class="text-[9px] font-black text-stone-500 uppercase mb-1">
                    NOG
                </div>
                <div class="text-stone-900 font-bold text-lg">
                    {{ $cotizacion->nog }}
                </div>
            </div>
            @endif
        </div>

        <table class="w-full text-left">
            <thead class="bg-stone-800 text-white text-[9px] uppercase font-black">
                <tr>
                    <th class="px-8 py-4">Cant.</th>
                    <th class="px-8 py-4">Descripción de equipo / servicio</th>
                    <th class="px-8 py-4 text-right">Unitario</th>
                    <th class="px-8 py-4 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-200">
                @foreach($itemsComerciales as $item)
                <tr>
                    <td class="px-8 py-5 text-xs font-mono text-stone-500">{{ $item->cantidad }}</td>
                    <td class="px-8 py-5 font-semibold text-stone-800 text-sm">{{ $item->descripcion }}</td>
                    <td class="px-8 py-5 text-right text-xs text-stone-500">Q {{ number_format($item->precio_unitario, 2) }}</td>
                    <td class="px-8 py-5 text-right font-black text-stone-900 text-sm">Q {{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="bg-sky-900 px-8 py-6 flex justify-between items-center text-white">
            <span class="font-black uppercase text-[10px] tracking-[0.2em]">Total Propuesta</span>
            <span class="text-2xl font-black tabular-nums">Q {{ number_format($cotizacion->total, 2) }}</span>
        </div>

        <div class="grid grid-cols-2 border-b border-stone-200">
            <div class="p-8 border-r border-stone-200">
                <h4 class="text-[9px] font-black text-stone-500 uppercase tracking-widest mb-4">Alcance Técnico</h4>
                @foreach($detallesTecnicos as $det)
                    <div class="text-xs text-stone-700 mb-2 flex gap-2"><span class="text-sky-600 font-black">⚙</span> {{ $det->descripcion }}</div>
                @endforeach
            </div>
            
            <div class="p-8 bg-stone-100/50">
                <h4 class="text-[9px] font-black text-stone-500 uppercase tracking-widest mb-4">Condiciones Comerciales</h4>
                <div class="space-y-4">
                    @foreach(['Lugar' => $cotizacion->lugar_entrega, 'Tiempo' => $cotizacion->tiempo_entrega, 'Garantía' => $cotizacion->garantia, 'Pago' => $cotizacion->forma_pago, 'Validez' => $cotizacion->validez_oferta] as $k => $v)
                        <div class="border-l-2 border-sky-900 pl-3">
                            <div class="text-[8px] font-black text-stone-400 uppercase">{{ $k }}</div>
                            <div class="text-stone-800 text-xs font-semibold">{{ $v }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex bg-stone-200">
            <a href="{{ route('cotizaciones.index') }}" class="flex-1 py-4 text-center border-r border-stone-300 text-stone-700 font-black uppercase text-[9px] hover:bg-stone-300">Volver</a>
            
            @if(!$cotizacion->estaCongelada())
                <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="flex-1 py-4 text-center border-r border-stone-300 bg-sky-100 text-sky-800 font-black uppercase text-[9px] hover:bg-sky-200">Editar</a>
                <form action="{{ route('cotizaciones.congelar', $cotizacion) }}" method="POST" class="flex-1 border-r border-stone-300">
                    @csrf
                    <button type="submit" class="w-full h-full text-center bg-emerald-800 text-white font-black uppercase text-[9px] hover:bg-emerald-900">Congelar</button>
                </form>
            @endif
            
            <a href="{{ route('cotizaciones.pdf', $cotizacion) }}" target="_blank" class="flex-1 py-4 text-center bg-stone-800 text-white font-black uppercase text-[9px] hover:bg-black">Exportar PDF</a>
        </div>
    </div>
</div>
@endsection