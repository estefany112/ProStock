@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">
        
        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                ✏️ Editar Producto
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Actualizar información del producto – PROSERVE
            </p>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('productos.update', $producto) }}"
              method="POST"
              class="space-y-6 max-w-4xl">
            @csrf
            @method('PUT')

            {{-- CÓDIGO --}}
            <div>
                <label class="block font-medium">Código</label>
                <input type="text"
                       name="codigo"
                       value="{{ $producto->codigo }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            {{-- DESCRIPCIÓN --}}
            <div>
                <label class="block font-medium">Nombre del artículo</label>
                <input type="text"
                       name="descripcion"
                       value="{{ $producto->descripcion }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            {{-- CATEGORÍA --}}
            <div>
                <label class="block font-medium">Categoría</label>
                <select name="categoria_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            @selected($producto->categoria_id == $categoria->id)>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- MARCA --}}
            <div>
                <label class="block font-medium">Marca</label>
                <input type="text"
                       name="marca"
                       value="{{ $producto->marca }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            {{-- UNIDAD --}}
            <div>
                <label class="block font-medium">Unidad de medida</label>
                <input type="text"
                       name="unidad_medida"
                       value="{{ $producto->unidad_medida }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            {{-- STOCK --}}
            <div>
                <label class="block font-medium">Stock Actual</label>
                <input type="number"
                       name="stock_actual"
                       value="{{ $producto->stock_actual }}"
                       readonly
                       class="w-full border rounded-lg px-3 py-2 bg-gray-100">
            </div>

            {{-- PRECIO --}}
            @php
                $puedeEditarPrecio = auth()->user()->hasAnyRole(['admin','compras']);
                $puedeVerPrecio = auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor']);
            @endphp

            <div>
                <label class="block font-medium">Precio Unitario</label>

                @if($puedeEditarPrecio)
                    <input type="number"
                           step="0.01"
                           name="precio_unitario"
                           value="{{ $producto->precio_unitario }}"
                           class="w-full border rounded-lg px-3 py-2"
                           required>
                @elseif($producto->precio_unitario == 0)
                    <input type="text"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 italic"
                           value="Sin precio"
                           readonly>
                @elseif($puedeVerPrecio)
                    <input type="text"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                           value="Q {{ number_format($producto->precio_unitario,2) }}"
                           readonly>
                @else
                    <input type="text"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 italic"
                           value="Sin precio"
                           readonly>
                @endif
            </div>

            {{-- UBICACIÓN --}}
            <div class="space-y-3">
                <label class="block font-semibold text-lg">Ubicación (FCN)</label>

                {{-- FILA --}}
                <div>
                    <label class="font-medium">Fila</label>
                    <select id="fila_id" name="fila_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">No tiene ubicación</option>
                        @foreach($filas as $fila)
                            <option value="{{ $fila->id }}"
                                @selected($producto->fila_id == $fila->id)>
                                {{ $fila->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- COLUMNA --}}
                <div>
                    <label class="font-medium">Columna</label>
                    <select id="columna_id" name="columna_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">No tiene ubicación</option>
                        @foreach($columnas as $col)
                            <option value="{{ $col->id }}"
                                @selected($producto->columna_id == $col->id)>
                                {{ $col->numero }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NIVEL --}}
                <div>
                    <label class="font-medium">Nivel</label>
                    <select id="nivel_id" name="nivel_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">No tiene ubicación</option>
                        @foreach($niveles as $niv)
                            <option value="{{ $niv->id }}"
                                @selected($producto->nivel_id == $niv->id)>
                                {{ $niv->numero }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <p class="text-sm text-gray-700">
                    Vista previa:
                    <strong id="ubic_preview">{{ $producto->ubicacion }}</strong>
                </p>

                <input type="hidden"
                       name="ubicacion"
                       id="ubicacion_hidden"
                       value="{{ $producto->ubicacion }}">
            </div>

            {{-- BOTONES --}}
            <div class="flex gap-4 pt-4">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg
                               hover:bg-blue-700 transition">
                    Actualizar Producto
                </button>

                <a href="{{ route('productos.index') }}"
                   class="text-gray-600 hover:underline self-center">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
