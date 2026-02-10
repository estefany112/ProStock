@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">

        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    📁 Categorías
                </h1>

                <a href="{{ route('prostock.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition whitespace-nowrap">
                    📦 Menú Inventario
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Gestión de categorías de productos – PROSERVE
            </p>

            <div class="mt-4">
                <a href="{{ route('categorias.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-green-700 transition">
                    ➕ Nueva categoría
                </a>
            </div>

        </div>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLA --}}
        <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-gray-600">ID</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Nombre</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categorias as $categoria)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 border-b">{{ $categoria->id }}</td>
                            <td class="p-3 border-b">{{ $categoria->nombre }}</td>
                            <td class="p-3 border-b text-center space-x-3">
                                <a href="{{ route('categorias.edit', $categoria->id) }}"
                                   class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                    method="POST"
                                    onsubmit="confirmDelete(event, '{{ $categoria->nombre }}')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-500">
                                No hay categorías registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $categorias->links() }}
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('productos.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                      hover:bg-blue-700 transition">
                → Siguiente
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
            <p>¿Deseas eliminar la categoría:</p>
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
