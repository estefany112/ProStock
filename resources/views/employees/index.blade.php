@extends('layouts.principal')

@section('content')
<div class="py-6 sm:py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HEADER RESPONSIVO --}}
    <div class="flex flex-col gap-6 mb-8">
        <div class="bg-indigo-900/90 backdrop-blur-md border border-white/10 p-6 rounded-3xl shadow-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4 w-full">
                <div class="p-4 bg-indigo-500/20 text-indigo-300 rounded-2xl flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Personal</h1>
                    <p class="text-indigo-200/70 text-sm">Gestión estratégica de talento humano</p>
                </div>
            </div>

            @if(auth()->user()->hasPermission('employee.create'))
                <a href="{{ route('employees.create') }}"
                   class="w-full md:w-auto flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl shadow-lg transition-all hover:scale-[1.02] flex-shrink-0">
                    <span>➕</span> Nuevo Empleado
                </a>
            @endif
        </div>
    </div>

    {{-- TABLA RESPONSIVA --}}
    {{-- CONTENEDOR CON SCROLL HORIZONTAL --}}
<div class="w-full overflow-x-auto bg-white rounded-2xl shadow-lg border border-slate-100">
    
    <div class="p-4 border-b border-slate-50">
        <x-search-bar action="{{ route('employees.index') }}" placeholder="Buscar por nombre o DPI..." />
    </div>

    {{-- AÑADIMOS table-layout: fixed PARA QUE NO SE EXPANDA MÁS DE LO NECESARIO --}}
    <table class="w-full text-sm table-fixed">
        <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] font-bold">
            <tr>
                <th class="w-12 px-2 py-4 text-center hidden sm:table-cell">#</th>
                <th class="px-4 py-4 text-left w-auto">Empleado</th>
                <th class="px-4 py-4 text-left hidden md:table-cell w-32">Puesto</th>
                <th class="px-4 py-4 text-left hidden sm:table-cell w-24">Salario</th>
                <th class="px-4 py-4 text-center w-20">Estado</th>
                <th class="px-4 py-4 text-center w-28">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse ($employees as $employee)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-2 py-4 text-slate-300 text-center hidden sm:table-cell truncate">{{ $loop->iteration }}</td>
                    <td class="px-4 py-4 truncate">
                        <div class="font-bold text-slate-800 truncate">{{ $employee->name }}</div>
                        <div class="text-slate-400 text-[10px] md:hidden truncate">{{ $employee->position }}</div>
                        <div class="text-slate-400 text-xs truncate">{{ $employee->dpi }}</div>
                    </td>
                    <td class="px-4 py-4 text-slate-600 font-medium hidden md:table-cell truncate">{{ $employee->position }}</td>
                    <td class="px-4 py-4 font-bold text-emerald-600 hidden sm:table-cell truncate">Q{{ number_format($employee->salary_base, 0) }}</td>
                    <td class="px-2 py-4 text-center">
                        <span class="inline-block px-2 py-1 rounded-full text-[9px] font-black uppercase tracking-wider 
                            {{ $employee->active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                            {{ $employee->active ? 'Act' : 'Inac' }}
                        </span>
                    </td>
                    <td class="px-2 py-4 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <a href="{{ route('employees.edit', $employee) }}" class="text-indigo-500 font-bold hover:underline text-xs">Editar</a>
                            <form action="{{ route('employees.toggle', $employee) }}" method="POST" onsubmit="return confirmToggle(event)">
                                @csrf @method('PATCH')
                                <button class="font-bold {{ $employee->active ? 'text-rose-500' : 'text-emerald-500' }} hover:underline text-xs">
                                    {{ $employee->active ? 'Des' : 'Act' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="p-8 text-center text-slate-400">Sin registros.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

    {{-- PAGINACIÓN --}}
    <div class="mt-6">
        {{ $employees->withQueryString()->links() }}
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