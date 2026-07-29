@extends('layouts.principal')

@section('content')

<div class="p-6 md:p-8 max-w-7xl mx-auto">

    <!-- Encabezado y Botones de Navegación -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100 uppercase tracking-wide">
                    Módulo de Auditoría
                </span>
                <span class="text-xs text-gray-400 font-medium">
                    Total registros: <strong class="text-gray-700">{{ $productos->total() ?? 0 }}</strong>
                </span>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">
                Reportería de Productos
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Análisis y control de incidencias en el catálogo de productos (sin precio o sin imagen).
            </p>
        </div>

        <!-- Botones de Navegación (Dashboard / Siguiente) -->
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 transition-all">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="#" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 transition-all">
                Siguiente
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Barra de Filtros y Estadísticas Rápidas -->
    <div class="bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('reportes.productos') }}" class="flex items-center gap-3 w-full sm:w-auto">
            <label for="tipo" class="text-sm font-semibold text-gray-700 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtro de Reporte:
            </label>
            <select name="tipo"
                    id="tipo"
                    onchange="this.form.submit()"
                    class="border border-gray-300 rounded-xl px-4 py-2 text-sm bg-gray-50/50 font-medium text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                <option value="sin_precio" {{ $tipo == 'sin_precio' ? 'selected' : '' }}>
                    ⚠️ Productos sin precio
                </option>
                <option value="sin_imagen" {{ $tipo == 'sin_imagen' ? 'selected' : '' }}>
                    🖼️ Productos sin imagen
                </option>
            </select>
        </form>

        <div class="flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-100 text-gray-500">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            Modo Reportería Activo
        </div>
    </div>

    <!-- Tabla de Datos -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/75 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="p-4 font-bold">Código</th>
                        <th class="p-4 font-bold">Descripción del Producto</th>
                        <th class="p-4 font-bold">Categoría</th>
                        <th class="p-4 font-bold">Precio Unitario</th>
                        <th class="p-4 font-bold text-center">Estado Imagen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($productos as $producto)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 font-mono font-semibold text-indigo-600">
                                {{ $producto->codigo }}
                            </td>
                            <td class="p-4 font-medium text-gray-900">
                                {{ $producto->descripcion }}
                            </td>
                            <td class="p-4 text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td class="p-4 font-semibold">
                                @if($producto->precio_unitario)
                                    <span class="text-gray-900 bg-gray-50 px-2 py-1 rounded-md border border-gray-100 font-mono">Q {{ number_format($producto->precio_unitario, 2) }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        Sin precio
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($producto->image)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Disponible
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Faltante
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-sm font-medium text-gray-600">¡Excelente trabajo! No hay registros que cumplan con este criterio de reporte.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación manteniendo parámetros de filtro -->
    <div class="mt-6">
        {{ $productos->appends(request()->query())->links() }}
    </div>

</div>

@endsection