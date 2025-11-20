<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Entradas - Proserve') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <!-- Botón para crear nueva entrada -->
            <a href="{{ route('entradas.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 mb-4">+ Nueva Entrada</a>
            
            <!-- Mostrar mensaje de éxito si existe -->
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-6 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabla de entradas -->
            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Producto</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Fecha de Entrada</th>
                        {{--
                        <th>Acciones</th>
                        --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $entrada)
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
                        {{-- 
                        <td>
                            <a href="{{ route('entradas.edit', $entrada->id) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Eliminar</button>
                            </form>
                        </td>
                        --}}
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
