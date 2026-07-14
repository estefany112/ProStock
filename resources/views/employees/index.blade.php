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
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-indigo-50 border border-indigo-100 p-5 rounded-xl">
            <span class="text-indigo-600 text-xs font-bold uppercase tracking-wider">Total Empleados</span>
            <p class="text-2xl font-bold text-indigo-900 mt-1">{{ $employees->total() }}</p>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-xl">
            <span class="text-emerald-600 text-xs font-bold uppercase tracking-wider">Activos</span>
            <p class="text-2xl font-bold text-emerald-900 mt-1">{{ $employees->where('active', true)->count() }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-200 p-5 rounded-xl">
            <span class="text-slate-500 text-xs font-bold uppercase tracking-wider">Inactivos</span>
            <p class="text-2xl font-bold text-slate-700 mt-1">{{ $employees->where('active', false)->count() }}</p>
        </div>
    </div>

    {{-- LISTADO DE EMPLEADOS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-100">
            <x-search-bar action="{{ route('employees.index') }}" placeholder="Buscar empleado..." />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold uppercase">Información</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase hidden md:table-cell">Puesto</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase hidden sm:table-cell">Salario</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase text-center">Estado</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($employees as $employee)
                        <tr class="hover:bg-indigo-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $employee->name }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $employee->dpi }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-sm hidden md:table-cell">{{ $employee->position }}</td>
                            <td class="px-6 py-4 text-slate-800 text-sm font-medium hidden sm:table-cell">Q{{ number_format($employee->salary_base, 0) }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($employee->active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">Activo</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-600">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                               @if($employee->status == 'activo' && $employee->active== 1)
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs">Editar</a>
                                    <span class="text-slate-300">|</span>
                                @endif
                                    <a href="{{ route('employee.movements.index', $employee) }}" class="text-slate-600 hover:text-slate-900 font-bold text-xs">Historial</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-slate-400 italic">No hay empleados registrados todavía.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>
@endsection