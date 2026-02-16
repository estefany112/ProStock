@extends('layouts.principal')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold">
                    📋 Solicitudes
                </h1>
                <p class="text-sm text-gray-500">
                    Control y aprobación de solicitudes – PROSERVE
                </p>
            </div>

            @can('solicitudes.view')
                <span class="text-sm text-gray-400">
                    Total: {{ $solicitudes->count() }}
                </span>
            @endcan
        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">

                <thead>
                    <tr class="bg-slate-100 text-slate-700">
                        <th class="p-3">#</th>
                        <th class="p-3">Empleado</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Fecha</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($solicitudes as $solicitud)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="p-3 font-semibold">
                            #{{ $solicitud->id }}
                        </td>

                        <td class="p-3">
                            {{ $solicitud->empleado->name }}
                        </td>

                        {{-- ESTADO --}}
                        <td class="p-3">
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
                        </td>

                        <td class="p-3">
                            {{ $solicitud->created_at->format('d/m/Y H:i') }}
                        </td>

                        {{-- ACCIONES --}}
                        <td class="p-3 text-center space-x-2">

                            {{-- VER --}}
                            @if(
                                auth()->user()->roles->pluck('name')->contains('admin') ||
                                auth()->user()->roles->pluck('name')->contains('supervisor') ||
                                auth()->user()->roles->pluck('name')->contains('almacen')
                            )
                                <a href="{{ route('solicitudes.show', $solicitud->id) }}"
                                class="text-blue-600 hover:underline text-xs">
                                    Ver
                                </a>
                            @endif

                            {{-- APROBAR / RECHAZAR --}}
                            @if(auth()->user()->roles->pluck('name')->contains('admin') 
                                 || auth()->user()->roles->pluck('name')->contains('supervisor'))
                                @if($solicitud->estado == 'pendiente')

                                    <form action="{{ route('solicitudes.aprobar', $solicitud->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        <button class="text-green-600 text-xs hover:underline">
                                            Aprobar
                                        </button>
                                    </form>

                                    <form action="{{ route('solicitudes.rechazar', $solicitud->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        <button class="text-red-600 text-xs hover:underline">
                                            Rechazar
                                        </button>
                                    </form>

                                    <a href="{{ route('solicitudes.show', $solicitud->id) }}"
                                        class="text-blue-600 text-xs hover:underline">
                                            Ver Detalle
                                    </a>

                                @endif
                            @endif

                            {{-- ENTREGAR --}}
                            @if(auth()->user()->roles->pluck('name')->contains('admin') 
                                 || auth()->user()->roles->pluck('name')->contains('almacen'))
                                @if($solicitud->estado == 'aprobado')

                                    <form action="{{ route('solicitudes.entregar', $solicitud->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        <button class="text-blue-600 text-xs hover:underline">
                                            Entregar
                                        </button>
                                    </form>

                                @endif

                                {{-- DEVOLVER --}}
                                @if($solicitud->estado == 'entregado')

                                    <form action="{{ route('solicitudes.devolver', $solicitud->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        <button class="text-purple-600 text-xs hover:underline">
                                            Marcar Devuelto
                                        </button>
                                    </form>

                                @endif
                            @endif

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center p-6 text-gray-500">
                            No hay solicitudes registradas.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection