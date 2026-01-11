<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle Producto - Proserve') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">{{ $producto->descripcion }}</h3>
            <p><strong>Código:</strong> {{ $producto->codigo }}</p>
            <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
            <p><strong>Precio Unitario:</strong> Q{{ number_format($producto->precio_unitario, 2) }}</p>
            <p><strong>Stock Actual:</strong> {{ $producto->stock_actual }}</p>
        </div>
    </div>
</x-app-layout>
