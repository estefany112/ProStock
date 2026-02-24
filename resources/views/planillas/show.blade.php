@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

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
                    <th class="p-2">IGSS</th>
                    <th class="p-2">ISR</th>
                    <th class="p-2">Líquido</th>
                    <th class="p-2">Boleta</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSalarios = 0;
                    $totalIGSS = 0;
                    $totalLiquido = 0;
                @endphp

                @foreach($planilla->employees as $empleado)

                    @php
                        $totalSalarios += $empleado->pivot->salary_base_quincenal;
                        $totalIGSS += $empleado->pivot->igss;
                        $totalLiquido += $empleado->pivot->liquido_recibir;
                    @endphp

                    <tr class="border-t">
                        <td class="p-2">{{ $empleado->name }}</td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->pivot->salary_base_quincenal,2) }}
                        </td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->pivot->bonificacion,2) }}
                        </td>
                        <td class="p-2 text-center">
                            Q {{ number_format($empleado->pivot->igss,2) }}
                        </td>
                         <td class="p-2 text-center">
                            @if($planilla->estado === 'abierta')

                            <form action="{{ route('planillas.actualizarIsr', [$planilla->id, $empleado->id]) }}"
                                method="POST"
                                class="flex justify-center gap-1">
                                @csrf
                                <input type="number"
                                    step="0.01"
                                    name="isr"
                                    value="{{ $empleado->pivot->isr }}"
                                    class="border rounded px-2 py-1 w-20 text-sm">

                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                    💾
                                </button>
                            </form>

                            @else

                            Q {{ number_format($empleado->pivot->isr,2) }}

                            @endif
                        </td>
                        <td class="p-2 text-center font-semibold">
                            Q {{ number_format($empleado->pivot->liquido_recibir,2) }}
                        </td>

                        <td class="p-2 text-center">
                            <a href="{{ route('planillas.boleta', [$planilla->id, $empleado->id]) }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs shadow inline-block">
                                📄 PDF
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
                    <td></td>
                    <td class="p-2 text-center">
                        Q {{ number_format($totalIGSS,2) }}
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