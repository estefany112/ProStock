<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto – Proserve S.A.
        </h2>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto">
        <div class="bg-white p-8 rounded-xl shadow-md">

            <form action="{{ route('productos.update', $producto) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium">Código</label>
                    <input type="text" name="codigo" value="{{ $producto->codigo }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-medium">Nombre del artículo</label>
                    <input type="text" name="descripcion" value="{{ $producto->descripcion }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>

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

                <div>
                    <label class="block font-medium">Marca</label>
                    <input type="text" name="marca" value="{{ $producto->marca }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-medium">Unidad de medida</label>
                    <input type="text" name="unidad_medida" value="{{ $producto->unidad_medida }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-medium">Stock Actual</label>
                    <input type="number" name="stock_actual" value="{{ $producto->stock_actual }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-medium">Precio Unitario</label>
                    <input type="number" step="0.01" name="precio_unitario" value="{{ $producto->precio_unitario }}" class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
                    Actualizar Producto
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
