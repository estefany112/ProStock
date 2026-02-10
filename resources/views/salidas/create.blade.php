@extends('layouts.principal')

@section('content')

<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold flex items-center gap-2">
                ➕ Registrar Salida
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Registrar salida de producto del inventario – PROSERVE
            </p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('salidas.store') }}" class="space-y-4">
            @csrf

            {{-- PRODUCTO --}}
            <div>
                <label class="block font-medium mb-1">Producto</label>
                <select name="producto_id"
                        class="w-full border rounded-lg p-2"
                        required>
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->descripcion }} (Stock: {{ $p->stock_actual }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- CANTIDAD --}}
            <div>
                <label class="block font-medium mb-1">Cantidad</label>
                <input type="number"
                       min="1"
                       name="cantidad"
                       class="w-full border rounded-lg p-2"
                       required>
            </div>

            {{-- MOTIVO --}}
            <div>
                <label class="block font-medium mb-1">Motivo</label>
                <input type="text"
                       name="motivo"
                       class="w-full border rounded-lg p-2"
                       required>
            </div>

            {{-- BOTONES --}}
            <div class="flex gap-3 pt-4">
                <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition">
                    Registrar salida
                </button>

                <a href="{{ route('salidas.index') }}"
                   class="text-gray-600 hover:underline self-center">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
