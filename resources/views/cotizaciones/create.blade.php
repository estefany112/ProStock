@extends('layouts.principal')

@section('content')

<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<style>
    @keyframes reveal { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-reveal { animation: reveal 0.5s ease-out forwards; }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    <div class="max-w-6xl mx-auto relative z-10">

        {{-- HEADER --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-400 text-[10px] font-black uppercase tracking-[0.2em] mb-3 inline-block">
                    Módulo de Ventas
                </span>
                <h1 class="text-4xl font-black text-white tracking-tighter">Nueva Cotización</h1>
            </div>
            <div>
                <a href="{{ route('cotizaciones.index') }}" class="bg-white/5 text-slate-300 px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/10 transition-all text-sm font-medium">
                    ← Volver al Listado
                </a>
            </div>
        </header>

        {{-- ALERTAS DE ERRORES DEL SERVIDOR (BACKEND) --}}
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

        {{-- FORMULARIO --}}
        <form action="{{ route('cotizaciones.store') }}" method="POST" id="cotizacionForm" class="animate-reveal">
            @csrf

            {{-- CABECERA CLIENTE --}}
            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-6 shadow-2xl mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Cliente *</label>
                        <select id="cliente_select" name="cliente_id" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-fuchsia-500" required>
                            <option value="">Selecciona un cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" data-nombre="{{ $cliente->empresa }}" data-nit="{{ $cliente->nit ?? 'C/F' }}" data-direccion="{{ $cliente->direccion ?? 'Ciudad' }}">
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.15em] text-slate-400 mb-2">Fecha de Emisión</label>
                        <input type="date" name="fecha_emision" value="{{ date('Y-m-d') }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white font-mono outline-none" required>
                    </div>
                </div>

                {{-- SNAPSHOT LECTURA --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-white/5 mt-6 pt-6">
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">Nombre Comercial</span>
                        <input id="cliente_nombre_view" readonly class="w-full bg-white/[0.02] border border-white/5 p-3 rounded-xl text-slate-300 text-sm outline-none">
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">NIT Tributario</span>
                        <input id="cliente_nit_view" readonly class="w-full bg-white/[0.02] border border-white/5 p-3 rounded-xl text-slate-400 text-sm font-mono outline-none">
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">Dirección Registrada</span>
                        <textarea id="cliente_direccion_view" rows="1" readonly class="w-full bg-white/[0.02] border border-white/5 p-3 rounded-xl text-slate-400 text-sm outline-none resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- TABLA DE DETALLES --}}
            {{-- DATOS DE LA EMPRESA EMISOR --}}
            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-6 shadow-2xl mb-6 animate-reveal">
                <div class="mb-4 pb-2 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white tracking-tight">1. INFORMACIÓN DEL PROVEEDOR</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    {{-- Nombre de la Empresa --}}
                    <div>
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Nombre de la Empresa</span>
                        <p class="text-sm font-bold text-white bg-slate-950/30 border border-white/5 px-4 py-2.5 rounded-xl">
                            {{ $empresa->nombre ?? 'NULL' }}
                        </p>
                    </div>

                    {{-- NIT Tributario --}}
                    <div>
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Nit</span>
                        <p class="text-sm font-mono text-slate-300 bg-slate-950/30 border border-white/5 px-4 py-2.5 rounded-xl">
                            {{ $empresa->nit ?? 'NULL' }}
                        </p>
                    </div>

                    {{-- Régimen del ISR --}}
                    <div>
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Régimen del ISR</span>
                        <p class="text-xs text-slate-300 bg-slate-950/30 border border-white/5 px-4 py-2.5 rounded-xl truncate" title="{{ $empresa->regimen_isr ?? 'NULL' }}">
                            {{ $empresa->regimen_isr ?? 'NULL' }}
                        </p>
                    </div>

                    {{-- Dirección Fiscal --}}
                    <div class="lg:col-span-2">
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Dirección</span>
                        <p class="text-sm text-slate-300 bg-slate-950/30 border border-white/5 px-4 py-2.5 rounded-xl">
                            {{ $empresa->direccion ?? 'NULL' }}
                        </p>
                    </div>

                    {{-- Teléfonos --}}
                    <div>
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Teléfonos</span>
                        <p class="text-sm font-mono text-slate-300 bg-slate-950/30 border border-white/5 px-4 py-2.5 rounded-xl">
                            {{ $empresa->telefono ?? 'NULL' }}
                        </p>
                    </div>

                    {{-- Correo Electrónico --}}
                    <div class="md:col-span-2 lg:col-span-1">
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Correo Electrónico</span>
                        <p class="text-sm text-slate-300 bg-slate-950/30 border border-white/5 px-4 py-2.5 rounded-xl truncate">
                            {{ $empresa->correo ?? 'NULL' }}
                        </p>
                    </div>

                    {{-- No. Cuenta Bancaria --}}
                    <div class="md:col-span-3">
                        <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mb-1">Instrucciones de Pago / Cuentas Bancarias</span>
                        <div class="text-sm font-mono text-indigo-400 bg-slate-950/40 border border-indigo-500/20 px-4 py-3 rounded-xl font-bold whitespace-pre-line">
                            {{ $empresa->cuenta_bancaria ?? 'NULL' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-6 shadow-2xl mb-6">
                <div class="flex justify-between items-center mb-6 border-b border-white/5 pb-4">
                    <h3 class="text-lg font-bold text-white tracking-tight">2. OFERTA ECONÓMICA</h3>
                    <button type="button" onclick="agregarItem()" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                        + Añadir Ítem
                    </button>
                </div>

                <div class="hidden md:grid grid-cols-12 gap-4 px-2 pb-2 text-[10px] font-black text-slate-500 uppercase tracking-wider">
                    <div class="col-span-1 text-center">Cant.</div>
                    <div class="col-span-2">U. Medida</div>
                    <div class="col-span-5">Descripción del Concepto</div>
                    <div class="col-span-2">P. Unitario</div>
                    <div class="col-span-2 text-right">Monto Línea</div>
                </div>

                <div id="items-container" class="space-y-4">
                    {{-- JavaScript inyectará la primera fila aquí al cargar --}}
                </div>
            </div>

            {{-- DETALLE DEL SERVICIO / MATERIAL --}}
            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-6 shadow-2xl mb-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white">Detalle del Servicio / Material</h3>

                    <div class="flex gap-2">
                        <button type="button" onclick="agregarDetalle('servicio')"
                            class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl text-xs font-bold text-white">
                            + Servicio
                        </button>

                        <button type="button" onclick="agregarDetalle('material')"
                            class="bg-emerald-600 hover:bg-emerald-500 px-4 py-2 rounded-xl text-xs font-bold text-white">
                            + Material
                        </button>
                    </div>
                </div>

                <div id="detalles-container" class="space-y-3"></div>

            </div>

            {{-- TOTALES Y PANEL DE ENVÍO --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-fuchsia-600 to-indigo-600 hover:from-fuchsia-500 hover:to-indigo-500 text-white font-bold px-8 py-4 rounded-2xl shadow-xl transition-all transform hover:-translate-y-0.5">
                        Procesar y Guardar Registro
                    </button>
                </div>
                <div class="bg-slate-950/80 border border-white/10 p-5 rounded-2xl space-y-3 shadow-2xl">
                    <input type="hidden" name="subtotal" id="input_subtotal" value="0.00">
                    <input type="hidden" name="iva" id="input_iva" value="0.00">
                    <input type="hidden" name="total" id="input_total" value="0.00">

                    <div class="flex justify-between text-xs font-medium text-slate-400">
                        <span>Subtotal Neto:</span>
                        <span id="subtotal" class="font-mono text-slate-200">Q0.00</span>
                    </div>
                    <div class="flex justify-between items-baseline pt-1">
                        <span class="text-xs font-black uppercase text-slate-300">Total Cotizado:</span>
                        <span id="total" class="text-2xl font-black font-mono text-fuchsia-400">Q0.00</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let itemIndex = 0;
    let detalleIndex = 0;
    let contadorServicio = 0; 

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar con un ítem obligatorio
        agregarItem();

        // Control dinámico de visor de cliente
        document.getElementById('cliente_select').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            document.getElementById('cliente_nombre_view').value = opt && opt.value !== "" ? opt.getAttribute('data-nombre') : '';
            document.getElementById('cliente_nit_view').value = opt && opt.value !== "" ? opt.getAttribute('data-nit') : '';
            document.getElementById('cliente_direccion_view').value = opt && opt.value !== "" ? opt.getAttribute('data-direccion') : '';
        });
    });

    function agregarItem() {
        const html = `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 bg-white/[0.01] md:bg-transparent p-4 md:p-0 rounded-2xl border border-white/5 md:border-none item-row" id="row_${itemIndex}">
                <div class="md:col-span-1">
                    <input type="number" name="items[${itemIndex}][cantidad]" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white font-mono text-sm text-center input-cantidad" min="1" value="1" required oninput="calcularFila(${itemIndex})">
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="items[${itemIndex}][unidad_medida]" placeholder="Ej. Servicio" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white text-sm" required>
                </div>
                <div class="md:col-span-5">
                    <input type="text" name="items[${itemIndex}][descripcion]" placeholder="Escribe el concepto detallado aquí..." class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white text-sm" required>
                </div>
                <div class="md:col-span-2">
                    <input type="number" name="items[${itemIndex}][precio_unitario]" placeholder="0.00" step="0.01" min="0" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white font-mono text-sm input-precio" required oninput="calcularFila(${itemIndex})">
                </div>
                <div class="md:col-span-2 flex items-center justify-between md:justify-end gap-4">
                    <span class="font-mono text-sm text-slate-300 font-bold span-total-fila">Q0.00</span>
                    <input type="hidden" class="input-total-fila" name="items[${itemIndex}][total]" value="0.00">
                    <button type="button" onclick="eliminarFila(${itemIndex})" class="p-2.5 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 transition-all font-sans font-bold">✕</button>
                </div>
            </div>`;
        document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
        itemIndex++;
    }

    function eliminarFila(idx) {
        if(document.querySelectorAll('.item-row').length > 1) {
            document.getElementById(`row_${idx}`).remove();
            calcularTotalesGlobales();
        } else {
            alert('Una cotización requiere al menos un concepto de venta.');
        }
    }

    function calcularFila(idx) {
        const row = document.getElementById(`row_${idx}`);
        const cant = parseFloat(row.querySelector('.input-cantidad').value) || 0;
        const precio = parseFloat(row.querySelector('.input-precio').value) || 0;
        const total = cant * precio;
        row.querySelector('.span-total-fila').innerText = 'Q' + total.toFixed(2);
        row.querySelector('.input-total-fila').value = total.toFixed(2);
        calcularTotalesGlobales();
    }

    function calcularTotalesGlobales() {
        let subtotal = 0;
        document.querySelectorAll('.input-total-fila').forEach(i => subtotal += parseFloat(i.value) || 0);
        let total = subtotal;

        document.getElementById('subtotal').innerText = 'Q' + subtotal.toFixed(2);
        document.getElementById('total').innerText = 'Q' + total.toFixed(2);

        document.getElementById('input_subtotal').value = subtotal.toFixed(2);
        document.getElementById('input_total').value = total.toFixed(2);
    }

    function agregarDetalle(tipo) {

    const container = document.getElementById('detalles-container');

    // -------------------------
    // 🔵 SERVICIO (LISTA a,b,c)
    // -------------------------
    if (tipo === 'servicio') {

        contadorServicio++;

        const letra = obtenerLetra(contadorServicio);

        const html = `
            <div class="detalle-item bg-white/[0.03] border border-white/10 p-4 rounded-xl">

                <input type="hidden" name="detalles[${detalleIndex}][tipo]" value="servicio">

                <div class="flex justify-between items-center mb-2">

                    <span class="text-indigo-400 font-bold text-xs uppercase">
                        SERVICIO ${letra})
                    </span>

                    <button type="button"
                        onclick="this.closest('.detalle-item').remove(); recalcularServicio();"
                        class="text-red-400 text-xs font-bold">
                        Eliminar
                    </button>

                </div>

                <textarea
                    name="detalles[${detalleIndex}][descripcion]"
                    class="w-full bg-slate-950/40 border border-white/10 p-3 rounded-xl text-white text-sm"
                    rows="2"
                    placeholder="Ej: Se realizó mantenimiento preventivo..."
                    required></textarea>

            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        detalleIndex++;

    }

    // -------------------------
    // 🟢 MATERIAL (solo 1 bloque)
    // -------------------------
    if (tipo === 'material') {

        const html = `
            <div class="detalle-item bg-white/[0.03] border border-white/10 p-4 rounded-xl">

                <input type="hidden" name="detalles[${detalleIndex}][tipo]" value="material">

                <div class="flex justify-between items-center mb-2">

                    <span class="text-emerald-400 font-bold text-xs uppercase">
                        MATERIAL
                    </span>

                    <button type="button"
                        onclick="this.closest('.detalle-item').remove()"
                        class="text-red-400 text-xs font-bold">
                        Eliminar
                    </button>

                </div>

                <textarea
                    name="detalles[${detalleIndex}][descripcion]"
                    class="w-full bg-slate-950/40 border border-white/10 p-3 rounded-xl text-white text-sm"
                    rows="3"
                    placeholder="Ej: Se despacha material con marca solicitada..."
                    required></textarea>

            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        detalleIndex++;
    }
}

    function obtenerLetra(index) {
        const letras = 'abcdefghijklmnopqrstuvwxyz';
        return letras[index - 1] || index;
    }

    function recalcularServicio() {
        contadorServicio = 0;

        document.querySelectorAll('.detalle-item').forEach(el => {

            const tipo = el.querySelector('input[name*="[tipo]"]').value;

            if (tipo === 'servicio') {
                contadorServicio++;
                const letra = obtenerLetra(contadorServicio);

                el.querySelector('span').innerText = `SERVICIO ${letra})`;
            }
        });
    }

    
</script>
@endsection