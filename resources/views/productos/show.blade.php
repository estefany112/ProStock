@extends('layouts.principal')

@section('content')

<div class="py-12 bg-[#0f172a] min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        
        {{-- BOTÓN VOLVER SUTIL --}}
        <div class="mb-6">
            <a href="{{ route('productos.index') }}" class="inline-flex items-center text-slate-400 hover:text-white transition-colors text-sm font-bold uppercase tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al Inventario
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                
                {{-- LADO IZQUIERDO: IMAGEN (Estilo Galería) --}}
                <div class="lg:col-span-5 bg-slate-50 p-8 flex items-center justify-center border-r border-slate-100">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
                        <div class="relative w-full aspect-square max-w-[400px] rounded-2xl overflow-hidden bg-white shadow-inner flex items-center justify-center">
                            <img src="{{ $producto->image 
                                ? asset('storage/' . $producto->image) 
                                : asset('images/no-image.jpg') }}"
                                class="w-full h-full object-contain p-4 transform transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </div>

                {{-- LADO DERECHO: INFORMACIÓN (Estilo Tienda) --}}
                <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col">
                    
                    {{-- Badge de Stock y Código --}}
                    <div class="flex items-center justify-between mb-6">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-200">
                            REF: {{ $producto->codigo }}
                        </span>
                        
                        @if($producto->stock_actual > 0)
                            <div class="flex items-center text-emerald-600 font-bold text-sm">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                Disponible: {{ $producto->stock_actual }} {{ $producto->unidad_medida }}
                            </div>
                        @else
                            <div class="flex items-center text-red-500 font-bold text-sm">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Agotado temporalmente
                            </div>
                        @endif
                    </div>

                    {{-- Título y Categoría --}}
                    <div class="mb-8">
                        <p class="text-blue-600 font-bold text-xs uppercase tracking-widest mb-2">
                            {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                        </p>
                        <h1 class="text-4xl font-extrabold text-slate-900 leading-tight">
                            {{ $producto->descripcion }}
                        </h1>
                        <div class="mt-4 flex items-center gap-4">
                            <span class="text-slate-400 text-sm">Marca:</span>
                            <span class="font-bold text-slate-700 uppercase tracking-tighter">{{ $producto->marca ?? 'Genérica' }}</span>
                        </div>
                    </div>

                    {{-- PRECIO (Llamativo) --}}
                    <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Precio Unitario</p>
                        <div class="flex items-baseline gap-2">
                            @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor','almacen']))
                                @if($producto->precio_unitario > 0)
                                    <span class="text-4xl font-black text-slate-900 tracking-tighter">Q {{ number_format($producto->precio_unitario, 2) }}</span>
                                    <span class="text-slate-400 text-sm font-medium">/ neto</span>
                                @else
                                    <span class="text-slate-400 text-lg italic">Precio no asignado</span>
                                @endif
                            @else
                                <span class="text-slate-400 text-lg italic italic">Restringido</span>
                            @endif
                        </div>
                    </div>

                    {{-- DETALLES TÉCNICOS (Cuadrícula) --}}
                    <div class="grid grid-cols-2 gap-y-6 gap-x-12 mb-10 border-t border-slate-100 pt-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Localización</p>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="font-bold text-slate-700 uppercase">{{ $producto->ubicacion ?? 'Almacén Central' }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unidad Operativa</p>
                            <span class="font-bold text-slate-700 uppercase">{{ $producto->unidad_medida ?? 'N/A' }}</span>
                        </div>
                    </div>

                    {{-- BOTÓN DE ACCIÓN --}}
                    <div class="mt-auto flex items-center gap-4">
                        @if(auth()->user()->hasPermission('edit_products'))
                            <a href="{{ route('productos.edit', $producto) }}"
                               class="flex-1 bg-slate-900 text-white text-center py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-slate-200">
                                Editar Información
                            </a>
                        @endif
                        <button onclick="window.print()" class="p-4 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- PIE DE PÁGINA --}}
        <div class="mt-8 flex justify-between items-center px-4">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.3em]">
                Sistema Certificado — PROSERVE 2026
            </p>
            <div class="flex gap-2">
                <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .bg-[#0f172a] { background: white !important; }
        .shadow-2xl, .shadow-xl, .bg-slate-900 { shadow: none !important; }
        .bg-white { border: 1px solid #eee !important; }
        a, button { display: none !important; }
    }
</script>

@endsection