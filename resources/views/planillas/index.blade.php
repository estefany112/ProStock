@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    {{-- FORMULARIO CREAR PLANILLA --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h2 class="text-lg font-semibold mb-4">Crear Planilla</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('planillas.store') }}" method="POST" class="grid grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-600">Fecha inicio</label>
                <input type="date" name="fecha_inicio"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm text-gray-600">Fecha fin</label>
                <input type="date" name="fecha_fin"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex items-end">
                <button class="bg-blue-600 hover:bg-blue-700 
                               text-white px-4 py-2 rounded shadow-sm transition">
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
                <tr class="border-b text-left bg-gray-50">
                    <th class="py-2">Fecha inicio</th>
                    <th class="py-2">Fecha fin</th>
                    <th class="py-2">Estado</th>
                    <th class="py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($planillas as $planilla)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2">{{ $planilla->fecha_inicio }}</td>
                        <td class="py-2">{{ $planilla->fecha_fin }}</td>

                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs
                                {{ $planilla->estado === 'abierta'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-200 text-gray-700' }}">
                                {{ ucfirst($planilla->estado) }}
                            </span>
                        </td>

                        <td class="py-2">
                            <div class="flex gap-2 justify-center">

                                {{-- Ver --}}
                                <a href="{{ route('planillas.show', $planilla->id) }}"
                                   class="bg-blue-600 hover:bg-blue-700 
                                          text-white px-3 py-1 rounded text-xs shadow">
                                    👁 Ver
                                </a>

                                {{-- Editar ISR --}}
                                @if($planilla->estado === 'abierta')
                                    <a href="{{ route('planillas.editarIsr', $planilla->id) }}"
                                       class="bg-amber-500 hover:bg-amber-600 
                                              text-black px-3 py-1 rounded text-xs shadow">
                                        ✏️ ISR
                                    </a>
                                @endif

                                {{-- Copiar ISR de planilla anterior --}}
                                 @if($planilla->estado === 'abierta')
                                <form action="{{ route('planillas.copiarAnterior',$planilla->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-purple-600 hover:bg-purple-700 
                                                text-white px-3 py-1 rounded text-xs shadow">
                                        📋 Copiar ISR
                                    </button>
                                </form>
                                @endif
                                
                                {{-- Cerrar Planilla --}}
                                 @if($planilla->estado === 'abierta')
                                    <form action="{{ route('planillas.cerrar', $planilla->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Está seguro de cerrar esta planilla? Esta acción no se puede deshacer.')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 
                                            text-white px-3 py-1 rounded text-xs shadow">
                                            🔒 Cerrar
                                        </button>
                                    </form>  
                                 @endif  
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">
                            No hay planillas creadas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection