<x-app-layout>
    <div class="py-8 max-w-6xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border">

           {{-- HEADER DE LA VISTA --}}
            <div class="mb-6">

                {{-- FILA SUPERIOR: TÍTULO + INVENTARIO --}}
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        📁 Entradas
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
                    Gestión de entradas de productos – PROSERVE
                </p>
              
                {{-- ACCIÓN PRINCIPAL --}}
                <div class="mt-4">
                    <a href="{{ route('entradas.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-green-700 transition">
                        ➕ Nueva entrada
                    </a>
                </div>

            </div>

            <!-- Mostrar mensaje de éxito si existe -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabla de entradas -->
            <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2">Producto</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Fecha de Entrada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($entradas as $entrada)
                    <tr class="text-center border-t">
                        <td>
                            {{ $entrada->producto->descripcion }}<br>
                            <span class="text-gray-500 text-sm">
                                {{ $entrada->producto->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td>{{ $entrada->cantidad }}</td>
                        <td>{{ $entrada->motivo }}</td>
                        <td>{{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('d-m-Y H:i') }}</td> 
                        <td>
                            <a href="{{ route('entradas.edit', $entrada->id) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500">
                                    No hay entradas registradas aún.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            </div>
                <div class="mt-6 flex justify-center">
                    {{ $entradas->links() }}
                </div>
                <div class="mt-6 flex justify-between">
                   <a href="{{ route('productos.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition">
                        <- Anterior
                    </a>

                    <a href="{{ route('salidas.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition">
                        -> Siguiente
                    </a>
                </div>
        </div>
    </div>

    <script>
        // Función personalizada para mostrar la confirmación antes de eliminar usando SweetAlert2
        function confirmDelete(event) {
            event.preventDefault(); // Evita que el formulario se envíe de inmediato

            // Mostrar la alerta de confirmación usando SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviamos el formulario
                    event.target.submit();
                }
            });
        }
    </script>
</x-app-layout>
