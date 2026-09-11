@extends('layouts.principal')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HEADER MODERNO CON BOTÓN --}}
    <div class="mb-8 animate-fade-in-up flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">
                Gestión de <span class="text-indigo-600">Talento Humano</span>
            </h1>
            <p class="text-slate-500 mt-1">Directorio y control administrativo de tu equipo.</p>
        </div>

        @if(auth()->user()->hasPermission('employee.create'))
            <a href="{{ route('employees.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                <span>➕</span> Nuevo Empleado
            </a>
        @endif
    </div>

    {{-- DASHBOARD DE MÉTRICAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    
    <!-- Tarjeta 1: Total de empleados activos -->
    <div class="relative bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden group">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>
        <div class="flex items-center justify-between">
            <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total Activos</span>
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <!-- Icono opcional (SVG) -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-slate-800 mt-3">{{ $totalEmpleadosActivos }}</p>
    </div>

    <!-- Tarjeta 2: Inactivos (Enlace) -->
    <a href="{{ route('employees.inactive') }}" 
       class="relative bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200 overflow-hidden group block">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-slate-400 group-hover:bg-slate-600 transition-colors"></div>
        <div class="flex items-center justify-between">
            <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Inactivos</span>
            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-slate-200 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>
        <div class="flex items-baseline justify-between mt-3">
            <p class="text-3xl font-extrabold text-slate-800">{{ $totalEmpleadosInactivos }}</p>
            <span class="text-xs font-medium text-indigo-600 group-hover:translate-x-1 transition-transform flex items-center gap-1">
                Ver más &rarr;
            </span>
        </div>
    </a>

</div>

{{-- ============================================================
    LISTADO DE EMPLEADOS — DISEÑO OSCURO FORMAL (ENTERPRISE)
============================================================ --}}

<div class="bg-slate-900 rounded-2xl border border-slate-800 shadow-xl overflow-hidden text-slate-100">

    {{-- HEADER --}}
    <div class="px-5 sm:px-6 py-5 border-b border-slate-800 bg-slate-900/80 backdrop-blur-sm">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- TÍTULO --}}
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 text-slate-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1
                                     M9 20H4v-2a4 4 0 014-4h1
                                     M12 12a4 4 0 100-8 4 4 0 000 8z
                                     M16 3.13a4 4 0 010 7.75
                                     M8 3.13a4 4 0 000 7.75"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-white tracking-wide">
                            Personal registrado
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-400 mt-0.5">
                            Gestión y control de empleados
                        </p>
                    </div>
                </div>
            </div>

            {{-- BUSCADOR --}}
            <div class="w-full lg:w-80">
                <x-search-bar
                    action="{{ route('employees.index') }}"
                    placeholder="Buscar por nombre o DPI..."
                />
            </div>

        </div>
    </div>


    {{-- INFORMACIÓN SUPERIOR --}}
    <div class="px-5 sm:px-6 py-3 bg-slate-950/40 border-b border-slate-800">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

            <div class="flex items-center gap-2 text-xs text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></span>

                <span>
                    Información actualizada del personal
                </span>
            </div>

            <div class="text-xs font-medium text-slate-400">
                {{ $employees->total() ?? $employees->count() }} registros
            </div>

        </div>

    </div>


    {{-- TABLA --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[850px] text-left">

            {{-- CABECERA --}}
            <thead class="bg-slate-950/60 border-b border-slate-800">

                <tr>

                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        Empleado
                    </th>

                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">
                        Puesto
                    </th>

                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">
                        Salario base
                    </th>

                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center">
                        Estado
                    </th>

                    <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 text-right">
                        Acciones
                    </th>

                </tr>

            </thead>


            {{-- CUERPO --}}
            <tbody class="divide-y divide-slate-800/60">

                @forelse ($employees as $employee)

                    <tr class="group hover:bg-slate-800/40 transition-colors duration-200">

                        {{-- EMPLEADO --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                {{-- AVATAR --}}
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center">

                                    <span class="text-sm font-bold text-slate-300">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </span>

                                </div>


                                {{-- INFORMACIÓN --}}
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


                        {{-- SALARIO --}}
                        <td class="px-6 py-4 hidden sm:table-cell">

                            <div class="text-sm font-semibold text-slate-200">
                                Q{{ number_format($employee->salary_base, 2) }}
                            </div>

                            <div class="text-xs text-slate-500 mt-0.5">
                                Salario base
                            </div>

                        </td>


                        {{-- ESTADO --}}
                        <td class="px-6 py-4 text-center">

                            @if($employee->active)

                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-950/60 border border-emerald-800/60 text-emerald-400">

                                    <span class="relative flex h-2 w-2">
                                        <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-60"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>

                                    <span class="text-xs font-semibold">
                                        Activo
                                    </span>

                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800 border border-slate-700 text-slate-400">

                                    <span class="w-2 h-2 rounded-full bg-slate-500"></span>

                                    <span class="text-xs font-semibold">
                                        Inactivo
                                    </span>

                                </span>

                            @endif

                        </td>


                        {{-- ACCIONES --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-end gap-1">

                                {{-- EDITAR --}}
                                @if($employee->status == 'activo' && $employee->active == 1)

                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                       title="Editar empleado"
                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all duration-200">

                                        <svg class="w-4 h-4"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.8"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                                     M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>

                                        </svg>

                                    </a>

                                @endif


                                {{-- HISTORIAL --}}
                                <a href="{{ route('employee.movements.index', $employee) }}"
                                   title="Ver historial"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all duration-200">

                                    <svg class="w-4 h-4"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.8"
                                              d="M12 8v4l3 2
                                                 M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                    </svg>

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    {{-- SIN RESULTADOS --}}
                    <tr>

                        <td colspan="5" class="px-6 py-16 text-center">

                            <div class="flex flex-col items-center justify-center">

                                <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center mb-4">

                                    <svg class="w-6 h-6 text-slate-500"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.7"
                                              d="M17 20h5v-2a4 4 0 00-4-4h-1
                                                 M9 20H4v-2a4 4 0 014-4h1
                                                 M12 12a4 4 0 100-8 4 4 0 000 8z"/>

                                    </svg>

                                </div>

                                <p class="text-sm font-semibold text-slate-300">
                                    No se encontraron empleados
                                </p>

                                <p class="text-xs text-slate-500 mt-1">
                                    Intenta modificar los criterios de búsqueda.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- FOOTER --}}
    @if(method_exists($employees, 'links'))

        <div class="px-5 sm:px-6 py-4 border-t border-slate-800 bg-slate-950/40 text-slate-400">

            {{ $employees->links() }}

        </div>

    @endif

</div>

</div>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>
@endsection