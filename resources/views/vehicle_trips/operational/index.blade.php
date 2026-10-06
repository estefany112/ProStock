@extends('layouts.operational')

@section('title', 'Control Operativo de Viajes')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- ENCABEZADO --}}
    <div class="mb-6 sm:mb-8">

        <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white tracking-tight">
            Control Operativo de Viajes
        </h1>

        <p class="text-slate-400 text-sm sm:text-base mt-1">
            Registro de salidas y retornos de vehículos
        </p>

    </div>


    {{-- BOTÓN REGISTRAR SALIDA --}}
    <div class="mb-6 flex justify-end">

        <a href="{{ route('vehicle-trips.operational.departure.create') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                  px-5 py-3
                  bg-gradient-to-r from-emerald-500 to-emerald-700
                  hover:from-emerald-600 hover:to-emerald-800
                  text-white rounded-xl font-semibold
                  shadow-lg shadow-emerald-900/30
                  transition-all duration-200
                  border border-emerald-500/20">

            <svg class="w-5 h-5 flex-shrink-0"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4">
                </path>

            </svg>

            Registrar salida

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- VERSIÓN MÓVIL / TABLET PEQUEÑA --}}
    {{-- ========================================================= --}}

    <div class="md:hidden space-y-4">

        @forelse($trips as $trip)

            <div class="bg-slate-900/80
                        backdrop-blur-xl
                        border border-slate-800/80
                        rounded-2xl
                        shadow-xl
                        overflow-hidden">

                {{-- CABECERA DE LA TARJETA --}}
                <div class="px-5 py-4
                            bg-slate-950/40
                            border-b border-slate-800
                            flex items-center justify-between gap-3">

                    <div class="min-w-0">

                        <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            Vehículo
                        </p>

                        <p class="text-lg font-bold text-white truncate">
                            {{ $trip->vehicle->numero_interno ?? '—' }}
                        </p>

                    </div>

                    <span class="flex-shrink-0
                                 inline-flex items-center
                                 px-2.5 py-1
                                 rounded-full
                                 text-xs font-semibold
                                 bg-emerald-500/10
                                 text-emerald-400
                                 border border-emerald-500/20">

                        {{ $trip->status }}

                    </span>

                </div>


                {{-- INFORMACIÓN --}}
                <div class="p-5 space-y-4">

                    {{-- CONDUCTOR --}}
                    <div>

                        <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-1">
                            Conductor
                        </p>

                        <p class="text-sm font-medium text-slate-200">
                            {{ $trip->driver->name ?? '—' }}
                        </p>

                    </div>


                    {{-- SALIDA Y DESTINO --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-1">
                                Salida
                            </p>

                            <p class="text-sm text-slate-300">
                                {{ $trip->departure_at?->format('d/m/Y H:i') ?? '—' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-1">
                                Destino
                            </p>

                            <p class="text-sm text-slate-300 break-words">
                                {{ $trip->destination ?? '—' }}
                            </p>

                        </div>

                    </div>


                    {{-- ACCIÓN --}}
                    <div class="pt-4 border-t border-slate-800">

                        <a href="{{ route('vehicle-trips.operational.return.create', $trip) }}"
                           class="w-full inline-flex items-center justify-center gap-2
                                  px-4 py-3
                                  bg-amber-600 hover:bg-amber-500
                                  text-white text-sm font-bold
                                  rounded-xl
                                  transition-all duration-200
                                  active:scale-[0.98]">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M9 14l6-6m0 0H9m6 0v6">
                                </path>

                            </svg>

                            Registrar retorno

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="bg-slate-900/80
                        border border-slate-800
                        rounded-2xl
                        px-6 py-12
                        text-center">

                <div class="flex flex-col items-center justify-center gap-3">

                    <svg class="w-10 h-10 text-slate-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1">
                        </path>

                    </svg>

                    <span class="text-slate-500 text-sm">
                        No hay vehículos actualmente en uso.
                    </span>

                </div>

            </div>

        @endforelse

    </div>


    {{-- ========================================================= --}}
    {{-- VERSIÓN ESCRITORIO --}}
    {{-- ========================================================= --}}

    <div class="hidden md:block
                bg-slate-900/80
                backdrop-blur-xl
                rounded-2xl
                border border-slate-800/80
                shadow-xl
                overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead class="bg-slate-950/50
                              border-b border-slate-800
                              text-slate-400
                              text-xs uppercase tracking-wider">

                    <tr>

                        <th class="px-4 lg:px-6 py-4 font-semibold whitespace-nowrap">
                            Vehículo
                        </th>

                        <th class="px-4 lg:px-6 py-4 font-semibold">
                            Conductor
                        </th>

                        <th class="px-4 lg:px-6 py-4 font-semibold whitespace-nowrap">
                            Salida
                        </th>

                        <th class="px-4 lg:px-6 py-4 font-semibold">
                            Destino
                        </th>

                        <th class="px-4 lg:px-6 py-4 font-semibold text-center">
                            Estado
                        </th>

                        <th class="px-4 lg:px-6 py-4 font-semibold text-center">
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-800/60
                              text-sm text-slate-300">

                    @forelse($trips as $trip)

                        <tr class="hover:bg-slate-800/30 transition-colors">

                            {{-- VEHÍCULO --}}
                            <td class="px-4 lg:px-6 py-4
                                       font-medium text-white
                                       whitespace-nowrap">

                                {{ $trip->vehicle->numero_interno ?? '—' }}

                            </td>


                            {{-- CONDUCTOR --}}
                            <td class="px-4 lg:px-6 py-4">

                                {{ $trip->driver->name ?? '—' }}

                            </td>


                            {{-- SALIDA --}}
                            <td class="px-4 lg:px-6 py-4
                                       text-slate-400
                                       whitespace-nowrap">

                                {{ $trip->departure_at?->format('d/m/Y H:i') ?? '—' }}

                            </td>


                            {{-- DESTINO --}}
                            <td class="px-4 lg:px-6 py-4
                                       max-w-xs">

                                <span class="block truncate"
                                      title="{{ $trip->destination }}">

                                    {{ $trip->destination ?? '—' }}

                                </span>

                            </td>


                            {{-- ESTADO --}}
                            <td class="px-4 lg:px-6 py-4 text-center">

                                <span class="inline-flex items-center
                                             px-2.5 py-1
                                             rounded-full
                                             text-xs font-semibold
                                             bg-emerald-500/10
                                             text-emerald-400
                                             border border-emerald-500/20
                                             whitespace-nowrap">

                                    {{ $trip->status }}

                                </span>

                            </td>


                            {{-- ACCIÓN --}}
                            <td class="px-4 lg:px-6 py-4 text-center">

                                <a href="{{ route('vehicle-trips.operational.return.create', $trip) }}"
                                   class="inline-flex items-center justify-center gap-2
                                          px-4 py-2
                                          bg-amber-600 hover:bg-amber-500
                                          text-white text-xs font-bold
                                          rounded-lg
                                          transition
                                          whitespace-nowrap">

                                    Registrar retorno

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-12 text-center text-slate-500">

                                <div class="flex flex-col items-center justify-center gap-2">

                                    <svg class="w-8 h-8 text-slate-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1">
                                        </path>

                                    </svg>

                                    <span>
                                        No hay vehículos actualmente en uso.
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- MENSAJE DE ÉXITO --}}
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