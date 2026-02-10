@extends('layouts.principal')

@section('content')

<div class="py-8 max-w-7xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                ➕ Crear Categoría
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Registrar una nueva categoría de productos – PROSERVE
            </p>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('categorias.store') }}" method="POST" class="max-w-md">
            @csrf

            <div class="mb-4">
                <label class="block mb-2 font-semibold">
                    Nombre de categoría
                </label>

                <input type="text"
                       name="nombre"
                       class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            <div class="flex gap-3">
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg
                               hover:bg-green-700 transition">
                    Guardar
                </button>

                <a href="{{ route('categorias.index') }}"
                   class="text-gray-600 hover:underline self-center">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
