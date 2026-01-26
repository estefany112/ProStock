<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Entrada
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white p-8 rounded-xl shadow-md">

            <form action="{{ route('entradas.update', $entrada) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- PRODUCTO -->
                <div>
                    <label class="block font-medium">Producto</label>
                    <select name="producto_id" class="w-full border rounded-lg px-3 py-2" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}"
                                @selected($entrada->producto_id == $producto->id)>
                                {{ $producto->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- CANTIDAD -->
                <div>
                    <label class="block font-medium">Cantidad</label>
                    <input type="number"
                           name="cantidad"
                           value="{{ $entrada->cantidad }}"
                           min="1"
                           class="w-full border rounded-lg px-3 py-2"
                           required>
                </div>

                <!-- FECHA -->
                <div>
                    <label class="block font-medium">Fecha</label>
                    <input type="date"
                           name="fecha"
                           value="{{ $entrada->fecha }}"
                           class="w-full border rounded-lg px-3 py-2"
                           required>
                </div>

                <!-- OBSERVACIÓN -->
                <div>
                    <label class="block font-medium">Observación</label>
                    <textarea name="observacion"
                              class="w-full border rounded-lg px-3 py-2"
                              rows="3">{{ $entrada->observacion }}</textarea>
                </div>

                <!-- BOTÓN -->
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">
                    Actualizar Entrada
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
