@extends('layouts.principal')

@section('content')
<div class="min-h-screen bg-mesh py-12 px-6">
    <div class="max-w-5xl mx-auto bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-8 shadow-2xl text-slate-100">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-white/5 pb-4">
            <div>
                <span class="px-3 py-1 rounded-full bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2 inline-block">
                    Ficha de Control Interno
                </span>
                <h2 class="text-3xl font-black tracking-tight text-white">Folio: {{ $cotizacion->folio }}</h2>
                <p class="text-xs text-slate-400 font-mono mt-1">Estado del Registro: 
                    <span class="uppercase font-bold text-amber-400">{{ $cotizacion->estado }}</span>
                </p>
            </div>
            <div class="flex flex-wrap gap-2.5 w-full sm:w-auto">
                <a href="{{ route('cotizaciones.index') }}" class="bg-white/5 border border-white/10 px-4 py-2.5 rounded-xl text-xs font-bold uppercase transition-all hover:bg-white/10 text-slate-300">
                    ← Volver
                </a>
                <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="bg-indigo-600 px-4 py-2.5 rounded-xl text-xs font-bold uppercase transition-all hover:bg-indigo-500 text-white">
                    Editar Ficha
                </a>
                <button onclick="window.print();" class="bg-fuchsia-600 px-4 py-2.5 rounded-xl text-xs font-bold uppercase transition-all hover:bg-fuchsia-500 text-white">
                    Imprimir Documento
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 bg-slate-950/40 border border-white/5 p-6 rounded-2xl">
            <div>
                <span class="text-[10px] font-black tracking-widest text-indigo-400 uppercase block mb-2">Información del Cliente</span>
                <h3 class="text-lg font-bold text-white mb-1">{{ $cotizacion->cliente->empresa ?? $cotizacion->cliente->nombre }}</h3>
                <p class="text-sm text-slate-300">Atención Directa: {{ $cotizacion->cliente->nombre }}</p>
                <p class="text-xs text-slate-400 mt-2 font-mono">NIT: {{ $cotizacion->cliente->nit ?? 'C/F' }}</p>
                <p class="text-xs text-slate-400">Dirección: {{ $cotizacion->cliente->direccion ?? 'Ciudad de Guatemala' }}</p>
            </div>
            <div class="md:text-right flex flex-col justify-between items-start md:items-end gap-4">
                <div>
                    <span class="text-[10px] font-black tracking-widest text-fuchsia-400 uppercase block mb-1">Fecha de Emisión</span>
                    <p class="text-sm font-mono text-white font-bold">{{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Moneda del Sistema</span>
                    <span class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-mono rounded-lg font-bold">GTQ (Quetzales)</span>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h4 class="text-xs font-black tracking-widest text-slate-400 uppercase border-b border-white/5 pb-2 mb-4">1. INFORMACIÓN DEL PROVEEDOR</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div><span class="text-slate-500 block">Razón Social:</span><strong class="text-white">{{ $empresa->nombre ?? 'N/A' }}</strong></div>
                <div><span class="text-slate-500 block">NIT Tributario:</span><strong class="text-slate-300 font-mono">{{ $empresa->nit ?? 'N/A' }}</strong></div>
                <div><span class="text-slate-500 block">Régimen Legal:</span><strong class="text-slate-300 block truncate" title="{{ $empresa->regimen_isr }}">{{ $empresa->regimen_isr ?? 'N/A' }}</strong></div>
                <div class="md:col-span-2"><span class="text-slate-500 block">Dirección Física:</span><strong class="text-slate-300">{{ $empresa->direccion ?? 'N/A' }}</strong></div>
                <div><span class="text-slate-500 block">Contacto:</span><strong class="text-slate-300">{{ $empresa->telefono ?? 'N/A' }} / {{ $empresa->correo ?? 'N/A' }}</strong></div>
            </div>
        </div>

        <div class="mb-8">
            <h4 class="text-xs font-black tracking-widest text-slate-400 uppercase border-b border-white/5 pb-2 mb-4">2. OFERTA ECONÓMICA</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap md:whitespace-normal">
                    <thead>
                        <tr class="text-[10px] uppercase font-black text-slate-500 tracking-wider border-b border-white/10">
                            <th class="py-2.5 text-center w-12">Cant.</th>
                            <th class="w-24">U. Medida</th>
                            <th>Descripción del Concepto</th>
                            <th class="text-right w-32">P. Unitario</th>
                            <th class="text-right w-32">Monto Línea</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($itemsComerciales as $item)
                            <tr class="text-slate-200 hover:bg-white/[0.01] transition-all">
                                <td class="py-3 text-center font-mono">{{ $item->cantidad }}</td>
                                <td class="text-slate-400 text-xs">{{ $item->unidad_medida }}</td>
                                <td class="font-medium text-white text-xs md:text-sm">{{ $item->descripcion }}</td>
                                <td class="text-right font-mono">Q {{ number_format($item->precio_unitario, 2) }}</td>
                                <td class="text-right font-mono font-bold text-slate-100">Q {{ number_format($item->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-xs text-slate-500 italic">No se encontraron ítems comerciales en este registro.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6 items-center border-t border-white/5 pt-4">
                <div class="md:col-span-7 bg-white/[0.02] p-4 rounded-xl border border-white/5">
                    <span class="text-[9px] uppercase font-black text-slate-500 tracking-wider block mb-1">Total en Letras</span>
                    <p class="text-xs font-bold text-slate-300 uppercase font-sans tracking-wide">{{ $cotizacion->total_letras ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-5 bg-slate-950/60 p-4 rounded-xl border border-white/5 text-right space-y-1.5 shadow-inner">
                    <div class="flex justify-between text-xs text-slate-400 font-mono">
                        <span>Subtotal:</span>
                        <span>Q {{ number_format($cotizacion->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-base font-black text-fuchsia-400 border-t border-white/10 pt-1.5 font-mono">
                        <span>TOTAL Q:</span>
                        <span>Q {{ number_format($cotizacion->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8 @if($detallesTecnicos->count() == 0) hidden @endif">
            <h4 class="text-xs font-black tracking-widest text-slate-400 uppercase border-b border-white/5 pb-2 mb-4">3. DETALLE DEL SERVICIO / MATERIAL</h4>
            <div class="space-y-3">
                @php $servCount = 0; @endphp
                @foreach($detallesTecnicos as $det)
                    @if($det->tipo === 'servicio')
                        @php $servCount++; @endphp
                        <div class="p-4 rounded-xl bg-indigo-500/5 border border-indigo-500/10 text-xs md:text-sm">
                            <span class="font-black text-indigo-400 block mb-1 uppercase text-[10px] tracking-wider">SERVICIO {{ chr(96 + $servCount) }})</span>
                            <p class="text-slate-200 whitespace-pre-wrap font-sans leading-relaxed">{{ $det->descripcion }}</p>
                        </div>
                    @elseif($det->tipo === 'material')
                        <div class="p-4 rounded-xl bg-emerald-500/5 border border-emerald-500/10 text-xs md:text-sm">
                            <span class="font-black text-emerald-400 block mb-1 uppercase text-[10px] tracking-wider">MATERIAL</span>
                            <p class="text-slate-200 whitespace-pre-wrap font-sans leading-relaxed">{{ $det->descripcion }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="space-y-4 mb-8">
            @if($cotizacion->lugar_entrega)
                <div class="p-4 bg-white/[0.01] border border-white/5 rounded-2xl">
                    <h5 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1.5">4. LUGAR DE ENTREGA</h5>
                    <p class="text-sm text-slate-200 font-medium">{{ $cotizacion->lugar_entrega }}</p>
                </div>
            @endif

            @if($cotizacion->tiempo_entrega)
                <div class="p-4 bg-white/[0.01] border border-white/5 rounded-2xl">
                    <h5 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1.5">5. TIEMPO DE ENTREGA</h5>
                    <p class="text-sm text-slate-200 font-medium">{{ $cotizacion->tiempo_entrega }}</p>
                </div>
            @endif

            @if($cotizacion->garantia)
                <div class="p-4 bg-white/[0.01] border border-white/5 rounded-2xl">
                    <h5 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1.5">6. GARANTÍA</h5>
                    <p class="text-sm text-slate-200 font-medium">{{ $cotizacion->garantia }}</p>
                </div>
            @endif

            @if($cotizacion->forma_pago)
                <div class="p-4 bg-slate-950/30 border border-fuchsia-500/10 rounded-2xl">
                    <h5 class="text-xs font-black text-fuchsia-400 uppercase tracking-wider mb-1.5">7. FORMA DE PAGO</h5>
                    <p class="text-sm text-fuchsia-300 font-bold tracking-wide">{{ $cotizacion->forma_pago }}</p>
                </div>
            @endif

            @if($cotizacion->validez_oferta)
                <div class="p-4 bg-white/[0.01] border border-white/5 rounded-2xl">
                    <h5 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1.5">8. VALIDEZ DE LA OFERTA</h5>
                    <p class="text-sm text-slate-200 font-medium">{{ $cotizacion->validez_oferta }}</p>
                </div>
            @endif
        </div>

        @if(!empty($empresa->cuenta_bancaria))
        <div class="p-4 bg-indigo-950/30 border border-indigo-500/10 rounded-2xl mb-8">
            <h5 class="text-xs font-black text-indigo-400 uppercase tracking-wider mb-2">Instrucciones de Pago / Cuentas Bancarias</h5>
            <p class="font-mono text-xs text-slate-300 whitespace-pre-line leading-relaxed">{{ $empresa->cuenta_bancaria }}</p>
        </div>
        @endif

        <div class="border-t border-white/5 pt-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="text-xs md:text-sm text-slate-400 space-y-3">
                <h5 class="text-xs font-black text-slate-500 uppercase tracking-wider">9. PANEL DE CIERRE Y AUTORIZACIÓN</h5>
                <p class="italic text-slate-300 font-sans">"{{ $cotizacion->clausula_despedida ?? 'Esperando poder servirles de la mejor manera, me suscribo de ustedes. Atentamente,' }}"</p>
                <div class="pt-2">
                    <strong class="text-white block text-sm font-bold">{{ $cotizacion->nombre_firmante ?? 'Ing. Wuilmar Velásquez' }}</strong>
                    <span class="text-slate-500 text-[10px] uppercase font-black tracking-widest block mt-0.5">Responsable de la Propuesta / Firma</span>
                </div>
            </div>
            
            <div class="flex justify-start md:justify-end">
                <div class="text-center p-4 bg-slate-950/40 border border-white/5 rounded-2xl w-64 shadow-xl">
                    <div class="h-16 flex items-center justify-center mb-2">
                        <img src="{{ asset('images/firma_patrono.jpg') }}" alt="Sello Gerencial" class="max-h-full max-w-full object-contain opacity-80" onerror="this.style.display='none';">
                    </div>
                    <span class="text-[9px] font-mono tracking-widest text-slate-500 uppercase block border-t border-white/5 pt-1">Validación: PROSERVE-GERENCIA</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection