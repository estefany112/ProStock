@extends('layouts.principal')

@section('content')

<div class="max-w-4xl mx-auto py-8">

    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Registrar Anticipo
        </h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('anticipos.guardar') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Empleado --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Empleado
                    </label>

                    <select
                        name="empleado_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    >
                        <option value="">Seleccione</option>

                        @foreach($empleados as $emp)
                            <option value="{{ $emp->id }}">
                                {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Fecha
                    </label>

                    <input
                        type="date"
                        name="fecha"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    >
                </div>

                {{-- Monto --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Monto
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="monto"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    >
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Descripción
                    </label>

                    <input
                        type="text"
                        name="descripcion"
                        placeholder="Ej: Anticipo por emergencia"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    >
                </div>

            </div>

            <div class="mt-6">
                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow"
                >
                    Guardar Anticipo
                </button>
            </div>

        </form>

    </div>

</div>

@endsection