@extends('layouts.principal')

@section('content')
<div class="min-h-screen bg-mesh py-12 px-6">
    <div class="max-w-6xl mx-auto">
        
        <header class="flex justify-between items-center mb-8">
            <div>
                <span class="px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2 inline-block">
                    Modificación de Registro
                </span>
                <h1 class="text-3xl font-black text-white tracking-tighter">Editar Cotización {{ $cotizacion->folio }}</h1>
            </div>
            <a href="{{ route('cotizaciones.index') }}" class="bg-white/5 text-slate-300 hover:bg-white/10 px-4 py-2 rounded-xl text-xs font-bold border border-white/10 transition-all">
                ✕ Cancelar Cambios
            </a>
        </header>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-medium">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST" id="cotizacionForm">
            @csrf
            @method('PUT')

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 mb-6 backdrop-blur-xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Contacto o Cliente *</label>
                        <select id="cliente_select" name="cliente_id" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none focus:border-fuchsia-500" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $cotizacion->cliente_id == $cliente->id ? 'selected' : '' }}
                                        data-tipo="{{ $cliente->tipo_cliente }}"
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
                        <input type="date" name="fecha_emision" value="{{ $cotizacion->fecha_emision }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white font-mono outline-none shadow-inner" required>
                    </div>
                    <div id="contenedor_nog" style="display:none;">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">
                            NOG
                        </label>

                        <input
                            type="text"
                            name="nog"
                            id="nog"
                            value="{{ old('nog', $cotizacion->nog) }}"
                            class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm"
                        >
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 mb-6 backdrop-blur-xl">
                <div class="flex justify-between items-center mb-6 border-b border-white/5 pb-3">
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

                <div id="items-container" class="space-y-4 mb-6"></div>

                <div class="border-t border-white/5 pt-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                    <div class="md:col-span-7">
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Total en Letras</label>
                        <input type="text" name="total_letras" id="input_total_letras" value="{{ $cotizacion->total_letras }}" readonly
                               class="w-full bg-white/[0.02] border border-white/5 p-3.5 rounded-xl text-slate-400 outline-none text-sm font-medium select-none">
                    </div>

                    <div class="md:col-span-5 bg-slate-950/80 border border-white/10 p-5 rounded-2xl space-y-3 shadow-2xl">
                        <input type="hidden" name="subtotal" id="input_subtotal" value="{{ $cotizacion->subtotal }}">
                        <input type="hidden" name="total" id="input_total" value="{{ $cotizacion->total }}">

                        <div class="flex justify-between text-xs font-medium text-slate-400">
                            <span>Subtotal:</span>
                            <span id="subtotal" class="font-mono text-slate-200">Q0.00</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-2 border-t border-white/10">
                            <span class="text-xs font-black uppercase text-slate-300">TOTAL Q:</span>
                            <span id="total" class="text-2xl font-black font-mono text-fuchsia-400">Q0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 mb-6 backdrop-blur-xl">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white tracking-tight">3. DETALLE DEL SERVICIO / MATERIAL</h3>
                    <div class="flex gap-2">
                        <button type="button" onclick="agregarDetail('servicio')" class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl text-xs font-bold text-white uppercase tracking-wider transition-all">
                            + Servicio
                        </button>
                        <button type="button" onclick="agregarDetail('material')" class="bg-emerald-600 hover:bg-emerald-500 px-4 py-2 rounded-xl text-xs font-bold text-white uppercase tracking-wider transition-all">
                            + Material
                        </button>
                    </div>
                </div>
                <div id="detalles-container" class="space-y-3"></div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 mb-6 space-y-5 backdrop-blur-xl">
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">4. LUGAR DE ENTREGA</label>
                    <input type="text" name="lugar_entrega" value="{{ $cotizacion->lugar_entrega }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">5. TIEMPO DE ENTREGA</label>
                    <input type="text" name="tiempo_entrega" value="{{ $cotizacion->tiempo_entrega }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">6. GARANTÍA</label>
                    <input type="text" name="garantia" value="{{ $cotizacion->garantia }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">7. FORMA DE PAGO</label>
                    <input type="text" name="forma_pago" value="{{ $cotizacion->forma_pago }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm font-bold text-fuchsia-400">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">8. VALIDEZ DE LA OFERTA</label>
                    <input type="text" name="validez_oferta" value="{{ $cotizacion->validez_oferta }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white outline-none text-sm">
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 mb-6 backdrop-blur-xl">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">9. PANEL DE CIERRE Y AUTORIZACIÓN</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Cláusula de Despedida</label>
                        <textarea name="clausula_despedida" rows="2" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white text-sm resize-none outline-none">{{ $cotizacion->clausula_despedida }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Responsable de la Propuesta / Firma</label>
                        <input type="text" name="nombre_firmante" value="{{ $cotizacion->nombre_firmante }}" class="w-full bg-slate-950/60 border border-white/10 p-3.5 rounded-xl text-white text-sm font-bold outline-none">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-fuchsia-600 to-indigo-600 hover:from-fuchsia-500 hover:to-indigo-500 text-white font-bold py-4 rounded-2xl shadow-xl uppercase tracking-wider text-sm transition-all">
                Guardar Cambios y Actualizar Registro
            </button>
        </form>
    </div>
