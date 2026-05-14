@extends('layouts.principal')

@section('content')
<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md border border-slate-200">
        <h1 class="text-2xl font-bold mb-6">📥 Registrar Entrada</h1>

        <form action="{{ route('entradas.store') }}" method="POST">
            @csrf

            <div class="bg-slate-50 p-6 rounded-xl mb-6 border">
                <!-- BUSCADOR -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">1. Buscar Producto</label>
                    <input type="text" id="input_buscar" 
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" 
                           placeholder="Escribe el nombre o código..." autocomplete="off">
                    <span id="mensaje_estado" class="text-xs text-blue-600 mt-1 block font-bold"></span>
                </div>

                <!-- SELECT DINÁMICO -->
                <div>
                    <label class="block text-sm font-bold mb-2">2. Seleccionar Resultado</label>
                    <select name="producto_id" id="producto_select" required 
                            class="w-full p-3 border rounded-lg bg-white">
                        <option value="">Esperando búsqueda...</option>
                    </select>
                </div>
            </div>

            <!-- CANTIDAD Y MOTIVO -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-bold mb-2">Cantidad</label>
                    <input type="number" name="cantidad" min="1" required class="w-full p-3 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Motivo</label>
                    <input type="text" name="motivo" required class="w-full p-3 border rounded-lg" placeholder="Ej: Factura #123">
                </div>
            </div>

            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-lg hover:bg-emerald-700">
                Guardar Entrada
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('input_buscar');
        const select = document.getElementById('producto_select');
        let timer = null;

        if (!input || !select) {
            alert("Error: No se encontraron los elementos en el HTML. Revisa los IDs.");
            return;
        }

        input.addEventListener('input', function() {
            clearTimeout(timer);
            const query = this.value.trim();

            if (query.length < 2) {
                select.innerHTML = '<option value="">Esperando búsqueda...</option>';
                return;
            }

            timer = setTimeout(() => {
                // Forzamos la URL absoluta con el puerto actual
                const host = window.location.origin; 
                const url = host + "/productos/buscar?search=" + encodeURIComponent(query);
                
                console.log("Intentando conectar a:", url);

                fetch(url, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value // Añadimos esto
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Servidor respondió con error " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Datos recibidos con éxito:", data);
                    select.innerHTML = '';

                    if (data.length === 0) {
                        select.innerHTML = '<option value="">❌ Sin resultados</option>';
                    } else {
                        let headerOpt = document.createElement('option');
                        headerOpt.text = "✅ Se encontraron " + data.length + " productos. Seleccione uno:";
                        headerOpt.value = "";
                        select.appendChild(headerOpt);

                        data.forEach(p => {
                            let opt = document.createElement('option');
                            opt.value = p.id;
                            opt.text = p.descripcion.toUpperCase() + " (Stock: " + p.stock_actual + ")";
                            select.appendChild(opt);
                        });
                        
                        select.size = data.length + 1;
                    }
                })
                .catch(err => {
                    console.error("Error en Fetch:", err);
                    alert("Error al buscar: " + err.message);
                });
            }, 500);
        });

        select.addEventListener('change', function() { this.size = 0; });
    });
</script>

@endsection