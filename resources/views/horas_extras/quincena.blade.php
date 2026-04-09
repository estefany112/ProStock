@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    {{-- FORMULARIO HORAS EXTRAS --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h2 class="text-lg font-semibold mb-4">Registrar Horas Extras (Quincena)</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('horas-extras.guardar') }}" method="POST">
            @csrf

            <div class="grid grid-cols-3 gap-4 mb-4">

                <div>
                    <label class="block text-sm text-gray-600">Empleado</label>
                    <select name="empleado_id"
                        class="w-full border rounded px-3 py-2">
                        @foreach($empleados as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Fecha inicio</label>
                    <input type="date" id="inicio"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Fecha fin</label>
                    <input type="date" id="fin"
                        class="w-full border rounded px-3 py-2">
                </div>

            </div>

            <button type="button"
                onclick="generarTabla()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm transition mb-4">
                Generar días
            </button>

            {{-- TABLA DINÁMICA --}}
            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="py-2 text-left px-3">Fecha</th>
                        <th class="py-2 text-left px-3">Horas</th>
                    </tr>
                </thead>
                <tbody id="tablaDias"></tbody>
            </table>

            <div class="mt-4">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    Guardar Horas Extras
                </button>
            </div>
        </form>
    </div>

</div>

{{-- SCRIPT --}}
<script>
function generarTabla() {
    let inicio = document.getElementById('inicio').value;
    let fin = document.getElementById('fin').value;

    if (!inicio || !fin) {
        alert('Seleccione fechas');
        return;
    }

    let tbody = document.getElementById('tablaDias');
    tbody.innerHTML = '';

    let fechaInicio = new Date(inicio);
    let fechaFin = new Date(fin);

    while (fechaInicio <= fechaFin) {

        let fecha = fechaInicio.toISOString().split('T')[0];

        let fila = `
            <tr class="border-b">
                <td class="px-3 py-2">
                    ${fecha}
                    <input type="hidden" name="fechas[]" value="${fecha}">
                </td>
                <td class="px-3 py-2">
                    <input type="number" step="0.1" name="horas[]"
                        class="border rounded px-2 py-1 w-24"
                        value="0">
                </td>
            </tr>
        `;

        tbody.innerHTML += fila;

        fechaInicio.setDate(fechaInicio.getDate() + 1);
    }
}
</script>

@endsection