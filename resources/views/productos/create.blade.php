@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">

        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                ➕ Crear Producto
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Registro de nuevo producto – PROSERVE
            </p>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('productos.store') }}" method="POST" class="space-y-6 max-w-4xl" enctype="multipart/form-data">
            @csrf

            {{-- CÓDIGO --}}
            <div>
                <label class="block font-medium">Código</label>
                <input type="text" name="codigo"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            {{-- DESCRIPCIÓN --}}
            <div>
                <label class="block font-medium">Nombre del artículo</label>
                <input type="text" name="descripcion"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            {{-- IMAGEN --}}
            <div>
                <label class="block font-medium">Imagen del producto</label>
                <input type="file"
                    name="image"
                    accept="image/*"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- CATEGORÍA --}}
            <div>
                <label class="block font-medium">Categoría</label>
                <select name="categoria_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- MARCA --}}
            <div>
                <label class="block font-medium">Marca</label>
                <input type="text" name="marca"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            {{-- UNIDAD --}}
            <div>
                <label class="block font-medium">Unidad de medida</label>
                <input type="text" name="unidad_medida"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            {{-- STOCK --}}
            <div>
                <label class="block font-medium">Stock Actual</label>
                <input type="number" name="stock_actual"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            {{-- PRECIO --}}
            @php
                $puedeEditarPrecio = auth()->user()->hasAnyRole(['admin','compras']);
            @endphp

            @if($puedeEditarPrecio)
                <div>
                    <label class="block font-medium">Precio Unitario</label>
                    <input type="number" step="0.01" name="precio_unitario"
                           class="w-full border rounded-lg px-3 py-2">
                </div>
            @endif

            {{-- UBICACIÓN --}}
            <div class="space-y-3">
                <label class="block font-semibold text-lg">Ubicación (FCN)</label>

                {{-- FILA --}}
                <div>
                    <label class="font-medium">Fila</label>
                    <div class="flex gap-2">
                        <select id="fila_id" name="fila_id"
                                class="border rounded-lg px-3 py-2 flex-1">
                            <option value="">No tiene ubicación</option>
                            @foreach($filas as $fila)
                                <option value="{{ $fila->id }}">{{ $fila->nombre }}</option>
                            @endforeach
                        </select>

                        <button type="button" onclick="openModal('modalFila')"
                                class="px-4 bg-green-600 text-white rounded-lg">+</button>
                    </div>
                </div>

                {{-- COLUMNA --}}
                <div>
                    <label class="font-medium">Columna</label>
                    <div class="flex gap-2">
                        <select id="columna_id" name="columna_id"
                                class="border rounded-lg px-3 py-2 flex-1">
                            <option value="">No tiene ubicación</option>
                            @foreach($columnas as $col)
                                <option value="{{ $col->id }}">{{ $col->numero }}</option>
                            @endforeach
                        </select>

                        <button type="button" onclick="openModal('modalColumna')"
                                class="px-4 bg-green-600 text-white rounded-lg">+</button>
                    </div>
                </div>

                {{-- NIVEL --}}
                <div>
                    <label class="font-medium">Nivel</label>
                    <div class="flex gap-2">
                        <select id="nivel_id" name="nivel_id"
                                class="border rounded-lg px-3 py-2 flex-1">
                            <option value="">No tiene ubicación</option>
                            @foreach($niveles as $niv)
                                <option value="{{ $niv->id }}">{{ $niv->numero }}</option>
                            @endforeach
                        </select>

                        <button type="button" onclick="openModal('modalNivel')"
                                class="px-4 bg-green-600 text-white rounded-lg">+</button>
                    </div>
                </div>

                <p class="text-sm text-gray-700">
                    Vista previa:
                    <strong id="ubic_preview"></strong>
                </p>

                <input type="hidden" name="ubicacion" id="ubicacion_hidden">
            </div>

            {{-- BOTONES --}}
            <div class="flex gap-4 pt-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-lg">
                    Crear Producto
                </button>

                <a href="{{ route('productos.index') }}"
                   class="text-gray-600 hover:underline self-center">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

{{-- MODAL FILA --}}
<div id="modalFila" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-96">
        <h3 class="text-lg font-semibold mb-4">Crear Fila</h3>
        <form action="{{ route('filas.store') }}" method="POST">
            @csrf
            <input type="text" name="nombre"
                   class="w-full border rounded-lg px-3 py-2 mb-4"
                   placeholder="Nombre de la fila">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalFila')">Cancelar</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL COLUMNA --}}
<div id="modalColumna" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-96">
        <h3 class="text-lg font-semibold mb-4">Crear Columna</h3>
        <form action="{{ route('columnas.store') }}" method="POST">
            @csrf
            <input type="text" name="numero"
                   class="w-full border rounded-lg px-3 py-2 mb-4"
                   placeholder="Número de la columna">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalColumna')">Cancelar</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL NIVEL --}}
<div id="modalNivel" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-96">
        <h3 class="text-lg font-semibold mb-4">Crear Nivel</h3>
        <form action="{{ route('niveles.store') }}" method="POST">
            @csrf
            <input type="text" name="numero"
                   class="w-full border rounded-lg px-3 py-2 mb-4"
                   placeholder="Número del nivel">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalNivel')">Cancelar</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('flex');
}

const filaSel = document.getElementById('fila_id');
const colSel  = document.getElementById('columna_id');
const nivSel  = document.getElementById('nivel_id');

function updateUbic() {
    const fila = filaSel?.selectedOptions[0]?.text || "";
    const col  = colSel?.selectedOptions[0]?.text || "";
    const niv  = nivSel?.selectedOptions[0]?.text || "";

    if (fila && col && niv) {
        const ubic = fila + col + niv;
        document.getElementById('ubic_preview').textContent = ubic;
        document.getElementById('ubicacion_hidden').value = ubic;
    }
}

filaSel.onchange = updateUbic;
colSel.onchange  = updateUbic;
nivSel.onchange  = updateUbic;
</script>

@endsection
