<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto - Proserve S.A.') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="codigo" class="block">Código</label>
                        <input type="text" name="codigo" id="codigo" class="mt-1 block w-full" value="{{ $producto->codigo }}" required>
                    </div>

                    <div>
                        <label for="descripcion" class="block">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="mt-1 block w-full" value="{{ $producto->descripcion }}" required>
                    </div>

                    <div>
                        <label for="precio_unitario" class="block">Precio Unitario</label>
                        <input type="number" name="precio_unitario" id="precio_unitario" class="mt-1 block w-full" value="{{ $producto->precio_unitario }}" required step="0.01">
                    </div>

                    <div>
                        <label for="stock_actual" class="block">Stock Actual</label>
                        <input type="number" name="stock_actual" id="stock_actual" class="mt-1 block w-full" value="{{ $producto->stock_actual }}" required>
                    </div>

                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg">Actualizar Producto</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
