@extends('layouts.principal')

@section('content')

<div class="max-w-6xl mx-auto pt-20 pb-12 px-4">

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Detalle de salida
            </h1>

            <p class="text-slate-400 text-sm mt-1">
                Información del viaje e inspección previa del vehículo.
            </p>
        </div>

        <div class="flex gap-3">

            @if($trip->status === 'EN_USO')
                <a href="{{ route('vehicle-trips.return.create', $trip) }}"
                   class="bg-amber-600 hover:bg-amber-500 text-white
                          px-5 py-3 rounded-xl font-bold transition">
                    Registrar retorno
                </a>
            @endif

            <a href="{{ route('vehicle-trips.index') }}"
               class="bg-slate-700 hover:bg-slate-600 text-white
                      px-5 py-3 rounded-xl font-bold transition">
                Regresar
            </a>

        </div>

    </div>


    {{-- =====================================================
        INFORMACIÓN GENERAL
    ====================================================== --}}

    <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700
                rounded-3xl shadow-2xl overflow-hidden mb-8">

        <div class="bg-slate-900/40 px-6 py-5 border-b border-slate-700
                    flex items-center justify-between">

            <h2 class="text-lg font-bold text-white">
                Información del viaje
            </h2>

            @php
                $statusClasses = match($trip->status) {
                    'EN_USO' =>
                        'bg-amber-500/10 text-amber-400 border-amber-500/20',

                    'RETORNADO' =>
                        'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',

                    'NO_AUTORIZADO' =>
                        'bg-red-500/10 text-red-400 border-red-500/20',

                    default =>
                        'bg-slate-500/10 text-slate-300 border-slate-500/20',
                };
            @endphp

            <span class="px-3 py-1 rounded-full border text-xs font-bold
                         {{ $statusClasses }}">
                {{ $trip->status }}
            </span>

        </div>

                   {{-- =====================================================
                ALERTA DE SALIDA NO AUTORIZADA
            ====================================================== --}}

            @if($trip->status === 'NO_AUTORIZADO')

                <div class="mb-8 bg-red-500/10 border border-red-500/30
                            rounded-2xl p-5">

                    <div class="flex items-start gap-4">

                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-red-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-red-400 font-bold">
                                Salida no autorizada
                            </h3>

                            <p class="text-red-200/80 text-sm mt-1">
                                La inspección previa determinó que el vehículo
                                NO ES APTO para circular. La inspección quedó
                                registrada, pero la salida del vehículo no fue autorizada.
                            </p>
                        </div>

                    </div>

                </div>

            @endif

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- VEHÍCULO --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Vehículo
                </p>

                <p class="text-white font-semibold">
                    {{ $trip->vehicle->numero_interno ?? '—' }}
                </p>

                <p class="text-slate-400 text-sm">
                    {{ $trip->vehicle->marca ?? '' }}
                    {{ $trip->vehicle->placa ? ' - '.strtoupper($trip->vehicle->placa) : '' }}
                </p>
            </div>


            {{-- CONDUCTOR --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Conductor
                </p>

                <p class="text-white font-semibold">
                    {{ $trip->driver->name ?? '—' }}
                </p>

                <p class="text-slate-400 text-sm">
                    {{ $trip->driver->codigo_personal ?? '' }}
                </p>
            </div>


            {{-- REGISTRADO POR --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Registrado por
                </p>

                <p class="text-white font-semibold">
                    {{ $trip->registeredByEmployee->name ?? '—' }}
                </p>

                <p class="text-slate-400 text-sm">
                    {{ $trip->registeredByEmployee->codigo_personal ?? '' }}
                </p>
            </div>


            {{-- FECHA SALIDA --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Fecha y hora de salida
                </p>

                <p class="text-white">
                    {{ $trip->departure_at
                        ? $trip->departure_at->format('d/m/Y H:i')
                        : '—' }}
                </p>
            </div>


            {{-- KILOMETRAJE --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Kilometraje de salida
                </p>

                <p class="text-white">
                    {{ number_format($trip->departure_mileage, 0, '.', ',') }} km
                </p>
            </div>


            {{-- COMBUSTIBLE --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Combustible de salida
                </p>

                <p class="text-white">
                    {{ $trip->departure_fuel }}
                </p>
            </div>


            {{-- DESTINO --}}
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                    Destino
                </p>

                <p class="text-white">
                    {{ $trip->destination }}
                </p>
            </div>

        </div>

    </div>


    {{-- =====================================================
        ACOMPAÑANTES
    ====================================================== --}}

    <div class="bg-slate-800/50 border border-slate-700
                rounded-3xl overflow-hidden mb-8">

        <div class="bg-slate-900/40 px-6 py-5 border-b border-slate-700">

            <h2 class="text-lg font-bold text-white">
                Acompañantes
            </h2>

        </div>


        <div class="p-6">

            @forelse($trip->passengers as $passenger)

                <div class="py-3 border-b border-slate-700/50 last:border-0">

                    <p class="text-white font-medium">
                        {{ $passenger->employee->name ?? 'Empleado no disponible' }}
                    </p>

                    <p class="text-slate-500 text-xs">
                        {{ $passenger->employee->codigo_personal ?? '' }}
                    </p>

                </div>

            @empty

                <p class="text-slate-500">
                    Esta salida no tiene acompañantes registrados.
                </p>

            @endforelse

        </div>

    </div>


    {{-- =====================================================
        CHECKLIST
    ====================================================== --}}

    @if($trip->checklist)

        @php
            $resultClasses = match($trip->checklist->result) {

                'APTO' =>
                    'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',

                'APTO_CON_OBSERVACIONES' =>
                    'bg-amber-500/10 text-amber-400 border-amber-500/20',

                'NO_APTO' =>
                    'bg-red-500/10 text-red-400 border-red-500/20',

                default =>
                    'bg-slate-500/10 text-slate-300 border-slate-500/20',
            };
        @endphp


        <div class="bg-slate-800/50 border border-slate-700
                    rounded-3xl overflow-hidden mb-8">

            {{-- RESULTADO --}}
            <div class="bg-slate-900/40 px-6 py-5 border-b border-slate-700
                        flex flex-col sm:flex-row sm:items-center
                        sm:justify-between gap-3">

                <div>

                    <h2 class="text-lg font-bold text-white">
                        Inspección previa
                    </h2>

                    <p class="text-slate-500 text-sm mt-1">
                        {{ $trip->checklist->inspected_at
                            ? $trip->checklist->inspected_at->format('d/m/Y H:i')
                            : '' }}
                    </p>

                </div>


                <span class="px-4 py-2 rounded-xl border text-sm font-bold
                             {{ $resultClasses }}">

                    {{ str_replace('_', ' ', $trip->checklist->result) }}

                </span>

            </div>


            {{-- PUNTOS --}}
            <div class="p-6 space-y-8">

                @foreach(
                    $trip->checklist->items
                        ->sortBy(fn($item) => $item->catalog->sort_order ?? 999)
                        ->groupBy(fn($item) => $item->catalog->category ?? 'Sin categoría')
                    as $category => $items
                )

                    <div>

                        <h3 class="text-emerald-400 font-bold
                                   border-b border-slate-700 pb-3 mb-4">
                            {{ $category }}
                        </h3>


                        <div class="space-y-4">

                            @foreach($items as $checklistItem)

                                @php
                                    $catalog = $checklistItem->catalog;

                                    $responseClasses = match($checklistItem->response) {

                                        'OK' =>
                                            'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',

                                        'MAL_FUNCIONAMIENTO' =>
                                            'bg-amber-500/10 text-amber-400 border-amber-500/20',

                                        'FALLA' =>
                                            'bg-red-500/10 text-red-400 border-red-500/20',

                                        default =>
                                            'bg-slate-500/10 text-slate-300 border-slate-500/20',
                                    };
                                @endphp


                                <div class="bg-slate-900/30 border border-slate-700
                                            rounded-2xl p-5">

                                    <div class="flex flex-col md:flex-row
                                                md:items-start md:justify-between
                                                gap-3">

                                        <div>

                                            <div class="flex items-center gap-2 flex-wrap">

                                                <p class="text-white font-semibold">

                                                    {{ $catalog->sort_order ?? '' }}.
                                                    {{ $catalog->name ?? 'Punto eliminado' }}

                                                </p>


                                                @if($catalog?->is_critical)

                                                    <span class="text-xs
                                                                 bg-red-500/10
                                                                 text-red-400
                                                                 border
                                                                 border-red-500/20
                                                                 rounded-full
                                                                 px-2 py-1">
                                                        Crítico
                                                    </span>

                                                @endif

                                            </div>


                                            @if($catalog?->description)

                                                <p class="text-slate-500 text-sm mt-1">
                                                    {{ $catalog->description }}
                                                </p>

                                            @endif

                                        </div>


                                        <span class="px-3 py-1 rounded-lg
                                                     border text-xs font-bold
                                                     whitespace-nowrap
                                                     {{ $responseClasses }}">

                                            {{ str_replace(
                                                '_',
                                                ' ',
                                                $checklistItem->response
                                            ) }}

                                        </span>

                                    </div>


                                    {{-- OBSERVACIÓN --}}
                                    @if($checklistItem->observation)

                                        <div class="mt-4 bg-slate-950/40
                                                    rounded-xl p-4">

                                            <p class="text-slate-500
                                                      text-xs uppercase
                                                      font-bold mb-1">
                                                Observación
                                            </p>

                                            <p class="text-slate-300">
                                                {{ $checklistItem->observation }}
                                            </p>

                                        </div>

                                    @endif


                                    {{-- FOTOGRAFÍAS --}}
                                    @if($checklistItem->photos->isNotEmpty())

                                        <div class="mt-4">

                                            <p class="text-slate-500
                                                      text-xs uppercase
                                                      font-bold mb-3">
                                                Evidencia fotográfica
                                            </p>


                                            <div class="grid grid-cols-2
                                                        md:grid-cols-3
                                                        lg:grid-cols-4
                                                        gap-4">

                                                @foreach($checklistItem->photos as $photo)

                                                    <a href="{{ asset('storage/'.$photo->path) }}"
                                                       target="_blank"
                                                       class="block group">

                                                        <img
                                                            src="{{ asset('storage/'.$photo->path) }}"
                                                            alt="Evidencia de {{ $catalog->name ?? 'inspección' }}"
                                                            class="w-full h-40
                                                                   object-cover
                                                                   rounded-xl
                                                                   border
                                                                   border-slate-700
                                                                   group-hover:border-emerald-500
                                                                   transition">

                                                    </a>

                                                @endforeach

                                            </div>

                                        </div>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    @else

        {{-- VIAJES ANTIGUOS SIN CHECKLIST --}}
        <div class="bg-slate-800/50 border border-slate-700
                    rounded-3xl p-6 mb-8">

            <p class="text-slate-400">
                Esta salida no tiene una inspección previa registrada.
            </p>

        </div>

    @endif


    {{-- =====================================================
        INFORMACIÓN DEL RETORNO
    ====================================================== --}}

    @if($trip->status === 'RETORNADO')

        <div class="bg-slate-800/50 border border-slate-700
                    rounded-3xl overflow-hidden">

            <div class="bg-slate-900/40 px-6 py-5
                        border-b border-slate-700">

                <h2 class="text-lg font-bold text-white">
                    Información del retorno
                </h2>

            </div>


            <div class="p-6 grid grid-cols-1 md:grid-cols-2
                        lg:grid-cols-3 gap-6">

                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                        Fecha y hora de retorno
                    </p>

                    <p class="text-white">
                        {{ $trip->return_at
                            ? $trip->return_at->format('d/m/Y H:i')
                            : '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                        Kilometraje de retorno
                    </p>

                    <p class="text-white">
                        {{ $trip->return_mileage !== null
                            ? number_format($trip->return_mileage, 0, '.', ',').' km'
                            : '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                        Combustible de retorno
                    </p>

                    <p class="text-white">
                        {{ $trip->return_fuel ?? '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                        Retorno registrado por
                    </p>

                    <p class="text-white">
                        {{ $trip->returnedByEmployee->name ?? '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                        Kilómetros recorridos
                    </p>

                    <p class="text-white font-semibold">

                        @if(
                            $trip->return_mileage !== null
                            && $trip->departure_mileage !== null
                        )

                            {{ number_format(
                                $trip->return_mileage - $trip->departure_mileage,
                                0,
                                '.',
                                ','
                            ) }} km

                        @else
                            —
                        @endif

                    </p>
                </div>


                <div class="md:col-span-2 lg:col-span-3">

                    <p class="text-slate-500 text-xs uppercase font-bold mb-1">
                        Observaciones del retorno
                    </p>

                    <p class="text-slate-300">
                        {{ $trip->return_observations ?: 'Sin observaciones.' }}
                    </p>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection