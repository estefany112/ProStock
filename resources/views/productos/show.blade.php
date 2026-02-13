@extends('layouts.principal')

@section('content')

<div class="py-10 max-w-5xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-md">

        {{-- HEADER --}}
        <div class="mb-12 border-b border-gray-200 pb-6 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">
                    Detalle del Producto
                </h1>
                <p class="text-sm text-gray-500 mt-2">
                    Sistema de Gestión de Inventario – PROSERVE
                </p>
            </div>

            <a href="{{ route('productos.index') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition whitespace-nowrap text-sm text-gray-600 hover:text-gray-900 transition">
                ← Volver al listado
            </a>

        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

            {{-- IMAGEN --}}
            <div class="flex justify-center">
                <div class="w-72 h-72 border border-gray-200 rounded-2xl bg-gray-50 overflow-hidden shadow-sm">
                    <img src="{{ $producto->image 
                        ? asset('storage/' . $producto->image) 
                        : asset('images/no-image.jpg') }}"
                        class="w-full h-full object-cover">
                </div>
            </div>

            {{-- INFORMACIÓN --}}
            <div class="space-y-7">

                {{-- Código + Stock alineados --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-400">Código</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $producto->codigo }}
                        </p>
                    </div>

                    {{-- Badge de stock --}}
                    @if($producto->stock_actual > 0)
                        <span class="bg-green-50 text-green-700 text-xs font-semibold px-4 py-2 rounded-full border border-green-200">
                            Disponible ({{ $producto->stock_actual }})
                        </span>
                    @else
                        <span class="bg-red-50 text-red-700 text-xs font-semibold px-4 py-2 rounded-full border border-red-200">
                            Sin stock
                        </span>
                    @endif
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400">Descripción</p>
                    <p class="text-base font-medium text-gray-900 leading-relaxed">
                        {{ $producto->descripcion }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-8">

                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-400">Categoría</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-400">Marca</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $producto->marca ?? 'No especificada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-400">Unidad</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $producto->unidad_medida ?? 'No definida' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-400">Ubicación</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $producto->ubicacion ?? 'No asignada' }}
                        </p>
                    </div>

                </div>

                {{-- Precio con más peso visual --}}
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400">Precio Unitario</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor']))
                            @if($producto->precio_unitario > 0)
                                Q {{ number_format($producto->precio_unitario, 2) }}
                            @else
                                <span class="text-gray-400 text-sm italic">Sin precio asignado</span>
                            @endif
                        @else
                            <span class="text-gray-400 text-sm italic">No disponible</span>
                        @endif
                    </p>
                </div>

            </div>

        </div>

        {{-- ACCIONES --}}
        <div class="mt-16 border-t border-gray-200 pt-8 flex items-center justify-between">

            <div class="text-sm text-gray-500">
                Última actualización del producto
            </div>

            <div class="flex gap-4">

                @if(auth()->user()->hasPermission('edit_products'))
                    <a href="{{ route('productos.edit', $producto) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                          hover:bg-blue-700 transition whitespace-nowrap bg-gray-900 text-white px-8 py-3 rounded-xl hover:bg-black transition shadow-sm">
                        Editar
                    </a>
                @endif

            </div>

        </div>
        </div>
    </div>

@endsection