@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-white">
                Editar ISR
            </h2>
        </div>

        <a href="{{ route('planillas.show', $planilla->id) }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 
                  px-4 py-2 rounded-lg text-sm shadow-sm">
            ← Volver
        </a>
    </div>

    <div class="bg-white shadow rounded-xl p-6">

         <h2 class="text-xl font-bold mb-4">
            Planilla del {{ $planilla->fecha_inicio }} al {{ $planilla->fecha_fin }}
        </h2>

        <form action="{{ route('planillas.guardarIsr', $planilla->id) }}" method="POST">
        @csrf

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr class="border-b bg-gray-50">
                    <th class="py-3 text-left font-medium">Empleado</th>
                    <th class="py-3 text-center font-medium">Salario</th>
                    <th class="py-3 text-center font-medium">IGSS</th>
                    <th class="py-3 text-center font-medium">ISR</th>
                </tr>
            </thead>
            <tbody>

            @php
                $totalIsr = 0;
            @endphp

            @foreach($planilla->employees as $empleado)

                @php
                    $totalIsr += $empleado->pivot->isr;
                @endphp

                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3">
                        <span class="font-medium">{{ $empleado->name }}</span>
                    </td>

                    <td class="py-3 text-center">
                        Q {{ number_format($empleado->pivot->salary_base_quincenal,2) }}
                    </td>

                    <td class="py-3 text-center">
                        Q {{ number_format($empleado->pivot->igss,2) }}
                    </td>

                    <td class="py-3 text-center">
                        <input type="number"
                               step="any"
                               name="isr[{{ $empleado->id }}]"
                               value="{{ $empleado->pivot->isr }}"
                               class="border rounded-lg px-3 py-1 w-28 text-center 
                                      focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>

        {{-- Totales --}}
        <div class="mt-6 flex justify-end">
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm text-right w-64">
                <p class="text-sm text-gray-500">Total ISR actual</p>
                <p class="text-lg font-semibold">
                    Q {{ number_format($totalIsr,2) }}
                </p>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex justify-end gap-3">

            <a href="{{ route('planillas.show', $planilla->id) }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 
                      px-4 py-2 rounded-lg text-sm shadow-sm">
                Cancelar
            </a>

            <button class="bg-amber-500 hover:bg-amber-600 text-black 
                           px-5 py-2 rounded-lg text-sm shadow-sm 
                           transition duration-200 hover:green">
                💾 Guardar Cambios
            </button>

        </div>

        </form>

    </div>

</div>
@endsection