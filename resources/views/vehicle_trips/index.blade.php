@extends('layouts.principal')

@section('content')

<div class="max-w-7xl mx-auto pt-20 pb-12 px-4">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Control de Viajes
            </h1>

            <p class="text-slate-400 mt-1">
                Control de salidas y retornos de vehículos.
            </p>
        </div>

        <a href="{{ route('vehicle-trips.departure.create') }}"
           class="inline-flex items-center justify-center gap-2
                  bg-emerald-600 hover:bg-emerald-500
                  text-white px-6 py-3 rounded-xl
                  font-bold shadow-lg shadow-emerald-900/30
                  transition-all hover:-translate-y-0.5">

            <svg class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Registrar Salida
        </a>

    </div>


    {{-- TABLA --}}
    <div class="bg-slate-800/50 backdrop-blur-md
                border border-slate-700 rounded-3xl
                shadow-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-900/60 border-b border-slate-700">

                    <tr class="text-left text-xs uppercase tracking-wider text-slate-400">

                        <th class="px-6 py-4">
                            Vehículo
                        </th>

                        <th class="px-6 py-4">
                            Conductor
                        </th>

                        <th class="px-6 py-4">
                            Salida
                        </th>

                        <th class="px-6 py-4">
                            Destino
                        </th>

                        <th class="px-6 py-4">
                            Kilometraje
                        </th>

                        <th class="px-6 py-4">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center">
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-700/50">

                    @forelse($trips as $trip)

                        <tr class="hover:bg-slate-700/20 transition">

                            {{-- VEHÍCULO --}}
                            <td class="px-6 py-5">

                                <p class="text-white font-bold">
                                    {{ $trip->vehicle->numero_interno }}
                                </p>

                                <p class="text-slate-400 text-sm">
                                    {{ $trip->vehicle->marca }}
                                    -
                                    {{ strtoupper($trip->vehicle->placa) }}
                                </p>

                            </td>


                            {{-- CONDUCTOR --}}
                            <td class="px-6 py-5">

                                <p class="text-slate-200 font-medium">
                                    {{ $trip->driver->name }}
                                </p>

                                <p class="text-slate-500 text-xs">
                                    {{ $trip->driver->codigo_personal }}
                                </p>

                            </td>


                            {{-- SALIDA --}}
                            <td class="px-6 py-5">

                                <p class="text-slate-200">
                                    {{ $trip->departure_at->format('d/m/Y') }}
                                </p>

                                <p class="text-slate-500 text-sm">
                                    {{ $trip->departure_at->format('H:i') }}
                                </p>

                            </td>


                            {{-- DESTINO --}}
                            <td class="px-6 py-5">

                                <p class="text-slate-300">
                                    {{ $trip->destination }}
                                </p>

                            </td>


                            {{-- KILOMETRAJE --}}
                            <td class="px-6 py-5">

                                <p class="text-slate-200">
                                    {{ number_format($trip->departure_mileage) }} km
                                </p>

                                @if($trip->status === 'RETORNADO' && $trip->return_mileage !== null)

                                    <p class="text-slate-500 text-xs mt-1">
                                        Retorno:
                                        {{ number_format($trip->return_mileage) }} km
                                    </p>

                                    <p class="text-emerald-400 text-xs mt-1">
                                        Recorrido:
                                        {{ number_format(
                                            $trip->return_mileage - $trip->departure_mileage
                                        ) }} km
                                    </p>

                                @endif

                            </td>


                            {{-- ESTADO --}}
                            <td class="px-6 py-5">

                                @if($trip->status === 'EN_USO')

                                    <span class="inline-flex items-center
                                                 px-3 py-1 rounded-full
                                                 bg-amber-500/10
                                                 text-amber-400
                                                 border border-amber-500/20
                                                 text-xs font-bold">

                                        EN USO

                                    </span>

                                @elseif($trip->status === 'RETORNADO')

    <span class="inline-flex items-center
                 px-3 py-1 rounded-full
                 bg-emerald-500/10
                 text-emerald-400
                 border border-emerald-500/20
                 text-xs font-bold">

        RETORNADO

    </span>

@elseif($trip->status === 'NO_AUTORIZADO')

    <span class="inline-flex items-center
                 px-3 py-1 rounded-full
                 bg-red-500/10
                 text-red-400
                 border border-red-500/20
                 text-xs font-bold">

        NO AUTORIZADO

    </span>

@else

    <span class="inline-flex items-center
                 px-3 py-1 rounded-full
                 bg-slate-500/10
                 text-slate-400
                 border border-slate-500/20
                 text-xs font-bold">

        {{ $trip->status }}

    </span>

@endif

                            </td>

                            {{-- ACCIÓN --}}
                            <td class="px-7 py-6">

                                <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                    {{-- VER DETALLE: SIEMPRE --}}
                                    <a href="{{ route('vehicle-trips.show', $trip) }}"
                                    class="inline-flex items-center justify-center
                                            w-32 px-3 py-2
                                            bg-sky-600 hover:bg-sky-500
                                            text-white text-xs font-bold
                                            rounded-lg transition">
                                        Ver detalle
                                    </a>

                                    {{-- RETORNO: SOLO SI ESTÁ EN USO --}}
                                    @if($trip->status === 'EN_USO')

                                        <a href="{{ route('vehicle-trips.return.create', $trip) }}"
                                        class="inline-flex items-center justify-center
                                                w-32 px-3 py-2
                                                bg-amber-600 hover:bg-amber-500
                                                text-white text-xs font-bold
                                                rounded-lg transition">
                                            Registrar retorno
                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-16 text-center">

                                <div class="text-slate-500">

                                    <svg class="w-12 h-12 mx-auto mb-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M8 7h8m-8 4h8m-8 4h5M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>

                                    </svg>

                                    <p class="font-semibold">
                                        No hay viajes registrados.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}
        @if($trips->hasPages())

            <div class="px-6 py-4 border-t border-slate-700">
                {{ $trips->links() }}
            </div>

        @endif

    </div>


    {{-- REGRESAR --}}
    <div class="mt-8">

        <a href="{{ route('vehiculos.index') }}"
           class="inline-flex items-center gap-3
                  bg-blue-600 hover:bg-blue-500
                  text-white px-6 py-3 rounded-xl
                  shadow-lg shadow-blue-900/20
                  transition font-bold">

            <svg class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

            </svg>

            Regresar a Vehículos

        </a>

    </div>

</div>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: '¡Registro exitoso!',
                text: @json(session('success')),
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
@endif

@endsection