<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">
            Editar Salida
        </h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <form method="POST" action="{{ route('salidas.update', $salida->id) }}">
                @csrf
                @method('PUT')

                <label class="block mb-2">Producto</label>
                <input type="text" class="border rounded p-2 w-full bg-gray-100" 
                       value="{{ $salida->producto->descripcion }}" disabled>

                <label class="block mt-3">Cantidad</label>
                <input type="number" min="1" name="cantidad"
                       class="border rounded p-2 w-full"
                       value="{{ $salida->cantidad }}" required>

                <label class="block mt-3">Motivo</label>
                <input type="text" name="motivo"
                       class="border rounded p-2 w-full"
                       value="{{ $salida->motivo }}" required>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">
                    Actualizar salida
                </button>

                <a href="{{ route('salidas.index') }}" class="text-gray-600 ml-2">Cancelar</a>

            </form>

        </div>
    </div>
</x-app-layout>
