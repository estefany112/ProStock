@extends('layouts.principal')

@section('content')

<div class="py-8 max-w-7xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border text-gray-800">

        {{-- HEADER DE LA VISTA --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                    👥 EMPLEADOS
                </h1>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Gestión de empleados – PROSERVE
            </p>

            <div class="mt-4">
                @if(auth()->user()->hasPermission('employee.create'))
                    <a href="{{ route('employees.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                              hover:bg-green-700 transition">
                        ➕ Nuevo empleado
                    </a>
                @endif
            </div>

        </div>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mt-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- TABLA --}}
        <div class="overflow-x-auto text-center">
            <table class="w-full mt-4 border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">#</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Salario base</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr class="border-t">
                            <td class="p-2">{{ $loop->iteration }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>Q {{ number_format($employee->salary_base, 2) }}</td>
                            <td>
                                @if($employee->active)
                                    <span class="text-green-600 font-semibold">Activo</span>
                                @else
                                    <span class="text-red-600 font-semibold">Inactivo</span>
                                @endif
                            </td>
                            <td class="flex gap-3 justify-center">
                                @if(auth()->user()->hasPermission('employee.edit'))
                                    <a href="{{ route('employees.edit', $employee) }}" class="text-blue-600">
                                        Editar
                                    </a>
                                @endif

                                @if(auth()->user()->hasPermission('employee.disable'))
                                    <form action="{{ route('employees.toggle', $employee) }}"
                                          method="POST"
                                          onsubmit="return confirmToggle(event)">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-red-600">
                                            {{ $employee->active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if($employees->count() === 0)
                        <tr>
                            <td colspan="6" class="p-4 text-gray-600">
                                No hay empleados registrados.
                            </td>
                        </tr>
                    @endif
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
            text: 'Se cambiará el estado del empleado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>

@endsection
