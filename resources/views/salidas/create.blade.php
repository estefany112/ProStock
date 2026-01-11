<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Registrar Salida
        </h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <form method="POST" action="{{ route('salidas.store') }}">
                @csrf

                <label class="block">Producto</label>
                <select name="producto_id" class="border rounded p-2 w-full mb-3" required>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->descripcion }} (Stock: {{ $p->stock_actual }})
                        </option>
                    @endforeach
                </select>

                <label class="block">Cantidad</label>
                <input type="number" min="1" name="cantidad" class="border rounded p-2 w-full mb-3" required>

                <label class="block">Motivo</label>
                <input type="text" name="motivo" class="border rounded p-2 w-full mb-3" required>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Registrar salida
                </button>

                <a href="{{ route('salidas.index') }}" class="text-gray-600 ml-2">Cancelar</a>

            </form>

        </div>
    </div>
</x-app-layout>
