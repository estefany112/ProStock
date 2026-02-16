@extends('layouts.principal')

@section('content')

<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold flex items-center gap-2">
                📄 Nueva Solicitud
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Registrar solicitud de materiales o equipos – PROSERVE
            </p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('solicitudes.store') }}" class="space-y-4">
            @csrf

            {{-- EMPLEADO --}}
            <div>
                <label class="block font-medium mb-1">Empleado</label>
                <select name="empleado_id"
                        class="w-full border rounded-lg p-2"
                        required>
                    <option value="">Seleccione empleado</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}">
                            {{ $empleado->name }} - {{ $empleado->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- OBSERVACION --}}
            <div>
                <label class="block font-medium mb-1">Observación</label>
                <textarea name="observacion"
                          rows="3"
                          class="w-full border rounded-lg p-2"
                          placeholder="Detalle adicional de la solicitud..."></textarea>
            </div>

            <hr class="my-4">

            {{-- MATERIALES --}}
            <h2 class="text-lg font-semibold">Materiales solicitados</h2>

            <div id="materiales" class="space-y-3">

                <div class="flex gap-3 items-center material-row">
                    <input type="text"
                           name="descripcion[]"
                           class="w-2/3 border rounded-lg p-2"
                           placeholder="Descripción del material"
                           required>

                    <input type="number"
                           name="cantidad[]"
                           min="1"
                           class="w-1/3 border rounded-lg p-2"
                           placeholder="Cantidad"
                           required>

                    <button type="button"
                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 remove-row">
                        ✕
                    </button>
                </div>

            </div>

            <button type="button"
                    id="addRow"
                    class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                ➕ Agregar otro material
            </button>

            {{-- BOTONES --}}
            <div class="flex gap-3 pt-6">
                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Enviar Solicitud
                </button>

                <a href="{{ route('solicitudes.index') }}"
                   class="text-gray-600 hover:underline self-center">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

{{-- SCRIPT DINÁMICO --}}
<script>
document.getElementById('addRow').addEventListener('click', function() {
    let row = `
        <div class="flex gap-3 items-center material-row">
            <input type="text"
                   name="descripcion[]"
                   class="w-2/3 border rounded-lg p-2"
                   placeholder="Descripción del material"
                   required>

            <input type="number"
                   name="cantidad[]"
                   min="1"
                   class="w-1/3 border rounded-lg p-2"
                   placeholder="Cantidad"
                   required>

            <button type="button"
                    class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 remove-row">
                ✕
            </button>
        </div>
    `;
    document.getElementById('materiales').insertAdjacentHTML('beforeend', row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('.material-row').remove();
    }
});
</script>

@endsection