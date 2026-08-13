@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('planillas.index') }}"
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
                {{ $planilla->estado === 'abierta'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-200 text-gray-700' }}">
                {{ ucfirst($planilla->estado) }}
            </span>
        </p>

        <div class="overflow-x-auto">

            <table class="w-full text-sm border">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Empleado</th>
                        <th class="p-2">Salario</th>
                        <th class="p-2">Bonificación</th>
                        <th class="p-2">Bonificación Por Productividad</th>
                        <th class="p-2">IGSS</th>
                        <th class="p-2">ISR</th>
                        <th class="px-3 py-2">Anticipos</th>
                        <th class="p-2">Líquido a recibir</th>
                        <th class="p-2">Boleta</th>
                        <th class="p-2">Pago</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $totalSalarios = 0;
                        $totalIGSS = 0;
                        $totalBoni = 0;
                        $totalHorasExtras = 0;
                        $totalIsr = 0;
                        $totalAnticipos = 0;
                        $totalLiquido = 0;
                    @endphp

                    @foreach($empleados as $empleado)

                        @php
                            $totalSalarios += $empleado->calc->salario;
                            $totalBoni += $empleado->calc->bonificacion;
                            $totalHorasExtras += $empleado->calc->horas_extras;
                            $totalIGSS += $empleado->calc->igss;
                            $totalIsr += $empleado->calc->isr;
                            $totalAnticipos += $empleado->calc->anticipos;
                            $totalLiquido += $empleado->calc->liquido;

                            $pagado = $empleado->pivot->estado_pago === 'pagado';
                        @endphp

                        {{-- FILA DEL EMPLEADO --}}
                        <tr class="border-t transition
                            {{ $pagado
                                ? 'bg-emerald-50 border-l-4 border-l-emerald-500'
                                : 'hover:bg-gray-50' }}">

                            {{-- EMPLEADO --}}
                            <td class="p-2">
                                <div class="font-semibold {{ $pagado ? 'text-emerald-800' : 'text-gray-800' }}">
                                    {{ $empleado->name }}
                                </div>

                                @if($pagado)
                                    <span class="text-[10px] text-emerald-600 font-semibold">
                                        PAGO REGISTRADO
                                    </span>
                                @endif
                            </td>

                            {{-- SALARIO --}}
                            <td class="p-2 text-center">
                                Q {{ number_format($empleado->calc->salario, 2) }}
                            </td>

                            {{-- BONIFICACIÓN --}}
                            <td class="p-2 text-center">
                                Q {{ number_format($empleado->calc->bonificacion, 2) }}
                            </td>

                            {{-- HORAS EXTRAS --}}
                            <td class="p-2 text-center">
                                Q {{ number_format($empleado->calc->horas_extras, 2) }}
                            </td>

                            {{-- IGSS --}}
                            <td class="p-2 text-center">
                                Q {{ number_format($empleado->calc->igss, 2) }}
                            </td>

                            {{-- ISR --}}
                            <td class="p-2 text-center">
                                Q {{ number_format($empleado->calc->isr, 2) }}
                            </td>

                            {{-- ANTICIPOS --}}
                            <td class="p-2 text-center">
                                Q {{ number_format($empleado->calc->anticipos, 2) }}
                            </td>

                            {{-- LÍQUIDO --}}
                            <td class="p-2 text-center font-semibold">
                                Q {{ number_format($empleado->calc->liquido, 2) }}
                            </td>

                            {{-- BOLETA --}}
                            <td class="p-2 text-center">
                                <a href="{{ route('planillas.boleta.preview', [$planilla->id, $empleado->id]) }}"
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300 transition-all shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver boleta
                                </a>
                            </td>

                            {{-- PAGO --}}
                            <td class="p-2 text-center">

                                @if($pagado)

                                    {{-- YA PAGADO --}}
                                    <div class="inline-flex flex-col items-center">

                                        <span class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold shadow-sm">
                                            ✓ PAGADO
                                        </span>

                                        @if($empleado->pivot->fecha_pago)
                                            <span class="text-xs text-blue-700 font-medium mt-1">
                                                {{ \Carbon\Carbon::parse($empleado->pivot->fecha_pago)->format('d/m/Y H:i') }}
                                            </span>
                                        @endif

                                        @if($empleado->calc->usuario_pago)
                                            <span class="text-[10px] text-gray-500 mt-1">
                                                Por: {{ $empleado->calc->usuario_pago->name }}
                                            </span>
                                        @endif

                                    </div>

                                @else

                                    {{-- PENDIENTE DE PAGO --}}
                                    <form action="{{ route('planillas.marcarPagado', [$planilla->id, $empleado->id]) }}"
                                        method="POST"
                                        class="form-pagar inline"
                                        data-nombre="{{ $empleado->name }}">

                                        @csrf

                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600
                                                text-white px-3 py-1 rounded text-xs
                                                shadow transition">
                                            PENDIENTE
                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    {{-- TOTALES --}}
                    <tr class="border-t bg-gray-100 font-bold">

                        <td class="p-2">
                            Totales
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalSalarios, 2) }}
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalBoni, 2) }}
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalHorasExtras, 2) }}
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalIGSS, 2) }}
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalIsr, 2) }}
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalAnticipos, 2) }}
                        </td>

                        <td class="p-2 text-center">
                            Q {{ number_format($totalLiquido, 2) }}
                        </td>

                        <td></td>
                        <td></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-pagar').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            const nombre = form.dataset.nombre;

            Swal.fire({
                title: '¿Confirmar pago?',
                html: `
                    Se marcará como <strong>PAGADO</strong> al empleado:<br><br>
                    <strong>${nombre}</strong>
                    <br><br>
                    Se registrará la fecha, hora y usuario que realiza el pago.
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, marcar como pagado',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});
</script>

@endsection