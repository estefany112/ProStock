@extends('layouts.principal')

@section('content')

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border">

            {{-- HEADER --}}
            <div class="mb-6">

                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        ✏️ EDITAR EMPLEADO
                    </h1>

                    <a href="{{ route('employees.index') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                              hover:bg-blue-700 transition">
                        ← Volver
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-1">
                    Actualización de datos del empleado – PROSERVE
                </p>

            </div>

            {{-- ERRORES --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORMULARIO --}}
            <form action="{{ route('employees.update', $employee) }}" method="POST" class="grid grid-cols-1 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium">DPI (opcional)</label>
                    <input type="text" name="dpi" value="{{ old('dpi', $employee->dpi) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium">Puesto</label>
                    <input type="text" name="position" value="{{ old('position', $employee->position) }}"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium">Salario base mensual</label>
                    <input type="number" name="salary_base" step="0.01" min="0"
                           value="{{ old('salary_base', $employee->salary_base) }}"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium">Estado</label>
                    <select name="active" class="w-full border rounded-lg px-3 py-2">
                        <option value="1" {{ $employee->active ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$employee->active ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="pt-4 flex gap-3">
                    <button
                        class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                               hover:bg-green-700 transition">
                        Guardar cambios
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
