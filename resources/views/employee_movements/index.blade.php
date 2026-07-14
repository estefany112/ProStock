@extends('layouts.principal')

@section('content')
<div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- CABECERA ESTRUCTURADA --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-slate-200 pb-6">
        
        <div class="flex items-center gap-4">
            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('employees.index') }}" 
            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-all border border-transparent hover:border-indigo-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Historial Laboral</h1>
                <nav class="flex items-center gap-2 mt-1 text-slate-500 text-sm">
                    <span>Gestión de personal</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-indigo-600 font-medium">{{ $employee->name }}</span>
                </nav>
            </div>
        </div>

        {{-- BOTÓN NUEVO REGISTRO --}}
        <a href="{{ route('employee.movements.create', $employee) }}"
        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Registro
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 shadow-sm rounded-r-lg">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- TABLA ESTILO CORPORATIVO --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tipo de Movimiento</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Motivo</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Autorizado por</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($movements as $movement)
                    <tr class="group hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-700">
                            {{ \Carbon\Carbon::parse($movement->date)->isoFormat('DD [de] MMM, YYYY') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $movement->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $movement->reason ?? 'Sin observaciones' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] text-slate-600 font-bold">
                                    {{ substr($movement->user->name ?? 'S', 0, 1) }}
                                </div>
                                {{ $movement->user->name ?? 'Sistema' }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <svg class="w-10 h-10 mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                No se encontraron registros históricos.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN ELEGANTE --}}
    <div class="mt-6">
        {{ $movements->links() }}
    </div>

</div>
@endsection