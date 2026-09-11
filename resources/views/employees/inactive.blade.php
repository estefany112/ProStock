@extends('layouts.principal')

@section('content')

<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8 animate-fade-in-up flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Historial de <span class="text-slate-400">Empleados Inactivos</span>
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Consulta de empleados que ya no forman parte del personal activo.
            </p>
        </div>

        <a href="{{ route('employees.index') }}"
           class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 shadow-sm active:scale-95">
            <span>←</span> Empleados Activos
        </a>

    </div>


    {{-- MÉTRICA --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">

        <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-xl flex items-center justify-between">
            <div>
                <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                    Total de empleados inactivos
                </span>
                <p class="text-3xl font-extrabold text-white mt-1">
                    {{ $employees->total() }}
                </p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
            </div>
        </div>

    </div>


    {{-- LISTADO DE EMPLEADOS INACTIVOS --}}
    <div class="bg-slate-900 rounded-2xl border border-slate-800 shadow-xl overflow-hidden text-slate-100">

        {{-- BUSCADOR --}}
        <div class="p-5 border-b border-slate-800 bg-slate-900/80 backdrop-blur-sm">
            <div class="w-full lg:w-80">
                <x-search-bar
                    action="{{ route('employees.inactive') }}"
                    placeholder="Buscar empleado inactivo..."
                />
            </div>
        </div>


        {{-- TABLA --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-left">

                <thead class="bg-slate-950/60 border-b border-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            Información
                        </th>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">
                            Puesto
                        </th>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">
                            Fecha de baja
                        </th>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center">
                            Motivo
                        </th>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 text-right">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-800/60">

                    @forelse ($employees as $employee)

                        <tr class="group hover:bg-slate-800/40 transition-colors duration-200">

                            {{-- INFORMACIÓN --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    {{-- AVATAR --}}
                                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center">
                                        <span class="text-sm font-bold text-slate-300">
                                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-slate-100 truncate max-w-[250px] group-hover:text-white">
                                            {{ $employee->name }}
                                        </div>

                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="text-[11px] uppercase tracking-wide text-slate-500 font-medium">
                                                DPI
                                            </span>
                                            <span class="text-xs text-slate-400 font-mono">
                                                {{ $employee->dpi }}
                                            </span>
                                        </div>
                                    </div>

                                </div>

                            </td>


                            {{-- PUESTO --}}
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm font-medium text-slate-300">
                                    {{ $employee->position }}
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    Puesto registrado
                                </div>
                            </td>


                            {{-- FECHA DE BAJA --}}
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <div class="text-sm font-medium text-slate-300 font-mono">
                                    {{ $employee->fecha_baja
                                        ? \Carbon\Carbon::parse($employee->fecha_baja)->format('d/m/Y')
                                        : '—'
                                    }}
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    Fecha de salida
                                </div>
                            </td>


                            {{-- MOTIVO --}}
                            <td class="px-6 py-4 text-center">

                                @if($employee->status === 'renuncia')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-950/60 border border-amber-800/60 text-amber-400">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span class="text-xs font-semibold">Renuncia</span>
                                    </span>

                                @elseif($employee->status === 'despido')

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-950/60 border border-red-800/60 text-red-400">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        <span class="text-xs font-semibold">Despido</span>
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800 border border-slate-700 text-slate-400">
                                        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                        <span class="text-xs font-semibold">{{ ucfirst($employee->status) }}</span>
                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}
                            <td class="px-6 py-4 text-right">

                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('employee.movements.index', $employee) }}"
                                       title="Ver historial"
                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 2 M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </a>
                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M17 20h5v-2a4 4 0 00-4-4h-1 M9 20H4v-2a4 4 0 014-4h1 M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-300">
                                        No hay empleados inactivos registrados.
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        No se encontraron coincidencias en este listado.
                                    </p>
                                </div>
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}
        @if($employees->hasPages())

            <div class="px-5 sm:px-6 py-4 border-t border-slate-800 bg-slate-950/40 text-slate-400">
                {{ $employees->links() }}
            </div>

        @endif

    </div>

</div>


<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
</style>

@endsection