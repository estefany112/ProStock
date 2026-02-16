@extends('layouts.principal')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold">
                    📄 Solicitud #{{ $solicitud->id }}
                </h1>
                <p class="text-sm text-gray-500">
                    Detalle completo de la solicitud
                </p>
            </div>

            <a href="{{ route('solicitudes.index') }}"
               class="text-sm text-gray-600 hover:underline">
                ← Volver
            </a>
        </div>

        {{-- INFO GENERAL --}}
        <div class="grid grid-cols-2 gap-6 mb-6">

            <div>
                <p class="text-sm text-gray-500">Empleado</p>
                <p class="font-semibold">
                    {{ $solicitud->empleado->name }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ $solicitud->empleado->position }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Estado</p>

                @if($solicitud->estado == 'pendiente')
                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                        Pendiente
                    </span>
                @elseif($solicitud->estado == 'aprobado')
                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                        Aprobado
                    </span>
                @elseif($solicitud->estado == 'rechazado')
                    <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                        Rechazado
                    </span>
                @elseif($solicitud->estado == 'entregado')
                    <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                        Entregado
                    </span>
                @elseif($solicitud->estado == 'devuelto')
                    <span class="px-3 py-1 rounded-full text-xs bg-purple-100 text-purple-700">
                        Devuelto
                    </span>
                @endif
            </div>

        </div>

        {{-- OBSERVACION --}}
        @if($solicitud->observacion)
        <div class="mb-6">
            <p class="text-sm text-gray-500">Observación</p>
            <div class="bg-gray-50 p-4 rounded-lg border text-sm">
                {{ $solicitud->observacion }}
            </div>
        </div>
        @endif

        {{-- MATERIALES --}}
        <div class="mb-6">
            <h2 class="font-semibold mb-3">Materiales solicitados</h2>

            <div class="border rounded-lg overflow-hidden">
                <table class="w-full text-sm">

                    <thead class="bg-slate-100">
                        <tr>
                            <th class="p-3 text-left">Descripción</th>
                            <th class="p-3 text-left">Cantidad</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($solicitud->detalles as $detalle)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $detalle->descripcion }}
                                </td>
                                <td class="p-3">
                                    {{ $detalle->cantidad }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        {{-- HISTORIAL --}}
        <div class="border-t pt-4 text-sm text-gray-600 space-y-2">

            <div>
                📅 Creada:
                {{ $solicitud->created_at->format('d/m/Y H:i') }}
            </div>

            @if($solicitud->fecha_aprobacion)
                <div>
                    ✅ Aprobada/Rechazada:
                    {{ $solicitud->fecha_aprobacion->format('d/m/Y H:i') }}
                </div>
            @endif

            @if($solicitud->fecha_entrega)
                <div>
                    📦 Entregada:
                    {{ $solicitud->fecha_entrega->format('d/m/Y H:i') }}
                </div>
            @endif

        </div>

    </div>
</div>

@endsection