</div>

<script>
    let itemIndex = {{ $itemsComerciales->count() }};
    let detalleIndex = {{ $detallesTecnicos->count() }};
    let contadorServicio = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inyectar ítems comerciales guardados desde la BD
        validarNOG();
        document.getElementById('cliente_select').addEventListener('change', validarNOG);
        detalleIndex = 0;
        contadorServicio = 0;

        @foreach($itemsComerciales as $it)
            inyectarItem(
                {{ $it->cantidad }},
                @json($it->unidad_medida),
                @json($it->descripcion),
                {{ $it->precio_unitario }}
            );
        @endforeach

        if(itemIndex === 0) agregarItem();

        // 2. Inyectar especificaciones técnicas guardadas
        @foreach($detallesTecnicos as $dt)
            inyectarDetalle(
                "{{ $dt->tipo }}",
                `{!! addslashes($dt->descripcion) !!}`
            );
        @endforeach

        calcularTotalesGlobales();

        document.getElementById('cliente_select').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            // Si tuvieras campos de lectura los actualiza aquí
        });
    });

    function agregarItem() {
        inyectarItem(1, '', '', '');
    }

    function inyectarItem(cant, um, desc, precio) {
        const html = `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 bg-white/[0.01] md:bg-transparent p-4 md:p-0 rounded-2xl border border-white/5 md:border-none item-row" id="row_${itemIndex}">
                <div class="md:col-span-1">
                    <input type="number" name="items[${itemIndex}][cantidad]" value="${cant}" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white font-mono text-sm text-center input-cantidad" min="1" required oninput="calcularFila(${itemIndex})">
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="items[${itemIndex}][unidad_medida]" value="${um}" placeholder="Ej. Servicio" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white text-sm" required>
                </div>
                <div class="md:col-span-5">
                    <input type="text" name="items[${itemIndex}][descripcion]" value="${desc}" placeholder="Escribe el concepto..." class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white text-sm" required>
                </div>
                <div class="md:col-span-2">
                    <input type="number" name="items[${itemIndex}][precio_unitario]" value="${precio}" placeholder="0.00" step="0.01" min="0" class="w-full bg-slate-950/40 border border-white/10 p-2.5 rounded-xl text-white font-mono text-sm input-precio" required oninput="calcularFila(${itemIndex})">
                </div>
                <div class="md:col-span-2 flex items-center justify-between md:justify-end gap-4">
                    <span class="font-mono text-sm text-slate-300 font-bold span-total-fila">Q0.00</span>
                    <input type="hidden" class="input-total-fila" name="items[${itemIndex}][total]" value="0.00">
                    <button type="button" onclick="eliminarFila(${itemIndex})" class="p-2.5 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 transition-all font-sans font-bold">✕</button>
                </div>
            </div>`;
        document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
        calcularFila(itemIndex);
        itemIndex++;
    }

    function eliminarFila(idx) {
        if(document.querySelectorAll('.item-row').length > 1) {
            document.getElementById(`row_${idx}`).remove();
            calcularTotalesGlobales();
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
        inyectarDetalle(tipo, '');
    }

    function inyectarDetalle(tipo, desc) {
        const container = document.getElementById('detalles-container');
        
        // Usamos un template literal para asegurar que el índice sea único y no se sobreescriba
        const html = `
            <div class="detalle-item bg-white/[0.03] border border-white/10 p-4 rounded-xl mb-4">
                <input type="hidden" name="detalles[${detalleIndex}][tipo]" value="${tipo}">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-${tipo === 'servicio' ? 'indigo' : 'emerald'}-400 font-bold text-xs uppercase">
                        ${tipo === 'servicio' ? 'SERVICIO' : 'MATERIAL'}
                    </span>
                    <button type="button" onclick="this.closest('.detalle-item').remove(); recalcularServicio();" class="text-red-400 text-xs font-bold">Eliminar</button>
                </div>
                <textarea name="detalles[${detalleIndex}][descripcion]" class="w-full bg-slate-950/40 border border-white/10 p-3 rounded-xl text-white text-sm" rows="2" required>${desc}</textarea>
            </div>`;
        
        container.insertAdjacentHTML('beforeend', html);
        detalleIndex++; // Asegúrate de que este contador siempre aumente
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

    function validarNOG() {

    const select = document.getElementById('cliente_select');
    const tipo = select.options[select.selectedIndex].dataset.tipo;

    const contenedor = document.getElementById('contenedor_nog');
    const campoNog = document.getElementById('nog');

    if (
        tipo === 'Empresa Pública' ||
        tipo === 'Estatal'
    ) {
        contenedor.style.display = 'block';
        campoNog.required = true;
    } else {
        contenedor.style.display = 'none';
        campoNog.required = false;
    }
}

</script>
@endsection