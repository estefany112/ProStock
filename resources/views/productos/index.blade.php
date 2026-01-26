<x-app-layout>

    <div class="py-8 max-w-6xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border">

           {{-- HEADER DE LA VISTA --}}
            <div class="mb-6">

                {{-- FILA SUPERIOR: TÍTULO + INVENTARIO --}}
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        📁 PRODUCTOS
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
                    Gestión de productos – PROSERVE
                </p>
              
                {{-- ACCIÓN PRINCIPAL --}}
                <div class="mt-4">
                    <a href="{{ route('productos.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-green-700 transition">
                        ➕ Nuevo producto
                    </a>
                </div>

            </div>

            <!-- Mostrar mensaje de éxito si existe -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mostrar mensaje de error si existe -->
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mt-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabla de productos -->
            <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Item</th>
                        <th class="p-2">Código</th>
                        <th>Nombre del artículo</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Unidad de medida</th>
                        <th>Stock</th>
                        <th>Precio unitario</th>
                        <th>Ubicación (FCN)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr class="text-center border-t">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td>{{ $producto->marca }}</td>
                        <td>{{ $producto->unidad_medida }}</td>
                        <td>{{ $producto->stock_actual }}</td>
                        <td>Q{{ number_format($producto->precio_unitario, 2) }}</td>
                        <td>
                            @if($producto->ubicacion)
                                {{ $producto->ubicacion }}
                            @else
                                <span class="text-gray-500 italic">Sin ubicación</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Eliminar</button>
                            </form>
                            <a href="{{ route('productos.show', $producto->id) }}" class="text-blue-600">Ver</a>
                        </td>
                    </tr>
                    @endforeach

                    @if($productos->count() == 0)
                        <tr>
                            <td colspan="10" class="p-4 text-gray-600">No hay productos registrados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
                <div class="mt-6 flex justify-center">
                    {{ $productos->links() }}
                </div>
                <div class="mt-6 flex justify-between">
                   <a href="{{ route('categorias.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition">
                        <- Anterior
                    </a>

                    <a href="{{ route('entradas.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-blue-700 transition">
                        -> Siguiente
                    </a>

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


