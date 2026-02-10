@extends('layouts.principal')

@section('content')

<div class="py-8 max-w-7xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    📁 PRODUCTOS
                </h1>

                <a href="{{ route('prostock.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition whitespace-nowrap">
                    📦 Menú Inventario
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Gestión de productos – PROSERVE
            </p>

            <div class="mt-4">
                @if(auth()->user()->hasPermission('create_products'))
                    <a href="{{ route('productos.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                              hover:bg-green-700 transition">
                        ➕ Nuevo producto
                    </a>
                @endif
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
            action="{{ route('productos.index') }}"
            placeholder="Buscar producto..."
        />

        {{-- TABLA --}}
        <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Item</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Unidad</th>
                        <th>Stock</th>
                        @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor']))
                            <th>Precio</th>
                        @endif
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($productos as $producto)
                        <tr class="border-t">
                            <td>{{ $productos->firstItem() + $loop->index }}</td>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->unidad_medida }}</td>
                            <td>{{ $producto->stock_actual }}</td>

                            @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor']))
                                <td>
                                    @if($producto->precio_unitario > 0)
                                        Q {{ number_format($producto->precio_unitario,2) }}
                                    @else
                                        <span class="italic text-gray-500">Sin precio</span>
                                    @endif
                                </td>
                            @endif

                            <td>
                                {{ $producto->ubicacion ?? '—' }}
                            </td>

                            <td class="space-x-2">
                                @if(auth()->user()->hasPermission('edit_products'))
                                    <a href="{{ route('productos.edit', $producto->id) }}"
                                       class="text-blue-600">
                                        Editar
                                    </a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_products'))
                                    <form action="{{ route('productos.destroy', $producto->id) }}"
                                          method="POST" class="inline"
                                          onsubmit="confirmDelete(event, '{{ $producto->descripcion }}')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 ml-1">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('productos.show', $producto->id) }}"
                                   class="text-blue-600">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if($productos->count() === 0)
                        <tr>
                            <td colspan="10" class="p-4 text-gray-600">
                                No hay productos registrados.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $productos->appends(request()->query())->links() }}
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('categorias.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                ← Anterior
            </a>

            <a href="{{ route('entradas.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
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
