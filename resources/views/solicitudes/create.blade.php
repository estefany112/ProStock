@extends('layouts.principal')

@section('content')

<section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">

    <!-- Imagen de fondo -->
    <div class="absolute inset-0">
        <img src="{{ asset('assets/img/icono.png') }}"
             class="w-full h-full object-cover"
             alt="Fondo">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Contenido -->
    <div class="relative z-10 container py-20">
        <div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        
    </div>

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8">

        <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
            📄 Nueva Solicitud
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Registro de materiales o equipos solicitados por el empleado
        </p>

        <div>           <br>     </div>

        {{-- MENSAJE INFORMATIVO --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-lg mb-6 text-sm">
            ℹ Verifique que la información sea correcta antes de enviar la solicitud.
        </div>

        <form action="{{ route('solicitudes.store') }}" method="POST" id="formSolicitud" class="space-y-8">
            @csrf

            {{-- INFORMACIÓN GENERAL --}}
            <div>
                <h2 class="text-lg font-semibold text-slate-700 mb-4 border-b pb-2">
                    Información General
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- EMPLEADO --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            Empleado
                        </label>
                        <select name="empleado_id"
                                class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                            <option value="">Seleccione empleado</option>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}">
                                    {{ $empleado->name }} - {{ $empleado->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- OBSERVACIÓN --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            Observación
                        </label>
                        <textarea name="observacion"
                                  rows="3"
                                  class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                  placeholder="Detalle adicional..."></textarea>
                    </div>

                </div>
            </div>

            {{-- MATERIALES --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-slate-700">
                        Materiales solicitados
                    </h2>
                    <span id="contadorMateriales"
                          class="text-sm bg-slate-100 px-3 py-1 rounded-full text-slate-600">
                        1 material
                    </span>
                </div>

                <div id="materiales" class="space-y-3">

                    <div class="flex gap-3 items-center material-row bg-slate-50 p-3 rounded-lg border">

                        <input type="text"
                               name="descripcion[]"
                               class="w-2/3 border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="Descripción del material"
                               required>

                        <input type="number"
                               name="cantidad[]"
                               min="1"
                               class="w-1/4 border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="Cantidad"
                               required>

                        <button type="button"
                                class="bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition remove-row">
                            ✕
                        </button>

                    </div>

                </div>

                <button type="button"
                        id="addRow"
                        class="mt-4 bg-slate-200 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-300 transition text-sm">
                    ➕ Agregar material
                </button>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-4 pt-6 border-t">

                <a href="{{ route('solicitudes.index') }}"
                   class="text-slate-600 hover:underline text-sm">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg shadow-md hover:scale-105 hover:shadow-lg transition duration-200">
                    📩 Enviar Solicitud
                </button>

            </div>

        </form>

    </div>
        </div>
    </div>
</section>

{{-- SCRIPT --}}
<script>

function actualizarContador() {
    let total = document.querySelectorAll('.material-row').length;
    document.getElementById('contadorMateriales').innerText =
        total + (total === 1 ? " material" : " materiales");
}

document.getElementById('addRow').addEventListener('click', function() {

    let row = `
        <div class="flex gap-3 items-center material-row bg-slate-50 p-3 rounded-lg border">

            <input type="text"
                   name="descripcion[]"
                   class="w-2/3 border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Descripción del material"
                   required>

            <input type="number"
                   name="cantidad[]"
                   min="1"
                   class="w-1/4 border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Cantidad"
                   required>

            <button type="button"
                    class="bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition remove-row">
                ✕
            </button>
        </div>
    `;

    document.getElementById('materiales').insertAdjacentHTML('beforeend', row);
    actualizarContador();
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('.material-row').remove();
        actualizarContador();
    }
});

document.getElementById('formSolicitud').addEventListener('submit', function(e) {
    if (!confirm('¿Está seguro de enviar la solicitud?')) {
        e.preventDefault();
    }
});

</script>

@endsection