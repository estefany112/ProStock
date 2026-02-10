@extends('layouts.principal')

@section('content')

<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

        {{-- HEADER --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    📤 SALIDAS
                </h1>

                <a href="{{ route('prostock.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition whitespace-nowrap">
                    📦 Menú Inventario
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Gestión de salidas de productos – PROSERVE
            </p>

            <div class="mt-4">
                <a href="{{ route('salidas.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-green-700 transition">
                    ➕ Nueva salida
                </a>
            </div>

        </div>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- BUSCADOR --}}
        <x-search-bar
            action="{{ route('salidas.index') }}"
            placeholder="Buscar por producto, motivo o ubicación..."
        />

        {{-- TABLA --}}
        <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
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
                @forelse($salidas as $salida)
                    <tr class="border-t">
                        <td class="p-2">
                            {{ $salida->producto->descripcion }}
                        </td>

                        <td class="p-2 text-gray-600">
                            {{ $salida->producto->categoria->nombre ?? 'Sin categoría' }}
                        </td>

                        <td class="p-2">{{ $salida->cantidad }}</td>
                        <td class="p-2">{{ $salida->motivo }}</td>
                        <td class="p-2">
                            {{ \Carbon\Carbon::parse($salida->fecha_salida)->format('d-m-Y H:i') }}
                        </td>

                        <td class="p-2 space-x-2">
                            <a href="{{ route('salidas.edit', $salida->id) }}"
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>

                            <form action="{{ route('salidas.destroy', $salida->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="confirmDelete(event, '{{ $salida->producto->descripcion }}')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-gray-600">
                            No hay salidas registradas.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-6 flex justify-center">
            {{ $salidas->appends(request()->query())->links() }}
        </div>

        {{-- NAVEGACIÓN --}}
        <div class="mt-6 flex justify-between">
            <a href="{{ route('entradas.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                      hover:bg-blue-700 transition">
                ← Anterior
            </a>

            <a href="{{ route('prostock.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                      hover:bg-blue-700 transition">
                Siguiente →
            </a>
        </div>

    </div>
</div>

{{-- SWEETALERT --}}
<script>
function confirmDelete(event, nombre) {
    event.preventDefault();

    Swal.fire({
        title: 'Confirmar eliminación',
        html: `
            <p>¿Deseas eliminar la siguiente salida?</p>
            <p class="mt-2 font-semibold text-red-600">
                ${nombre}
            </p>
            <p class="mt-2 text-sm text-gray-500">
                Esta acción no se puede deshacer.
            </p>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
}
</script>

@endsection
