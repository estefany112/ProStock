<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Producto – Proserve S.A.
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white p-8 rounded-xl shadow-md space-y-4">

            <p><strong>Código:</strong> {{ $producto->codigo }}</p>
            <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
            <p><strong>Marca:</strong> {{ $producto->marca }}</p>
            <p><strong>Unidad de medida:</strong> {{ $producto->unidad_medida }}</p>
            <p><strong>Stock actual:</strong> {{ $producto->stock_actual }}</p>
            <p>
                <strong>Precio unitario:</strong>

                @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor']))
                    @if($producto->precio_unitario > 0)
                        Q {{ number_format($producto->precio_unitario, 2) }}
                    @else
                        <span class="text-gray-500 italic">Sin precio</span>
                    @endif
                @else
                    <span class="text-gray-400 italic">No disponible</span>
                @endif
            </p>
            <p><strong>Ubicación:</strong> {{ $producto->ubicacion ?? 'No asignada' }}</p>

            <div class="pt-4">
                <a href="{{ route('productos.edit', $producto) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Editar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
