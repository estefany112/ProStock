@extends('layouts.principal')

@section('content')

<div class="max-w-4xl mx-auto py-8">

<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

    <h2 class="text-xl font-bold text-gray-800 mb-6">
        Detalle - {{ $empleado->name }}
    </h2>

    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full text-sm text-gray-600">

            <thead class="bg-gray-800 text-white text-xs uppercase">
                <tr>
                    <th class="py-3 px-4 text-left">Fecha</th>
                    <th class="py-3 px-4 text-left">Horas</th>
                    <th class="py-3 px-4 text-left">Total</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($registros as $r)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3">
                        {{ $r->fecha }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
                            {{ $r->horas }} hrs
                        </span>
                    </td>

                    <td class="px-4 py-3 font-semibold text-green-600">
                        Q {{ number_format($r->total,2) }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-6 text-gray-500">
                        No hay registros disponibles
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>

    <!-- TOTAL GENERAL -->
    <div class="mt-6 text-right">
        <span class="text-gray-600 text-sm">Total general:</span>
        <span class="font-bold text-lg text-green-600">
            Q {{ number_format($registros->sum('total'), 2) }}
        </span>
    </div>

</div>

</div>
@endsection
