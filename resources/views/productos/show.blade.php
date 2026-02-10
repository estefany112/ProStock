@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">

        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                📄 Detalle del Producto
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Información detallada del producto – PROSERVE
            </p>
        </div>

        {{-- DETALLE DEL PRODUCTO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <p>
                <strong>Código:</strong>
                {{ $producto->codigo }}
            </p>

            <p>
                <strong>Descripción:</strong>
                {{ $producto->descripcion }}
            </p>

            <p>
                <strong>Categoría:</strong>
                {{ $producto->categoria->nombre ?? 'Sin categoría' }}
            </p>

            <p>
                <strong>Marca:</strong>
                {{ $producto->marca }}
            </p>

            <p>
                <strong>Unidad de medida:</strong>
                {{ $producto->unidad_medida }}
            </p>

            <p>
                <strong>Stock actual:</strong>
                {{ $producto->stock_actual }}
            </p>

            <p>
                <strong>Precio unitario:</strong>
                @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor']))
                    @if($producto->precio_unitario > 0)
                        Q {{ number_format($producto->precio_unitario, 2) }}
                    @else
                        <span class="italic text-gray-500">Sin precio</span>
                    @endif
                @else
                    <span class="italic text-gray-400">No disponible</span>
                @endif
            </p>

            <p>
                <strong>Ubicación:</strong>
                {{ $producto->ubicacion ?? 'No asignada' }}
            </p>

        </div>

        {{-- ACCIONES --}}
        <div class="mt-8 flex gap-4">

            @if(auth()->user()->hasPermission('edit_products'))
                <a href="{{ route('productos.edit', $producto) }}"
                   class="bg-blue-600 text-white px-5 py-2 rounded-lg
                          hover:bg-blue-700 transition">
                    ✏️ Editar
                </a>
            @endif

            <a href="{{ route('productos.index') }}"
               class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg
                      hover:bg-gray-300 transition">
                ← Volver
            </a>

        </div>

    </div>
</div>

@endsection
