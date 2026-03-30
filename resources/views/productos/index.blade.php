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
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Unidad</th>
                        <th>Stock</th>
                        @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen']))
                            <th>Precio</th>
                        @endif
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($productos as $producto)
                        <tr class="border-t">
                            <td>{{ $productos->total() - (($productos->currentPage() - 1) * $productos->perPage()) - $loop->index }}</td>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                <img src="{{ $producto->image && file_exists(public_path('storage/' . $producto->image)) 
                                    ? asset('storage/' . $producto->image) 
                                    : asset('images/no-image.jpg') }}"
                                    width="60"
                                    height="60"
                                    style="object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->unidad_medida }}</td>
                            <td>{{ $producto->stock_actual }}</td>

                            @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen' ]))
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

                           <td>
                            <div class="flex items-center space-x-3">

                                {{-- Ver --}}
                                <a href="{{ route('productos.show', $producto->id) }}"
                                class="flex items-center text-blue-600 hover:text-blue-800">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" viewBox="0 0 24 24" 
                                        stroke-width="1.5" stroke="currentColor" 
                                        class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                                    </svg>

                                    Ver
                                </a>

                                {{-- Editar --}}
                                @if(auth()->user()->hasPermission('edit_products'))
                                    <a href="{{ route('productos.edit', [
                                            $producto->id,
                                            'search' => request('search'),
                                            'page' => request('page')
                                        ]) }}" 
                                    class="flex items-center text-indigo-600 hover:text-indigo-800">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            viewBox="0 0 24 24" 
                                            fill="currentColor" 
                                            class="w-5 h-5 mr-1">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712Z" />
                                            <path d="M19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        </svg>
                                        Editar
                                    </a>
                                @endif

                                {{-- Eliminar --}}
                                @if(auth()->user()->hasPermission('delete_products'))
                                    <form action="{{ route('productos.destroy', $producto->id) }}"
                                        method="POST"
                                        onsubmit="confirmDelete(event, '{{ $producto->descripcion }}')">
                                        
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" 
                                                class="flex items-center text-red-600 hover:text-red-800">
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                fill="none" viewBox="0 0 24 24" 
                                                stroke-width="1.5" stroke="currentColor" 
                                                class="w-5 h-5 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M6 7.5h12M9.75 7.5v9m4.5-9v9M4.5 7.5h15l-1.5 12h-12l-1.5-12Z" />
                                            </svg>

                                            Eliminar
                                        </button>
                                    </form>
                                @endif

                            </div>
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
