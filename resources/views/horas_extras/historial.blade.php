@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('horas-extras.quincena') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 
                px-4 py-2 rounded-lg text-sm shadow-sm">
            ← Volver
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-semibold mb-4">Historial de Horas Extras</h2>

        {{-- FILTRO --}}
        <form class="grid grid-cols-3 gap-4 mb-4">
            <input type="date" name="inicio" value="{{ $inicio }}" class="border px-3 py-2 rounded">
            <input type="date" name="fin" value="{{ $fin }}" class="border px-3 py-2 rounded">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Filtrar</button>
        </form>

        {{-- TABLA --}}
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th>Empleado</th>
                    <th>Total Horas</th>
                    <th>Total Q</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $d)
                <tr class="border-b">
                    <td>{{ $d->empleado->name }}</td>
                    <td>{{ $d->total_horas }}</td>
                    <td>Q {{ number_format($d->total_pago,2) }}</td>
                    <td>
                        <a href="{{ route('horas-extras.detalle', [$d->empleado_id, $inicio, $fin]) }}"
                        class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                            Ver
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection