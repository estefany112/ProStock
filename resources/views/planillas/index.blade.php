@extends('layouts.principal')

@section('content')
    <div class="max-w-5xl mx-auto py-8">

        {{-- FORMULARIO CREAR PLANILLA --}}
        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Crear Planilla</h2>

            <form action="{{ route('planillas.store') }}" method="POST" class="grid grid-cols-3 gap-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-600">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm text-gray-600">Fecha fin</label>
                    <input type="date" name="fecha_fin" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="flex items-end">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Crear
                    </button>
                </div>
            </form>
        </div>

        {{-- LISTADO DE PLANILLAS --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-4">Planillas</h2>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th class="py-2">Fecha inicio</th>
                        <th class="py-2">Fecha fin</th>
                        <th class="py-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($planillas as $planilla)
                        <tr class="border-b">
                            <td class="py-2">{{ $planilla->fecha_inicio }}</td>
                            <td class="py-2">{{ $planilla->fecha_fin }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $planilla->estado === 'abierta' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                                    {{ ucfirst($planilla->estado) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">
                                No hay planillas creadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
