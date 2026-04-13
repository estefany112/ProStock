@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('planillas.index', $planilla->id) }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 
                px-4 py-2 rounded-lg text-sm shadow-sm">
            ← Volver
        </a>
    </div>
        
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">
            Planilla del {{ $planilla->fecha_inicio }} al {{ $planilla->fecha_fin }}
        </h2>

        <p class="mb-4">
            Estado:
            <span class="px-2 py-1 rounded text-xs
                {{ $planilla->estado === 'abierta' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                {{ ucfirst($planilla->estado) }}
            </span>
        </p>

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Empleado</th>
                    <th class="p-2">Salario</th>
                    <th class="p-2">Bonificación</th>
                    <th class="p-2">Horas Extras</th>
                    <th class="p-2">IGSS</th>
                    <th class="p-2">ISR</th>
                    <th class="p-2">Líquido a recibir</th>
                    <th class="p-2">Boleta</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSalarios = 0;
                    $totalIGSS = 0;
                    $totalBoni = 0;
                    $totalHorasExtras = 0;
                    $totalIsr = 0;
                    $totalLiquido = 0;
                @endphp

                @foreach($empleados as $empleado)

                    @php
                        $totalSalarios += $empleado->calc->salario;
                        $totalBoni += $empleado->calc->bonificacion;
                        $totalHorasExtras += $empleado->calc->horas_extras;
                        $totalIGSS += $empleado->calc->igss;
                        $totalIsr += $empleado->calc->isr;
                        $totalLiquido += $empleado->calc->liquido;
                    @endphp

                    <tr class="border-t">
                        <td class="p-2">{{ $empleado->name }}</td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->calc->salario,2) }}
                        </td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->calc->bonificacion,2) }}
                        </td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->calc->horas_extras, 2) }}
                        </td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->calc->igss,2) }}
                        </td>
                         <td class="p-2 text-center">
                            Q {{ number_format($empleado->calc->isr,2) }}
                        </td>
                        <td class="p-2 text-center font-semibold">
                            Q {{ number_format($empleado->calc->liquido,2) }}
                        </td>
                        <td class="p-2 text-center">
                            <a href="{{ route('planillas.boleta.preview', [$planilla->id, $empleado->id]) }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-black px-3 py-1 rounded text-xs shadow inline-block">
                                PREVIEW
                            </a>
                        </td>
                    </tr>

                @endforeach

                {{-- Totales --}}
                <tr class="border-t bg-gray-100 font-bold">
                    <td class="p-2">Totales</td>

                    <td class="p-2 text-center">
                        Q {{ number_format($totalSalarios,2) }}
                    </td>

                    <td class="p-2 text-center">
                        Q {{ number_format($totalBoni,2) }}
                    </td>

                    <td class="p-2 text-center">
                        Q {{ number_format($totalHorasExtras,2) }}
                    </td>

                    <td class="p-2 text-center">
                        Q {{ number_format($totalIGSS,2) }}
                    </td>

                    <td class="p-2 text-center">
                        Q {{ number_format($totalIsr,2) }}
                    </td>

                    <td class="p-2 text-center">
                        Q {{ number_format($totalLiquido,2) }}
                    </td>

                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endsection