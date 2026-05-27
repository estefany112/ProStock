@extends('layouts.principal')

@section('content')
<div class="min-h-screen bg-mesh py-12 px-6 text-slate-100 font-sans">
    <div class="max-w-6xl mx-auto">
        
        <header class="flex justify-between items-center mb-8">
            <div>
                <span class="px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2 inline-block">
                    Panel de Control — PROSTOCK
                </span>
                <h1 class="text-3xl font-black text-white tracking-tighter">Crear Nueva Cotización</h1>
            </div>
            <a href="{{ route('cotizaciones.index') }}" class="bg-white/5 text-slate-300 hover:bg-white/10 px-4 py-2 rounded-xl text-xs font-bold border border-white/10 transition-all">
                ✕ Cancelar y Volver
            </a>
        </header>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-medium">
                <span class="font-bold block mb-1">Por favor corrige los siguientes errores:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cotizaciones.store') }}" method="POST" id="cotizacionForm" class="space-y-6">
            @csrf

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-white/5 pb-3">
                    <h3 class="text-xs font-black tracking-widest text-slate-400 uppercase">A. DATOS DE IDENTIFICACIÓN DEL CLIENTE</h3>
                    <span class="text-[10px] font-mono text-indigo-400 bg-indigo-500/10 px-2.5 py-0.5 rounded border border-indigo-500/20 font-bold">Tipo: Factura Comercial</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Contacto o Cliente *</label>
                        <select id="cliente_select" name="cliente_id" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-fuchsia-500 transition-all text-sm font-medium" required>
                            <option value="">Selecciona un cliente de la base de datos...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}
                                        data-empresa="{{ $cliente->empresa }}" 
                                        data-nit="{{ $cliente->nit ?? 'C/F' }}" 
                                        data-direccion="{{ $cliente->direccion ?? 'Ciudad de Guatemala' }}">
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Fecha de Emisión</label>
                        <input type="date" name="fecha_emision" value="{{ old('fecha_emision', date('Y-m-d')) }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white font-mono outline-none shadow-inner" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-950/40 p-4 rounded-xl border border-white/5 mt-2">
                    <div>
                        <span class="text-[10px] font-bold tracking-wider text-slate-500 uppercase block mb-1">Razón Social Registrada</span>
                        <input id="cliente_nombre_view" readonly class="w-full bg-slate-950/80 border border-white/5 p-2.5 rounded-lg text-slate-300 text-xs font-bold outline-none select-none">
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-wider text-slate-500 uppercase block mb-1">NIT Tributario</span>
                        <input id="cliente_nit_view" readonly class="w-full bg-slate-950/80 border border-white/5 p-2.5 rounded-lg text-slate-400 text-xs font-mono outline-none select-none">
                    </div>
                    <div>
                        <span class="text-[10px] font-bold tracking-wider text-slate-500 uppercase block mb-1">Dirección Física de Entrega</span>
                        <textarea id="cliente_direccion_view" rows="1" readonly class="w-full bg-slate-950/80 border border-white/5 p-2.5 rounded-lg text-slate-400 text-xs outline-none resize-none select-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl space-y-4">
                <div class="border-b border-white/5 pb-2">
                    <h3 class="text-xs font-black tracking-widest text-slate-400 uppercase">1. DATOS COMPLEMENTARIOS DEL OFERENTE</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="bg-slate-950/40 border border-white/5 p-3 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Nombre de la Empresa</span>
                        <span class="font-bold text-slate-200">{{ $empresa->nombre ?? 'NULL' }}</span>
                    </div>
                    <div class="bg-slate-950/40 border border-white/5 p-3 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Nit de la Empresa</span>
                        <span class="font-mono text-slate-300">{{ $empresa->nit ?? 'NULL' }}</span>
                    </div>
                    <div class="bg-slate-950/40 border border-white/5 p-3 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Régimen de Impuestos</span>
                        <span class="text-slate-300 block truncate" title="{{ $empresa->regimen_isr ?? 'NULL' }}">{{ $empresa->regimen_isr ?? 'NULL' }}</span>
                    </div>
                    <div class="md:col-span-2 bg-slate-950/40 border border-white/5 p-3 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Dirección Operativa</span>
                        <span class="text-slate-300">{{ $empresa->direccion ?? 'NULL' }}</span>
                    </div>
                    <div class="bg-slate-950/40 border border-white/5 p-3 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Teléfono Corporativo</span>
                        <span class="font-mono text-slate-300">{{ $empresa->telefono ?? 'NULL' }}</span>
                    </div>
                    <div class="md:col-span-3 bg-indigo-950/20 border border-indigo-900/30 p-3 rounded-xl">
                        <span class="text-[10px] font-bold text-indigo-400 uppercase block mb-1">Datos Bancarios para Depósito / Transferencia</span>
                        <span class="font-mono text-indigo-300 font-semibold whitespace-pre-line block mt-0.5">{{ $empresa->cuenta_bancaria ?? 'NULL' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="flex justify-between items-center mb-6 border-b border-white/5 pb-3">
                    <h3 class="text-xs font-black tracking-widest text-slate-400 uppercase">2. DETALLE DE VALORES Y OFERTA ECONÓMICA</h3>
                    <button type="button" onclick="agregarItem()" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                        + Añadir Ítem Facturable
                    </button>
                </div>

                <div class="hidden md:grid grid-cols-12 gap-4 px-2 pb-2 text-[10px] font-black text-slate-500 uppercase tracking-wider border-b border-white/5 mb-3">
                    <div class="col-span-1 text-center">Cant.</div>
                    <div class="col-span-2">U. Medida</div>
                    <div class="col-span-5">Descripción del Concepto</div>
                    <div class="col-span-2">P. Unitario</div>
                    <div class="col-span-2 text-right">Monto Línea</div>
                </div>

                <div id="items-container" class="space-y-4 mb-6"></div>

                <div class="border-t border-white/5 pt-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                    <div class="md:col-span-7">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Cantidad Total en Letras</label>
                        <input type="text" name="total_letras" id="input_total_letras" value="{{ old('total_letras') }}" readonly
                               class="w-full bg-slate-950/40 border border-white/5 p-3.5 rounded-xl text-slate-400 outline-none text-xs font-semibold font-mono select-none" placeholder="Cálculo automático de sistema...">
                    </div>

                    <div class="md:col-span-5 bg-slate-950/80 border border-white/10 p-5 rounded-2xl space-y-3 shadow-2xl">
                        <input type="hidden" name="subtotal" id="input_subtotal" value="{{ old('subtotal', '0.00') }}">
                        <input type="hidden" name="total" id="input_total" value="{{ old('total', '0.00') }}">

                        <div class="flex justify-between text-xs font-medium text-slate-400">
                            <span>Monto Base Subtotal:</span>
                            <span id="subtotal" class="font-mono text-slate-200">Q0.00</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-2 border-t border-white/10">
                            <span class="text-xs font-black uppercase text-slate-300 tracking-wider">TOTAL GENERAL (IVA INC):</span>
                            <span id="total" class="text-2xl font-black font-mono text-fuchsia-400">Q0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-white/5">
                    <h3 class="text-xs font-black tracking-widest text-slate-400 uppercase">3. ALCANCES Y DETALLE DEL SERVICIO / MATERIAL</h3>
                    <div class="flex gap-2">
                        <button type="button" onclick="agregarDetail('servicio')" class="bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                            + Servicio (a, b, c)
                        </button>
                        <button type="button" onclick="agregarDetail('material')" class="bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                            + Material
                        </button>
                    </div>
                </div>
                <div id="detalles-container" class="space-y-3"></div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="mb-2 pb-2 border-b border-white/5">
                    <h3 class="text-xs font-black tracking-wider text-slate-400 uppercase">4. LUGAR DE ENTREGA</h3>
                </div>
                <input type="text" name="lugar_entrega" value="{{ old('lugar_entrega') }}" placeholder="Ej. Instalaciones de la Planta Hidroeléctrica Jurún Marinalá..." class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm focus:border-fuchsia-500 transition-all">
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="mb-2 pb-2 border-b border-white/5">
                    <h3 class="text-xs font-black tracking-wider text-slate-400 uppercase">5. TIEMPO DE ENTREGA</h3>
                </div>
                <input type="text" name="tiempo_entrega" value="{{ old('tiempo_entrega') }}" placeholder="Ej. 10 días hábiles posteriores a recibir Orden de Compra..." class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm focus:border-fuchsia-500 transition-all">
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="mb-2 pb-2 border-b border-white/5">
                    <h3 class="text-xs font-black tracking-wider text-slate-400 uppercase">6. GARANTÍA</h3>
                </div>
                <input type="text" name="garantia" value="{{ old('garantia') }}" placeholder="Ej. 12 meses contra defectos de fabricación o fallas de montaje..." class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm focus:border-fuchsia-500 transition-all">
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="mb-2 pb-2 border-b border-white/5">
                    <h3 class="text-xs font-black tracking-wider text-slate-400 uppercase">7. FORMA DE PAGO</h3>
                </div>
                <input type="text" name="forma_pago" value="{{ old('forma_pago') }}" placeholder="Ej. Crédito a 30 días contra entrega de factura comercial..." class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm font-bold text-fuchsia-400 focus:border-fuchsia-500 transition-all">
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="mb-2 pb-2 border-b border-white/5">
                    <h3 class="text-xs font-black tracking-wider text-slate-400 uppercase">8. VALIDEZ DE LA OFERTA</h3>
                </div>
                <input type="text" name="validez_oferta" value="{{ old('validez_oferta') }}" placeholder="Ej. 30 días calendario a partir de la fecha del presente documento..." class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm focus:border-fuchsia-500 transition-all">
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl shadow-xl">
                <div class="mb-4 border-b border-white/5 pb-2">
                    <h3 class="text-xs font-black tracking-widest text-slate-400 uppercase">9. PANEL DE CIERRE Y AUTORIZACIÓN</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Cláusula de Despedida</label>
                            <textarea name="clausula_despedida" rows="2" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white text-sm resize-none outline-none focus:border-fuchsia-500 transition-all">{{ old('clausula_despedida', 'Esperando poder servirles de la mejor manera, me suscribo de ustedes. Atentamente,') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Responsable de la Propuesta / Firma</label>
                            <input type="text" name="nombre_firmante" value="{{ old('nombre_firmante', 'Ing. Wuilmar Velásquez') }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white text-sm font-bold outline-none focus:border-fuchsia-500 transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center p-5 rounded-2xl bg-slate-950/80 border border-white/10 text-center space-y-2 shadow-inner">
                        <span class="text-[9px] font-black tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2.5 py-0.5 rounded-full uppercase">
                            Sello Digital Técnico
                        </span>
                        
                        <div class="w-44 h-20 border border-dashed border-white/10 rounded-xl flex items-center justify-center bg-slate-900 p-2 shadow-inner">
                            <img src="{{ asset('images/firma_patrono.jpg') }}" 
                                alt="Firma Autorizada" 
                                class="max-h-full max-w-full object-contain filter brightness-110 contrast-125"
                                onerror="this.style.display='none'; document.getElementById('firma-placeholder').style.display='block';">
                            
                            <div id="firma-placeholder" class="hidden text-slate-600">
                                <span class="text-[9px] uppercase tracking-wider block font-black">PROSERVE DIGITAL</span>
                            </div>
                        </div>

                        <div class="text-[9px] text-slate-500 bg-slate-900 px-3 py-1 rounded border border-white/5 font-mono">
                            SEC-ID: PROSERVE-VALID-2026
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-fuchsia-600 to-indigo-600 hover:from-fuchsia-500 hover:to-indigo-500 text-white font-bold py-4 rounded-2xl shadow-xl uppercase tracking-wider text-xs transition-all">
                Procesar y Registrar Cotización Única
            </button>
        </form>
    </div>
</div>

<script>
    let itemIndex = 0;
    let detalleIndex = 0;
    let contadorServicio = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el formulario con un ítem vacío listo para rellenar
        agregarItem();

        // Manejador del cambio de cliente para actualizar los campos espejo inmediatamente
        const clienteSelect = document.getElementById('cliente_select');
        
        function actualizarVistaCliente() {
            const opt = clienteSelect.options[clienteSelect.selectedIndex];
            document.getElementById('cliente_nombre_view').value = opt && opt.value !== "" ? opt.getAttribute('data-empresa') : '';
            document.getElementById('cliente_nit_view').value = opt && opt.value !== "" ? opt.getAttribute('data-nit') : '';
            document.getElementById('cliente_direccion_view').value = opt && opt.value !== "" ? opt.getAttribute('data-direccion') : '';
        }

        clienteSelect.addEventListener('change', actualizarVistaCliente);
        actualizarVistaCliente(); // Sincroniza al cargar si quedó un old() seleccionado
    });

    function agregarItem() {
        const html = `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 bg-white/[0.01] md:bg-transparent p-4 md:p-0 rounded-2xl border border-white/5 md:border-none item-row items-center" id="row_${itemIndex}">
                <div class="md:col-span-1">
                    <input type="number" name="items[${itemIndex}][cantidad]" value="1" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white font-mono text-sm text-center input-cantidad" min="1" required oninput="calcularFila(${itemIndex})">
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="items[${itemIndex}][unidad_medida]" placeholder="Ej. Servicio" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white text-xs" required>
                </div>
                <div class="md:col-span-5">
                    <input type="text" name="items[${itemIndex}][descripcion]" placeholder="Escribe el concepto técnico..." class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white text-xs" required>
                </div>
                <div class="md:col-span-2">
                    <input type="number" name="items[${itemIndex}][precio_unitario]" placeholder="0.00" step="0.01" min="0" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white font-mono text-sm input-precio" required oninput="calcularFila(${itemIndex})">
                </div>
                <div class="md:col-span-2 flex items-center justify-between md:justify-end gap-4">
                    <span class="font-mono text-xs text-slate-300 font-bold span-total-fila">Q0.00</span>
                    <input type="hidden" class="input-total-fila" name="items[${itemIndex}][total]" value="0.00">
                    <button type="button" onclick="eliminarFila(${itemIndex})" class="p-2 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 transition-all font-sans font-bold text-xs">✕</button>
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
            alert('El formulario requiere procesar al menos un ítem monetario.');
        }
    }

    function calcularFila(idx) {
        const row = document.getElementById(`row_${idx}`);
        if(!row) return;
        const cant = parseFloat(row.querySelector('.input-cantidad').value) || 0;
        const precio = parseFloat(row.querySelector('.input-precio').value) || 0;
        const total = cant * precio;
        row.querySelector('.span-total-fila').innerText = 'Q ' + total.toLocaleString('es-GT', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        row.querySelector('.input-total-fila').value = total.toFixed(2);
        calcularTotalesGlobales();
    }

    function calcularTotalesGlobales() {
        let subtotal = 0;
        document.querySelectorAll('.input-total-fila').forEach(i => {
            subtotal += parseFloat(i.value) || 0;
        });

        document.getElementById('subtotal').innerText = 'Q ' + subtotal.toLocaleString('es-GT', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('total').innerText = 'Q ' + subtotal.toLocaleString('es-GT', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        
        document.getElementById('input_subtotal').value = subtotal.toFixed(2);
        document.getElementById('input_total').value = subtotal.toFixed(2);

        if (subtotal > 0) {
            document.getElementById('input_total_letras').value = numeroALetras(subtotal);
        } else {
            document.getElementById('input_total_letras').value = '';
        }
    }

    function agregarDetail(tipo) {
        const container = document.getElementById('detalles-container');
        if (tipo === 'servicio') {
            contadorServicio++;
            const letra = obtenerLetra(contadorServicio);
            const html = `
                <div class="detalle-item bg-white/[0.03] border border-white/10 p-4 rounded-xl">
                    <input type="hidden" name="detalles[${detalleIndex}][tipo]" value="servicio">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-indigo-400 font-bold text-xs uppercase tracking-wider">SERVICIO ${letra})</span>
                        <button type="button" onclick="this.closest('.detalle-item').remove(); recalcularServicio();" class="text-rose-400 hover:underline text-xs font-bold">Eliminar</button>
                    </div>
                    <textarea name="detalles[${detalleIndex}][descripcion]" class="w-full bg-slate-950/40 border border-white/10 p-3 rounded-xl text-white text-xs outline-none focus:border-fuchsia-500" rows="2" placeholder="Especificar alcance técnico detallado..." required></textarea>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            detalleIndex++;
        } else {
            const html = `
                <div class="detalle-item bg-white/[0.03] border border-white/10 p-4 rounded-xl">
                    <input type="hidden" name="detalles[${detalleIndex}][tipo]" value="material">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-emerald-400 font-bold text-xs uppercase tracking-wider">MATERIAL COMPLEMENTARIO</span>
                        <button type="button" onclick="this.closest('.detalle-item').remove()" class="text-rose-400 hover:underline text-xs font-bold">Eliminar</button>
                    </div>
                    <textarea name="detalles[${detalleIndex}][descripcion]" class="w-full bg-slate-950/40 border border-white/10 p-3 rounded-xl text-white text-xs outline-none focus:border-emerald-500" rows="2" placeholder="Especificar marcas, repuestos y materiales a usar..." required></textarea>
                </div>`;
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
                el.querySelector('span').innerText = `SERVICIO ${obtenerLetra(contadorServicio)})`;
            }
        });
    }

    function numeroALetras(numero) {
        numero = parseFloat(numero).toFixed(2);
        let partes = numero.split('.');
        let entero = parseInt(partes[0]);
        let decimales = partes[1];

        const unidades = ['', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        const especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
        const decenas = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        const centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

        function convertirMenor100(n) {
            if (n < 10) return unidades[n];
            if (n >= 10 && n < 20) return especiales[n - 10];
            if (n >= 20 && n < 30) return n === 20 ? 'VEINTE' : 'VEINTI' + unidades[n - 20].toLowerCase();
            let d = Math.floor(n / 10); let u = n % 10;
            return u === 0 ? decenas[d] : decenas[d] + ' Y ' + unidades[u];
        }

        function convertirMenor1000(n) {
            if (n === 100) return 'CIEN';
            let c = Math.floor(n / 100); let resto = n % 100;
            let texto = c > 0 ? centenas[c] + ' ' : '';
            if (resto > 0) texto += convertirMenor100(resto);
            return texto.trim();
        }

        function convertirNumero(n) {
            if (n === 0) return 'CERO';
            if (n < 1000) return convertirMenor1000(n);
            if (n < 1000000) {
                let miles = Math.floor(n / 1000); let resto = n % 1000;
                let textoMiles = miles === 1 ? 'MIL' : convertirMenor1000(miles) + ' MIL';
                if (resto > 0) textoMiles += ' ' + convertirMenor1000(resto);
                return textoMiles;
            }
            return n;
        }

        let letras = convertirNumero(entero);
        return `${letras} QUETZALES CON ${decimales}/100`;
    }
</script>
@endsection
