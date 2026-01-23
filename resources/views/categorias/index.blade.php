<x-app-layout>

    <div class="py-8 max-w-6xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border">

           {{-- HEADER DE LA VISTA --}}
            <div class="mb-6">

                {{-- FILA SUPERIOR: TÍTULO + INVENTARIO --}}
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        📁 Categorías
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
                    Gestión de categorías de productos – PROSERVE
                </p>

                {{-- ACCIÓN PRINCIPAL --}}
                <div class="mt-4">
                    <a href="{{ route('categorias.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                            hover:bg-green-700 transition">
                        ➕ Nueva categoría
                    </a>
                </div>

            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-gray-600 border-b">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-600 border-b">Nombre</th>
                            <th class="p-3 text-center text-sm font-semibold text-gray-600 border-b">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 border-b text-sm text-gray-700">
                                    {{ $categoria->id }}
                                </td>

                                <td class="p-3 border-b text-sm text-gray-700">
                                    {{ $categoria->nombre }}
                                </td>

                                <td class="p-3 border-b text-center space-x-3">
                                    <a href="{{ route('categorias.edit', $categoria->id) }}"
                                       class="text-blue-600 hover:underline">
                                        Editar
                                    </a>

                                    <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('¿Deseas eliminar esta categoría?')">
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
                                <td colspan="3" class="p-6 text-center text-gray-500">
                                    No hay categorías registradas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app-layout>
