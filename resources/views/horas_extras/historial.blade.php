@extends('layouts.principal')

@section('content')

<div class="max-w-6xl mx-auto py-8">

```
<!-- BOTÓN VOLVER -->
<div class="flex justify-end items-center mb-6">
    <a href="{{ route('horas-extras.quincena') }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-700 
            px-4 py-2 rounded-lg text-sm shadow-sm transition">
        ← Volver
    </a>
</div>

<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

    <h2 class="text-xl font-bold text-gray-800 mb-6">
        Historial de Horas Extras
    </h2>

    <!-- FILTRO -->
    <form class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        
        <input type="date" name="inicio" value="{{ $inicio }}" 
            class="border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <input type="date" name="fin" value="{{ $fin }}" 
            class="border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            Filtrar
        </button>

    </form>

    <!-- TABLA -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full text-sm text-gray-600">

            <thead class="bg-gray-800 text-white text-xs uppercase">
                <tr>
                    <th class="py-3 px-4 text-left">Empleado</th>
                    <th class="py-3 px-4 text-left">Total Horas</th>
                    <th class="py-3 px-4 text-left">Total Q</th>
                    <th class="py-3 px-4 text-left">Acción</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($datos as $d)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $d->empleado->name }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
                            {{ $d->total_horas }} hrs
                        </span>
                    </td>

                    <td class="px-4 py-3 font-semibold text-green-600">
                        Q {{ number_format($d->total_pago,2) }}
                    </td>

                    <td class="px-4 py-3">
                        <a href="{{ route('horas-extras.detalle', [$d->empleado_id, $inicio, $fin]) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs shadow transition">
                            Ver detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        No hay registros en este rango de fechas
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>

</div>
```

</div>
@endsection
