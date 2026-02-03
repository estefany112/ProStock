<x-app-layout>
<div class="py-8 max-w-6xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border">

           {{-- HEADER DE LA VISTA --}}
            <div class="mb-6">

                {{-- FILA SUPERIOR: TÍTULO + INVENTARIO --}}
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        📁 Salidas
                    </h1>

                    {{-- INVENTARIO (alineado al título) --}}
                    <a href="{{ route('prostock.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition whitespace-nowrap">
                        📦 Menú Inventario
                    </a>

                </div>

                {{-- DESCRIPCIÓN --}}
                <p class="text-sm text-gray-500 mt-1">
                    Gestión de salidas de productos – PROSERVE
                </p>
              
                {{-- ACCIÓN PRINCIPAL --}}
                <div class="mt-4">
                    <a href="{{ route('salidas.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-green-700 transition">
                        ➕ Nueva salida
                    </a>
                </div>

            </div>

            <!-- Mostrar mensaje de éxito si existe -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mt-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <x-search-bar
                action="{{ route('salidas.index') }}"
                placeholder="Buscar por producto, motivo o ubicación..."
            />

            <div>
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
                <div class="mt-6 flex justify-center">
                    {{ $salidas->appends(request()->query())->links() }}
                </div>
                <div class="mt-6 flex justify-between">
                   <a href="{{ route('entradas.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition">
                        <- Anterior
                    </a>

                    <a href="{{ route('prostock.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition">
                        -> Siguiente
                    </a>
                </div>
        </div>
    </div>
</x-app-layout>
