<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Salidas de Inventario
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <a href="{{ route('salidas.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nueva salida
            </a>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mt-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mt-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <table class="w-full mt-4 border text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Producto</th>
                        <th class="p-2 border">Categoría</th>
                        <th class="p-2 border">Cantidad</th>
                        <th class="p-2 border">Motivo</th>
                        <th class="p-2 border">Fecha</th>
                        <th class="p-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salidas as $salida)
                        <tr class="border-t">
                            <td class="p-2">{{ $salida->producto->descripcion }}</td>

                            <td class="p-2 text-gray-600">
                                {{ $salida->producto->categoria->nombre ?? 'Sin categoría' }}
                            </td>

                            <td class="p-2">{{ $salida->cantidad }}</td>
                            <td class="p-2">{{ $salida->motivo }}</td>
                            <td class="p-2">{{ $salida->fecha_salida }}</td>

                            <td class="p-2">
                                <a href="{{ route('salidas.edit', $salida->id) }}" class="text-blue-600 mr-2">
                                    Editar
                                </a>

                                <form action="{{ route('salidas.destroy', $salida->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Deseas eliminar esta salida?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($salidas->count() == 0)
                        <tr>
                            <td colspan="6" class="p-4 text-gray-600">No hay salidas registradas.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
