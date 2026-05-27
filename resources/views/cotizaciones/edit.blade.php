@extends('layouts.principal')

@section('content')

<div class="min-h-screen bg-mesh py-12 px-6">
    <div class="max-w-6xl mx-auto">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-black text-white">Editar Cotización</h1>
                <p class="text-slate-400 text-sm">Modificar registro #{{ $cotizacion->folio }}</p>
            </div>

            <a href="{{ route('cotizaciones.index') }}"
               class="bg-white/5 text-slate-300 px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/10">
                ← Volver
            </a>
        </div>

        <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST" id="cotizacionForm">
            @csrf
            @method('PUT')

            {{-- CLIENTE --}}
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-6">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="text-slate-400 text-xs">Cliente</label>
                        <select name="cliente_id"
                                class="w-full bg-slate-950 text-white p-3 rounded-xl border border-white/10"
                                required>

                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ $cotizacion->cliente_id == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-slate-400 text-xs">Fecha</label>
                        <input type="date"
                               name="fecha_emision"
                               value="{{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('Y-m-d') }}"
                               class="w-full bg-slate-950 text-white p-3 rounded-xl border border-white/10">
                    </div>
                </div>

            </div>

            {{-- ITEMS --}}
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-6">
                <h3 class="text-white font-bold mb-4">Items</h3>

                <div id="items-container">
                    @foreach($cotizacion->items as $i => $item)
                        <div class="grid grid-cols-12 gap-4 mb-3 item-row" id="row_{{ $i }}">

                            <div class="col-span-1">
                                <input type="number"
                                       name="items[{{ $i }}][cantidad]"
                                       value="{{ $item->cantidad }}"
                                       class="w-full bg-slate-950 text-white p-2 rounded"
                                       oninput="calcularFila({{ $i }})">
                            </div>

                            <div class="col-span-2">
                                <input type="text"
                                       name="items[{{ $i }}][unidad_medida]"
                                       value="{{ $item->unidad_medida }}"
                                       class="w-full bg-slate-950 text-white p-2 rounded">
                            </div>

                            <div class="col-span-5">
                                <input type="text"
                                       name="items[{{ $i }}][descripcion]"
                                       value="{{ $item->descripcion }}"
                                       class="w-full bg-slate-950 text-white p-2 rounded">
                            </div>

                            <div class="col-span-2">
                                <input type="number"
                                       name="items[{{ $i }}][precio_unitario]"
                                       value="{{ $item->precio_unitario }}"
                                       class="w-full bg-slate-950 text-white p-2 rounded"
                                       oninput="calcularFila({{ $i }})">
                            </div>

                            <div class="col-span-2 flex justify-between items-center">
                                <span class="text-white">Q{{ $item->total }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('cotizaciones.index') }}"
                   class="px-5 py-3 bg-white/10 text-white rounded-xl">
                    Cancelar
                </a>

                <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold">
                    Actualizar Cotización
                </button>
            </div>

        </form>

    </div>
</div>

@endsection