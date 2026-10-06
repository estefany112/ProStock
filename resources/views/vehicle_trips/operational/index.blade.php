@extends('layouts.operational')

@section('title', 'Control Operativo de Viajes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- ENCABEZADO DE LA SECCIÓN --}}
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-white tracking-tight">
            Control Operativo de Viajes
        </h1>
        <p class="text-slate-400 text-sm mt-1">
            Registro de salidas y retornos de vehículos
        </p>
    </div>

    {{-- BOTÓN DE ACCIÓN --}}
    <div class="mb-6 flex justify-end">
        <a href="{{ route('vehicle-trips.operational.departure.create') }}"
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white rounded-xl font-semibold shadow-lg shadow-emerald-900/30 transition-all duration-200 border border-emerald-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Registrar salida
        </a>
    </div>

    {{-- TABLA CON DISEÑO OSCURO / GLASSMORPHISM --}}
    <div class="bg-slate-900/80 backdrop-blur-xl rounded-2xl border border-slate-800/80 shadow-xl overflow-hidden">

        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-950/50 border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">Vehículo</th>
                    <th class="px-6 py-4 font-semibold">Conductor</th>
                    <th class="px-6 py-4 font-semibold">Salida</th>
                    <th class="px-6 py-4 font-semibold">Destino</th>
                    <th class="px-6 py-4 font-semibold text-center">Estado</th>
                    <th class="px-6 py-4 font-semibold text-center">Acción</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-800/60 text-sm text-slate-300">
                @forelse($trips as $trip)
                    <tr class="hover:bg-slate-800/30 transition-colors">

                        <td class="px-6 py-4 font-medium text-white">
                            {{ $trip->vehicle->numero_interno ?? '—' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $trip->driver->name ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-slate-400">
                            {{ $trip->departure_at?->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $trip->destination }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $trip->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('vehicle-trips.operational.return.create', $trip) }}"
                            class="inline-flex items-center justify-center gap-2
                                    px-4 py-2
                                    bg-amber-600 hover:bg-amber-500
                                    text-white text-xs font-bold
                                    rounded-lg transition">

                                Registrar retorno

                            </a>

                        </td>

                    </tr>
                @empty

                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                </svg>
                                <span>No hay vehículos actualmente en uso.</span>
                            </div>
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>

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