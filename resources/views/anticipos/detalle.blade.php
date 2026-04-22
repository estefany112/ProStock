@extends('layouts.principal')

@section('content')

<div class="max-w-6xl mx-auto py-8">

    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Historial de Anticipos
            </h2>

            <a href="{{ route('anticipos.quincena') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-sm">
                + Nuevo Anticipo
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-gray-600">

                <thead class="bg-gray-800 text-white text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left">Empleado</th>
                        <th class="py-3 px-4 text-left">Fecha</th>
                        <th class="py-3 px-4 text-left">Monto</th>
                        <th class="py-3 px-4 text-left">Descripción</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($anticipos as $anticipo)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">
                                {{ $anticipo->empleado->name ?? 'Sin empleado' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($anticipo->fecha)->format('d/m/Y') }}
                            </td>

                            <td class="px-4 py-3 font-semibold">
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

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                No hay anticipos registrados
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection