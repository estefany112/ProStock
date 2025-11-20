<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Categorías - Proserve S.A.
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <a href="{{ route('categorias.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                + Nueva categoría
            </a>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mt-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nombre</th>
                        <th class="p-2 border">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categorias as $categoria)
                        <tr class="text-center border-t">
                            <td class="p-2 border">{{ $categoria->id }}</td>
                            <td class="p-2 border">{{ $categoria->nombre }}</td>

                            <td class="p-2 border">
                                <a href="{{ route('categorias.edit', $categoria->id) }}" class="text-blue-600 mr-2">
                                    Editar
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria->id) }}" 
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Deseas eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($categorias->count() == 0)
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">
                                No hay categorías registradas aún.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
