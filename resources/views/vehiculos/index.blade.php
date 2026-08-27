@extends('layouts.principal')

@section('content')

<div class="max-w-7xl mx-auto pt-8 pb-10 px-4 sm:px-6 lg:px-8">

{{-- =========================================================
    HEADER
========================================================== --}}
<div class="bg-slate-800/40 border border-slate-700/70 rounded-3xl p-6 mb-6 overflow-hidden">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

        {{-- INFORMACIÓN --}}
        <div class="flex items-center gap-5">

            {{-- ÍCONO --}}
            <div class="hidden sm:flex w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 items-center justify-center text-blue-400 shrink-0">

                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.75"
                          d="M5 17h14M7 17V9l2-4h6l2 4v8M5 17a2 2 0 01-2-2v-3a2 2 0 012-2h14a2 2 0 012 2v3a2 2 0 01-2 2M7 17v2m10-2v2M8 10h8"/>

                </svg>

            </div>

            <div>

                {{-- BIENVENIDA --}}
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold mb-2">

                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                    </svg>

                    <span>
                        ¡Bienvenido, {{ Auth::user()->name ?? 'Administrador' }}!
                    </span>

                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Gestión de Vehículos
                </h1>

                <p class="text-slate-400 text-sm mt-1">
                    Administra y controla el parque automotor de
                    <span class="text-slate-300 font-medium">PROSERVE</span>
                </p>

            </div>

        </div>


        {{-- ILUSTRACIÓN + BOTÓN --}}
        <div class="flex flex-col sm:flex-row items-center gap-5">

            {{-- ILUSTRACIÓN --}}
            <div class="w-28 sm:w-36 md:w-40 lg:w-48 shrink-0" aria-hidden="true">

                <style>

                    @keyframes flotarCarro {

                        0%, 100% {
                            transform: translateY(0px);
                        }

                        50% {
                            transform: translateY(-4px);
                        }

                    }

                    .animar-carro {
                        animation: flotarCarro 3s ease-in-out infinite;
                    }

                </style>

                <svg viewBox="0 0 400 220"
                     class="w-full h-auto drop-shadow-xl animar-carro">

                    <defs>

                        <linearGradient id="carroCarroceria" x1="0" y1="0" x2="0" y2="1">

                            <stop offset="0%" stop-color="#60A5FA"/>
                            <stop offset="55%" stop-color="#2563EB"/>
                            <stop offset="100%" stop-color="#1D4ED8"/>

                        </linearGradient>

                        <linearGradient id="carroVidrio" x1="0" y1="0" x2="0" y2="1">

                            <stop offset="0%" stop-color="#E2E8F0"/>
                            <stop offset="100%" stop-color="#94A3B8"/>

                        </linearGradient>

                        <radialGradient id="carroLlanta" cx="35%" cy="35%" r="65%">

                            <stop offset="0%" stop-color="#475569"/>
                            <stop offset="100%" stop-color="#0F172A"/>

                        </radialGradient>

                        <radialGradient id="carroSombra" cx="50%" cy="50%" r="50%">

                            <stop offset="0%" stop-color="#000000" stop-opacity="0.45"/>
                            <stop offset="100%" stop-color="#000000" stop-opacity="0"/>

                        </radialGradient>

                        <linearGradient id="carroBrillo" x1="0" y1="0" x2="1" y2="1">

                            <stop offset="0%" stop-color="#FFFFFF" stop-opacity="0.55"/>
                            <stop offset="100%" stop-color="#FFFFFF" stop-opacity="0"/>

                        </linearGradient>

                    </defs>


                    <ellipse cx="200"
                             cy="185"
                             rx="150"
                             ry="18"
                             fill="url(#carroSombra)"/>


                    <path d="M45 140 L60 95 Q75 65 110 62 L145 60
                             Q170 40 210 40 L255 42 Q290 45 310 70
                             L340 95 Q365 100 368 125 L368 140
                             Q368 152 356 152 L52 152 Q40 152 40 140 Z"
                          fill="url(#carroCarroceria)"
                          stroke="#1E3A8A"
                          stroke-width="2"/>


                    <path d="M75 90 Q120 55 210 52 L305 58
                             Q330 72 340 92 L320 92
                             Q290 66 210 64 Q140 66 100 92 Z"
                          fill="url(#carroBrillo)"/>


                    <path d="M115 88 Q125 68 150 65 L178 64 L178 88 Z"
                          fill="url(#carroVidrio)"
                          stroke="#334155"
                          stroke-width="1.5"/>


                    <path d="M188 64 L245 65 Q268 68 282 88 L188 88 Z"
                          fill="url(#carroVidrio)"
                          stroke="#334155"
                          stroke-width="1.5"/>


                    <line x1="183"
                          y1="64"
                          x2="183"
                          y2="88"
                          stroke="#1E3A8A"
                          stroke-width="2"/>


                    <rect x="205"
                          y="102"
                          width="22"
                          height="5"
                          rx="2.5"
                          fill="#1E3A8A"/>


                    <ellipse cx="352"
                             cy="112"
                             rx="9"
                             ry="7"
                             fill="#FDE68A"/>


                    <ellipse cx="55"
                             cy="118"
                             rx="7"
                             ry="6"
                             fill="#F87171"/>


                    {{-- LLANTA TRASERA --}}
                    <g>

                        <circle cx="115"
                                cy="152"
                                r="28"
                                fill="url(#carroLlanta)"
                                stroke="#0F172A"
                                stroke-width="2"/>

                        <circle cx="115"
                                cy="152"
                                r="11"
                                fill="#94A3B8"/>

                        <line x1="115"
                              y1="124"
                              x2="115"
                              y2="180"
                              stroke="#0F172A"
                              stroke-width="1.5"/>

                        <line x1="87"
                              y1="152"
                              x2="143"
                              y2="152"
                              stroke="#0F172A"
                              stroke-width="1.5"/>

                    </g>


                    {{-- LLANTA DELANTERA --}}
                    <g>

                        <circle cx="295"
                                cy="152"
                                r="28"
                                fill="url(#carroLlanta)"
                                stroke="#0F172A"
                                stroke-width="2"/>

                        <circle cx="295"
                                cy="152"
                                r="11"
                                fill="#94A3B8"/>

                        <line x1="295"
                              y1="124"
                              x2="295"
                              y2="180"
                              stroke="#0F172A"
                              stroke-width="1.5"/>

                        <line x1="267"
                              y1="152"
                              x2="323"
                              y2="152"
                              stroke="#0F172A"
                              stroke-width="1.5"/>

                    </g>

                </svg>

            </div>


            @if(auth()->user()->hasPermission('edit_vehicles') || auth()->user()->hasPermission('delete_vehicles'))

                {{-- BOTÓN --}}
                <a href="{{ route('vehiculos.create') }}"
                   class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 text-white px-5 py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 font-semibold shadow-lg shadow-blue-600/25">

                    <svg class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2.5"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>

                    </svg>

                    Registrar Vehículo

                </a>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
    MENSAJE DE ÉXITO
========================================================== --}}
@if(session('success'))

    <div class="mb-6 p-4 rounded-xl
                bg-emerald-500/10
                border border-emerald-500/20
                text-emerald-400
                text-sm
                flex items-center gap-3">

        <svg class="w-5 h-5 flex-shrink-0"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

        </svg>

        <span>{{ session('success') }}</span>

    </div>

@endif


{{-- =========================================================
    ESTADÍSTICAS
========================================================== --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">


    {{-- TOTAL --}}
    <div class="bg-slate-800/60 border border-slate-700/80 p-5 rounded-2xl
                flex items-center justify-between backdrop-blur-sm">

        <div>

            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">
                Total de vehículos
            </p>

            <h3 class="text-2xl font-bold text-white mt-1">
                {{ count($vehiculos) }}
            </h3>

        </div>

        <div class="p-2.5 bg-blue-500/10 rounded-xl text-blue-400">

            <svg class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.75"
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>

            </svg>

        </div>

    </div>


    {{-- MARCAS --}}
    <div class="bg-slate-800/60 border border-slate-700/80 p-5 rounded-2xl
                flex items-center justify-between backdrop-blur-sm">

        <div>

            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">
                Marcas distintas
            </p>

            <h3 class="text-2xl font-bold text-white mt-1">
                {{ collect($vehiculos)->pluck('marca')->unique()->count() }}
            </h3>

        </div>

        <div class="p-2.5 bg-indigo-500/10 rounded-xl text-indigo-400">

            <svg class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.75"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5.586 5.586a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"/>

            </svg>

        </div>

    </div>


    {{-- AÑO MÁS RECIENTE --}}
    <div class="bg-slate-800/60 border border-slate-700/80 p-5 rounded-2xl
                flex items-center justify-between backdrop-blur-sm">

        <div>

            <p class="text-slate-400 text-xs font-medium uppercase tracking-wide">
                Año más reciente
            </p>

            <h3 class="text-2xl font-bold text-white mt-1">
                {{ collect($vehiculos)->max('anio') ?? '—' }}
            </h3>

        </div>

        <div class="p-2.5 bg-emerald-500/10 rounded-xl text-emerald-400">

            <svg class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.75"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5v12a2 2 0 002 2z"/>

            </svg>

        </div>

    </div>

</div>


{{-- =========================================================
    LISTADO
========================================================== --}}
<div class="bg-slate-800/60
            border border-slate-700/80
            rounded-2xl
            overflow-hidden
            backdrop-blur-sm
            shadow-xl">


    {{-- BARRA SUPERIOR --}}
    <div class="p-5 border-b border-slate-700/80
                flex flex-col sm:flex-row
                sm:items-center
                sm:justify-between
                gap-4">

        <div>

            <h2 class="text-lg font-semibold text-white">
                Vehículos registrados
            </h2>

            <p class="text-xs text-slate-500 mt-1">
                Consulta y administra los vehículos de la empresa.
            </p>

        </div>


        {{-- BUSCADOR --}}
        <div class="relative w-full sm:w-80">

            <svg class="w-4 h-4 text-slate-500
                        absolute left-3 top-1/2
                        -translate-y-1/2"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>

            </svg>


            <input
                type="text"
                id="buscador-vehiculos"
                placeholder="Buscar por placa, marca o tipo..."
                class="w-full bg-slate-900/60
                       border border-slate-700
                       text-slate-200
                       text-sm
                       rounded-xl
                       pl-9 pr-3 py-2.5
                       placeholder-slate-500
                       focus:outline-none
                       focus:ring-2
                       focus:ring-blue-500
                       focus:border-transparent"
                autocomplete="off"
            >

        </div>

    </div>


    {{-- =========================================================
        TABLA
    ========================================================== --}}
    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead>

                <tr class="bg-slate-900/50
                           text-slate-400
                           text-xs uppercase
                           tracking-wider
                           border-b border-slate-700/80">

                    {{-- NÚMERO INTERNO --}}
                    <th class="px-6 py-3 font-semibold">
                        No. Interno
                    </th>


                    {{-- PLACA --}}
                    <th class="px-6 py-3 font-semibold">
                        Placa
                    </th>


                    {{-- TIPO --}}
                    <th class="px-6 py-3 font-semibold">
                        Tipo
                    </th>


                    {{-- MARCA --}}
                    <th class="px-6 py-3 font-semibold">
                        Marca
                    </th>


                    {{-- AÑO --}}
                    <th class="px-6 py-3 font-semibold">
                        Año
                    </th>


                    {{-- COLOR --}}
                    <th class="px-6 py-3 font-semibold">
                        Color
                    </th>


                    {{-- ACCIONES --}}
                    @if(auth()->user()->hasPermission('edit_vehicles') || auth()->user()->hasPermission('delete_vehicles'))

                        <th class="px-6 py-3 font-semibold text-right">
                            Acciones
                        </th>

                    @endif

                </tr>

            </thead>


            <tbody
                class="divide-y divide-slate-700/40"
                id="cuerpo-tabla-vehiculos">


                @forelse($vehiculos as $vehiculo)

                    <tr
                        class="text-slate-300 hover:bg-slate-700/20 transition-colors"

                        {{-- BUSCADOR: PLACA + MARCA + TIPO --}}
                        data-busqueda="{{ strtolower($vehiculo->placa.' '.$vehiculo->marca.' '.$vehiculo->tipo) }}">


                        {{-- =================================================
                            NÚMERO INTERNO
                        ================================================== --}}
                        <td class="px-6 py-4">

                            <span class="inline-flex items-center
                                         px-3 py-1.5
                                         rounded-lg
                                         bg-blue-500/10
                                         border border-blue-500/20
                                         text-blue-400
                                         font-mono
                                         text-sm
                                         font-bold
                                         tracking-wide">

                                {{ $vehiculo->numero_interno ?? 'Pendiente' }}

                            </span>

                        </td>


                        {{-- =================================================
                            PLACA
                        ================================================== --}}
                        <td class="px-6 py-4">

                            <span class="inline-flex items-center
                                         px-2.5 py-1
                                         rounded-lg
                                         bg-slate-900/70
                                         border border-slate-700
                                         text-slate-200
                                         font-mono
                                         text-sm
                                         font-semibold
                                         tracking-wide">

                                {{ $vehiculo->placa }}

                            </span>

                        </td>


                        {{-- =================================================
                            TIPO
                        ================================================== --}}
                        <td class="px-6 py-4">

                            @php

                                $tipos = [

                                    'pickup' => 'Pickup',
                                    'carro' => 'Carro',
                                    'camion' => 'Camión',
                                    'moto' => 'Moto',
                                    'trimoto' => 'Trimoto',
                                    'otro' => 'Otro',

                                ];

                            @endphp


                            <span class="inline-flex items-center
                                         px-2.5 py-1
                                         rounded-lg
                                         bg-blue-500/10
                                         border border-blue-500/20
                                         text-blue-400
                                         text-xs
                                         font-semibold">

                                {{ $tipos[$vehiculo->tipo] ?? ucfirst($vehiculo->tipo) }}

                            </span>

                        </td>


                        {{-- =================================================
                            MARCA
                        ================================================== --}}
                        <td class="px-6 py-4">

                            <div class="font-semibold text-white">

                                {{ $vehiculo->marca }}

                            </div>

                        </td>


                        {{-- =================================================
                            AÑO
                        ================================================== --}}
                        <td class="px-6 py-4">

                            <span class="px-2.5 py-1
                                         rounded-lg
                                         bg-slate-700/50
                                         text-slate-300
                                         text-xs
                                         font-semibold">

                                {{ $vehiculo->anio }}

                            </span>

                        </td>


                        {{-- =================================================
                            COLOR
                        ================================================== --}}
                        <td class="px-6 py-4">

                            <span class="inline-flex items-center gap-2
                                         text-sm text-slate-300">

                                <span class="w-2.5 h-2.5
                                             rounded-full
                                             bg-slate-400">
                                </span>

                                {{ $vehiculo->color }}

                            </span>

                        </td>


                        {{-- =================================================
                            ACCIONES
                        ================================================== --}}
                        @if(auth()->user()->hasPermission('edit_vehicles') || auth()->user()->hasPermission('delete_vehicles'))

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">


                                    {{-- EDITAR --}}
                                    <a href="{{ route('vehiculos.edit', $vehiculo->id) }}"
                                       class="inline-flex items-center gap-1.5
                                              px-3 py-1.5
                                              bg-slate-700/40
                                              border border-slate-600/60
                                              text-slate-300
                                              hover:bg-blue-600
                                              hover:border-blue-600
                                              hover:text-white
                                              rounded-lg
                                              transition-colors
                                              text-sm font-medium">

                                        <svg class="w-3.5 h-3.5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>

                                        </svg>

                                        Editar

                                    </a>


                                    {{-- ELIMINAR --}}
                                    <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}"
                                          method="POST"
                                          class="form-eliminar-vehiculo">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5
                                                       px-3 py-1.5
                                                       bg-red-500/10
                                                       border border-red-500/20
                                                       text-red-400
                                                       hover:bg-red-600
                                                       hover:border-red-600
                                                       hover:text-white
                                                       rounded-lg
                                                       transition-colors
                                                       text-sm font-medium">

                                            Eliminar

                                        </button>

                                    </form>

                                </div>

                            </td>

                        @endif

                    </tr>


                @empty

                    <tr>

                        <td colspan="{{ (auth()->user()->hasPermission('edit_vehicles') || auth()->user()->hasPermission('delete_vehicles')) ? 7 : 6 }}"
                            class="px-6 py-16 text-center">


                            <div class="flex flex-col
                                        items-center
                                        justify-center
                                        gap-3">


                                <div class="w-14 h-14
                                            bg-slate-900/60
                                            border border-slate-700
                                            rounded-xl
                                            flex items-center
                                            justify-center
                                            text-slate-600">

                                    <svg class="w-7 h-7"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a2 2 0 01.293.707V19a2 2 0 01-2 2z"/>

                                    </svg>

                                </div>


                                <div>

                                    <p class="text-slate-300 font-medium">
                                        No hay vehículos registrados todavía.
                                    </p>

                                    <p class="text-slate-500 text-sm mt-1">
                                        Registra el primer vehículo para comenzar a construir tu flota.
                                    </p>

                                </div>


                                <a href="{{ route('vehiculos.create') }}"
                                   class="mt-2 inline-flex items-center gap-2
                                          px-4 py-2
                                          bg-blue-600
                                          hover:bg-blue-500
                                          text-white
                                          rounded-xl
                                          text-sm
                                          font-semibold
                                          transition-colors">

                                    Registrar Vehículo

                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- SIN RESULTADOS --}}
        <div id="sin-resultados-busqueda"
             class="hidden px-6 py-12 text-center text-slate-500 text-sm">

            No se encontraron vehículos que coincidan con tu búsqueda.

        </div>

    </div>

</div>

</div>

{{-- =========================================================
BUSCADOR
========================================================== --}}

<script>

(function () {

    const input =
        document.getElementById('buscador-vehiculos');

    const filas =
        document.querySelectorAll(
            '#cuerpo-tabla-vehiculos tr[data-busqueda]'
        );

    const sinResultados =
        document.getElementById('sin-resultados-busqueda');


    if (!input) return;


    input.addEventListener('input', function () {

        const termino =
            this.value.trim().toLowerCase();

        let visibles = 0;


        filas.forEach(function (fila) {

            const coincide =
                fila.dataset.busqueda.includes(termino);


            fila.classList.toggle(
                'hidden',
                !coincide
            );


            if (coincide) {

                visibles++;

            }

        });


        if (sinResultados) {

            sinResultados.classList.toggle(
                'hidden',
                visibles !== 0
            );

        }

    });

})();

</script>

{{-- =========================================================
ALERTA DE CONFIRMACIÓN PARA ELIMINAR VEHÍCULO
========================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('.form-eliminar-vehiculo')
        .forEach(function (form) {


            form.addEventListener('submit', function (e) {

                e.preventDefault();


                Swal.fire({

                    title: '¿Eliminar vehículo?',

                    text: 'Esta acción no se puede deshacer.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Sí, eliminar',

                    cancelButtonText: 'Cancelar',

                    reverseButtons: true,

                    background: '#1e293b',

                    color: '#f8fafc',

                    confirmButtonColor: '#dc2626',

                    cancelButtonColor: '#475569'

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
