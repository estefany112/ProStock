@extends('layouts.principal')

@section('content')

<div class="max-w-6xl mx-auto py-8">

```
<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
    
    <h2 class="text-xl font-bold text-gray-800 mb-6">
        Registrar Bonificación Por Productividad (Quincena)
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('horas-extras.guardar') }}" method="POST">
        @csrf

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div>
                <label class="block text-sm text-gray-500 mb-1">Empleado</label>
                <select name="empleado_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach($empleados as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Fecha inicio</label>
                <input type="date" id="inicio"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Fecha fin</label>
                <input type="date" id="fin"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

        </div>

        <!-- BOTÓN -->
        <button type="button"
            onclick="generarTabla()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-sm transition mb-5">
            Generar días
        </button>

        <!-- TABLA -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-gray-600">
                
                <thead class="bg-gray-800 text-white text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left">Fecha</th>
                        <th class="py-3 px-4 text-left">Horas</th>
                    </tr>
                </thead>

                <tbody id="tablaDias" class="divide-y"></tbody>

            </table>
        </div>

        <!-- TOTAL (nuevo pero opcional) -->
        <div class="mt-4 text-right">
            <span class="text-gray-600 text-sm">Total horas:</span>
            <span id="totalHoras" class="font-bold text-blue-600">0</span>
        </div>

        <!-- SUBMIT -->
        <div class="mt-6">
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow transition">
                Guardar Bonificación Por Productividad
            </button>
        </div>

    </form>
</div>
```

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
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-2">
                    ${fecha}
                    <input type="hidden" name="fechas[]" value="${fecha}">
                </td>
                <td class="px-4 py-2">
                    <input type="number" step="0.1" name="horas[]"
                        class="border border-gray-300 rounded-lg px-2 py-1 w-24 focus:ring-2 focus:ring-blue-500 focus:outline-none horas-input"
                        value="0"
                        oninput="calcularTotal()">
                </td>
            </tr>
        `;

        tbody.innerHTML += fila;

        fechaInicio.setDate(fechaInicio.getDate() + 1);
    }

    calcularTotal();
}

function calcularTotal() {
    let inputs = document.querySelectorAll('.horas-input');
    let total = 0;

    inputs.forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    document.getElementById('totalHoras').innerText = total.toFixed(1);
}
</script>

@endsection
