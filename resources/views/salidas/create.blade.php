@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold flex items-center gap-2">
                📤 Registrar Salida de Producto
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Registro de salida de productos del inventario – PROSERVE
            </p>
        </div>

        {{-- MENSAJE DE ÉXITO --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORMULARIO --}}
        <form action="{{ route('salidas.store') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf

            {{-- PRODUCTO --}}
            <div>
                <label for="producto_id" class="block mb-1 font-medium">
                    Producto
                </label>
                <div>
                    <input type="text"
                        id="buscar"
                        placeholder="Buscar por código o nombre"
                        class="w-full border rounded-lg px-3 py-2 mb-2">

                    <select name="producto_id"
                        id="producto_select"
                        required
                        class="w-full border rounded-lg px-3 py-2">

                        <option value="">Seleccione un producto</option>

                        @foreach(\App\Models\Producto::orderBy('descripcion')->get() as $producto)
                            <option value="{{ $producto->id }}">
                                {{ $producto->descripcion }} | Código: {{ $producto->codigo }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            {{-- CANTIDAD --}}
            <div>
                <label for="cantidad" class="block mb-1 font-medium">
                    Cantidad
                </label>
                <input type="number"
                       name="cantidad"
                       id="cantidad"
                       min="1"
                       required
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-red-200">
            </div>

            {{-- MOTIVO --}}
            <div>
                <label for="motivo" class="block mb-1 font-medium">
                    Motivo
                </label>
                <input type="text"
                       name="motivo"
                       id="motivo"
                       required
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-red-200">
            </div>

            {{-- BOTONES --}}
            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg shadow
                               hover:bg-red-700 transition">
                    Registrar Salida
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

@section('scripts')

<script>

const buscar = document.getElementById('buscar');
const select = document.getElementById('producto_select');

buscar.addEventListener('keyup', function(){

    let filtro = this.value.toLowerCase();

    for(let option of select.options){

        let texto = option.text.toLowerCase();

        option.style.display = texto.includes(filtro) ? '' : 'none';

    }

});

</script>

@endsection