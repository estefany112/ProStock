<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white-800 leading-tight">
            {{ __('Productos - Proserve') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <!-- Botón para crear producto -->
            <a href="{{ route('productos.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 mb-4">+ Nuevo producto</a>
            
            <!-- Mostrar mensaje de éxito si existe -->
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-6 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabla de productos -->
            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Id</th>
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
                </tbody>
            </table>
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
