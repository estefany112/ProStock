@extends('layouts.principal')

@section('content')

<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">

    <h2 class="text-2xl font-bold mb-6">
        Editar Horas Extras
    </h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('horas-extras.update', $horaExtra->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Empleado
            </label>

            <input
                type="text"
                class="w-full border rounded px-3 py-2 bg-gray-100"
                value="{{ $horaExtra->empleado->name }}"
                readonly>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Fecha
            </label>

            <input
                type="date"
                name="fecha"
                class="w-full border rounded px-3 py-2"
                value="{{ old('fecha', $horaExtra->fecha) }}"
                required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Horas
            </label>

            <input
                type="number"
                step="0.01"
                min="0"
                name="horas"
                class="w-full border rounded px-3 py-2"
                value="{{ old('horas', $horaExtra->horas) }}"
                required>
        </div>

        <div class="flex justify-end gap-3">

            <a href="{{ url()->previous() }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Cancelar
            </a>

            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Guardar Cambios
            </button>

        </div>

    </form>

</div>

@endsection