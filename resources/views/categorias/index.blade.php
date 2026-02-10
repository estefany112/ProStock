@extends('layouts.principal')

@section('content')

<div class="py-8 max-w-7xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

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

                                <button onclick="confirmDelete({{ $categoria->id }})"
                                        class="text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>

                                <form id="delete-form-{{ $categoria->id }}"
                                      action="{{ route('categorias.destroy', $categoria->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
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

@endsection
