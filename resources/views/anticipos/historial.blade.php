@extends('layouts.principal')

@section('content')

<div class="max-w-6xl mx-auto py-8">

    <!-- BOTÓN VOLVER -->
    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('anticipos.quincena') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 
                px-4 py-2 rounded-lg text-sm shadow-sm transition">
            ← Volver
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Historial de Anticipos
            </h2>

            <a href="{{ route('anticipos.quincena') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-sm transition">
                + Nuevo Anticipo
            </a>
        </div>

        {{-- ALERTA --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- FILTRO -->
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <input type="date" 
                name="inicio" 
                value="{{ $inicio }}"
                class="border border-gray-300 px-3 py-2 rounded-lg 
                       focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <input type="date" 
                name="fin" 
                value="{{ $fin }}"
                class="border border-gray-300 px-3 py-2 rounded-lg 
                       focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <button 
                class="bg-blue-600 hover:bg-blue-700 text-white 
                       px-4 py-2 rounded-lg shadow transition">
                Filtrar
            </button>

        </form>

        <!-- TABLA -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-gray-600">

                <thead class="bg-gray-800 text-white text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left">Empleado</th>
                        <th class="py-3 px-4 text-left">Fecha</th>
                        <th class="py-3 px-4 text-left">Monto</th>
                        <th class="py-3 px-4 text-left">Descripción</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                        <th class="py-3 px-4 text-center">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($anticipos as $anticipo)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $anticipo->empleado->name ?? 'Sin empleado' }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($anticipo->fecha)->format('d/m/Y') }}
                                </span>
                            </td>

                            <td class="px-4 py-3 font-semibold text-green-600">
                                Q {{ number_format($anticipo->monto, 2) }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $anticipo->descripcion }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $anticipo->estado == 'pendiente'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($anticipo->estado) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('anticipos.detalle', [
                                    $anticipo->employee_id,
                                    $anticipo->fecha,
                                    $anticipo->fecha
                                ]) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white 
                                          px-3 py-1 rounded text-xs shadow transition">
                                    Ver detalle
                                </a>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">
                                No hay anticipos registrados en este rango de fechas
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection