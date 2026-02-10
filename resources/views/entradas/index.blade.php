@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">

        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    📥 ENTRADAS
                </h1>

                <a href="{{ route('prostock.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition whitespace-nowrap">
                    📦 Menú Inventario
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Gestión de entradas de productos – PROSERVE
            </p>

            {{-- ACCIÓN PRINCIPAL --}}
            <div class="mt-4 flex gap-3">
                <a href="{{ route('entradas.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-green-700 transition">
                    ➕ Nueva entrada
                </a>

            </div>

            

        </div>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUSCADOR --}}
        <x-search-bar
            action="{{ route('entradas.index') }}"
            placeholder="Buscar por producto, motivo o ubicación..."
        />

        {{-- TABLA --}}
        <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Producto</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Fecha de entrada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($entradas as $entrada)
                    <tr class="border-t">
                        <td>
                            {{ $entrada->producto->descripcion }}<br>
                            <span class="text-gray-500 text-sm">
                                {{ $entrada->producto->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td>{{ $entrada->cantidad }}</td>
                        <td>{{ $entrada->motivo }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('d-m-Y H:i') }}
                        </td>
                        <td class="flex gap-3 justify-center">
                            <a href="{{ route('entradas.edit', $entrada->id) }}"
                               class="text-blue-600">
                                Editar
                            </a>

                            <form action="{{ route('entradas.destroy', $entrada->id) }}"
                                method="POST"
                                onsubmit="confirmDelete(event, '{{ $entrada->producto->descripcion }}')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-gray-600">
                            No hay entradas registradas.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-6 flex justify-center">
            {{ $entradas->appends(request()->query())->links() }}
        </div>

        {{-- NAVEGACIÓN --}}
        <div class="mt-6 flex justify-between">
            <a href="{{ route('productos.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                      hover:bg-blue-700 transition">
                ← Anterior
            </a>

            <a href="{{ route('salidas.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                      hover:bg-blue-700 transition">
                Siguiente →
            </a>
        </div>

    </div>
</div>

<script>
function confirmDelete(event, nombre) {
    event.preventDefault();

    Swal.fire({
        title: 'Confirmar eliminación',
        html: `
            <p>¿Deseas eliminar el siguiente registro?</p>
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
