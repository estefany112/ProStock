@extends('layouts.principal')

@section('content')
<div class="py-6 sm:py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-in fade-in duration-700">

    {{-- HEADER RESPONSIVO --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-3xl shadow-2xl mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-indigo-500/20 text-indigo-300 rounded-2xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight">Personal</h1>
                    <p class="text-indigo-200/70 mt-1">Administración estratégica de talento humano</p>
                </div>
            </div>

            <div class="hidden md:block">
                <span class="px-4 py-2 bg-white/5 border border-white/10 rounded-full text-indigo-300 text-xs font-bold uppercase tracking-widest">
                    Dashboard Activo
                </span>
            </div>
        </div>

        @if(auth()->user()->hasPermission('employee.create'))
            <a href="{{ route('employees.create') }}"
               class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all hover:scale-105">
                <span>➕</span> Nuevo Empleado
            </a>
        @endif
    </div>

    {{-- CONTENEDOR DE TABLA RESPONSIVO --}}
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
        
        <div class="p-4 border-b border-slate-50">
            <x-search-bar action="{{ route('employees.index') }}" placeholder="Buscar por nombre o DPI..." />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] font-bold">
                    <tr>
                        <th class="px-4 py-4 text-center hidden sm:table-cell">#</th>
                        <th class="px-4 py-4 text-left">Empleado</th>
                        <th class="px-4 py-4 text-left hidden md:table-cell">Puesto</th>
                        <th class="px-4 py-4 text-left">Salario</th>
                        <th class="px-4 py-4 text-center">Estado</th>
                        <th class="px-4 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($employees as $employee)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-4 py-4 text-slate-300 text-center hidden sm:table-cell">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-slate-800">{{ $employee->name }}</div>
                                <div class="text-slate-400 text-[10px] md:hidden">{{ $employee->position }}</div>
                                <div class="text-slate-400 text-xs">{{ $employee->dpi }}</div>
                            </td>
                            <td class="px-4 py-4 text-slate-600 font-medium hidden md:table-cell">{{ $employee->position }}</td>
                            <td class="px-4 py-4 font-bold text-emerald-600">Q {{ number_format($employee->salary_base, 2) }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase tracking-wider 
                                    {{ $employee->active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    {{ $employee->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 flex flex-col md:flex-row items-center justify-center gap-2">
                                <a href="{{ route('employees.edit', $employee) }}" 
                                   class="text-indigo-500 font-bold hover:underline">Editar</a>
                                <form action="{{ route('employees.toggle', $employee) }}" method="POST" onsubmit="return confirmToggle(event)">
                                    @csrf @method('PATCH')
                                    <button class="font-bold {{ $employee->active ? 'text-rose-500' : 'text-emerald-500' }} hover:underline">
                                        {{ $employee->active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-8 text-center text-slate-400">Sin empleados registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmToggle(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Confirmar acción?',
            text: 'Se actualizará el estatus del colaborador.',
            icon: 'question',
            confirmButtonColor: '#4f46e5',
            showCancelButton: true
        }).then((result) => { if (result.isConfirmed) event.target.submit(); });
    }
</script>
@endsection