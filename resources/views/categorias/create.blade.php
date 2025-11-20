<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Crear Categoría
        </h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf

                <label class="block mb-2 font-semibold">Nombre de categoría</label>
                <input type="text" name="nombre"
                    class="w-full border rounded p-2"
                    required>

                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar
                </button>

                <a href="{{ route('categorias.index') }}" 
                   class="ml-2 text-gray-600 hover:underline">
                   Cancelar
                </a>
            </form>

        </div>
    </div>
</x-app-layout>
