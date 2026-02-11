@extends('layouts.principal')

@section('content')

    <div class="py-8 max-w-6xl mx-auto">
        <div class="bg-white p-6 rounded-xl shadow-sm border">

            {{-- HEADER --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        📊 Histórico Caja Chica
                    </h1>
                    <p class="text-sm text-gray-500">
                        Cajas semanales cerradas
                    </p>
                </div>

                <a href="{{ route('caja.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition">
                    ⬅ Caja Actual
                </a>
            </div>

            {{-- TABLA --}}
            <div class="overflow-x-auto">
                <table class="w-full border text-center">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Semana</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Saldo inicial</th>
                            <th>Saldo final</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cajas as $caja)
                            <tr class="border-t">
                                <td class="p-2 font-semibold">
                                    {{ $caja->period_start->format('d/m/Y') }}
                                    -
                                    {{ $caja->period_end->format('d/m/Y') }}
                                </td>
                                <td>{{ $caja->period_start->format('d/m/Y') }}</td>
                                <td>{{ $caja->period_end->format('d/m/Y') }}</td>
                                <td>Q {{ number_format($caja->initial_balance, 2) }}</td>
                                <td>Q {{ number_format($caja->current_balance, 2) }}</td>
                                <td>
                                    <span class="px-2 py-1 rounded text-sm bg-gray-200 text-gray-700">
                                        Cerrada
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @if($cajas->count() === 0)
                            <tr>
                                <td colspan="6" class="p-4 text-gray-500">
                                    No hay semanas cerradas aún.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            <div class="mt-6">
                {{ $cajas->links() }}
            </div>

        </div>
    </div>

@endsection