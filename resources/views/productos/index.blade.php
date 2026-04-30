@extends('layouts.principal')

@section('content')

{{-- CONTENEDOR PRINCIPAL: pt-16 para separación elegante del header superior --}}
<div class="max-w-7xl mx-auto pt-12 pb-16 px-4 sm:px-6 lg:px-8 mt-2">

    {{-- HEADER DE LA VISTA CON ANIMACIÓN DE ENTRADA SUAVE --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight flex items-center gap-4">
                <span class="p-3 bg-blue-500/10 rounded-2xl text-blue-500 shadow-inner">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </span>
                Productos
            </h1>
            <p class="text-slate-400 mt-3 text-lg">Catálogo maestro y control de stock – <span class="text-blue-500 font-semibold uppercase">PROSERVE</span></p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('prostock.index') }}"
               class="bg-slate-800 text-slate-300 px-5 py-3 rounded-xl border border-slate-700 hover:bg-slate-700 transition flex items-center gap-2 font-bold shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                Menú Inventario
            </a>
            
            @if(auth()->user()->hasPermission('create_products'))
                <a href="{{ route('productos.create') }}"
                   class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-emerald-900/40 transition flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Producto
                </a>
            @endif
        </div>
    </div>

    {{-- ALERTAS DE SISTEMA --}}
    @if(session('success') || session('error'))
        <div class="mb-6">
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    {{-- BARRA DE BÚSQUEDA --}}
<div class="mb-8 bg-slate-800/40 p-2 rounded-2xl border border-slate-700/50 backdrop-blur-sm shadow-inner">
    <x-search-bar
        action="{{ route('productos.index') }}"
        placeholder="Buscar por código o nombre de producto..."
    />
</div>

{{-- TABLA CON SCROLL INTERNO RESPONSIVO --}}
<div class="mb-8 bg-slate-800/40 p-2 rounded-2xl border border-slate-700/50 backdrop-blur-sm shadow-inner">
    {{-- Contenedor del Scroll --}}
    <div class="w-full overflow-x-auto custom-scrollbar">
        
        {{-- min-w-full = Responsivo en PC | min-w-[1000px] = Scroll en Móvil --}}
        <table class="min-w-full md:w-full border-collapse min-w-[1050px] text-left">
            <thead>
                <tr class="bg-slate-900/60 border-b border-slate-700">
                    <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-16">Item</th>
                    <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-32">Código</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Descripción del Producto</th>
                    <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-24">Imagen</th>
                    <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-32">Stock</th>
                    <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-40">Categoría</th>
                    @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen']))
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-28">Precio</th>
                    @endif
                    <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-32">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50 text-sm">
                @forelse ($productos as $producto)
                    <tr class="hover:bg-blue-500/5 transition-colors group">
                        <td class="px-5 py-4 whitespace-nowrap text-slate-500 font-mono text-center text-xs">
                            #{{ $productos->total() - (($productos->currentPage() - 1) * $productos->perPage() + $loop->index) }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap font-bold text-blue-400">
                            {{ $producto->codigo }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-200 font-medium group-hover:text-white transition line-clamp-1">
                                {{ $producto->descripcion }}
                            </div>
                            <div class="text-[10px] text-slate-500 mt-0.5 flex items-center gap-2">
                                <span class="text-slate-400 font-bold uppercase tracking-tighter">{{ $producto->marca }}</span>
                                <span class="h-1 w-1 bg-slate-700 rounded-full"></span>
                                <span>{{ $producto->ubicacion ?? 'Sin ubicación' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex justify-center">
                                <img src="{{ $producto->image && file_exists(public_path('storage/' . $producto->image)) ? asset('storage/' . $producto->image) : asset('images/no-image.jpg') }}"
                                     class="w-10 h-10 rounded-lg object-cover ring-2 ring-slate-700 group-hover:ring-blue-500/50 transition-all shadow-lg">
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $producto->stock_actual <= 5 ? 'bg-red-500/10 text-red-400' : 'bg-emerald-500/10 text-emerald-400' }}">
                                {{ $producto->stock_actual }} {{ $producto->unidad_medida }}
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-slate-400">
                            {{ $producto->categoria->nombre ?? 'N/A' }}
                        </td>

                        {{-- COLUMNA DE PRECIO CON PERMISOS POR ROL --}}
                        @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen' ]))
                            <td class="px-5 py-4 whitespace-nowrap text-slate-200 font-mono font-bold">
                                @if($producto->precio_unitario > 0)
                                    Q{{ number_format($producto->precio_unitario, 2) }}
                                @else
                                    <span class="text-slate-500 font-normal italic text-[11px]">Sin precio</span>
                                @endif
                            </td>
                        @endif

                        {{-- COLUMNA DE ACCIONES --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                {{-- BOTÓN VER --}}
                                <a href="{{ route('productos.show', $producto->id) }}" 
                                   class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all" 
                                   title="Ver">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                {{-- BOTÓN EDITAR --}}
                                @if(auth()->user()->hasPermission('edit_products'))
                                    <a href="{{ route('productos.edit', $producto->id) }}" 
                                       class="p-2 text-amber-400 hover:bg-amber-400/10 rounded-xl transition-all" 
                                       title="Editar">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endif

                                {{-- BOTÓN ELIMINAR --}}
                                @if(auth()->user()->hasPermission('delete_products'))
                                    <form action="{{ route('productos.destroy', $producto->id) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="confirmDelete(event, '{{ $producto->descripcion }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-400 hover:bg-red-400/10 rounded-xl transition-all" 
                                                title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty  
                    {{-- ESTADO VACÍO --}}
                    <tr>
                        <td colspan="10" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <svg class="w-20 h-20 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <span class="mt-4 text-xl font-bold italic tracking-widest uppercase text-slate-400">Sin Registros</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 mb-6">
    {{ $productos->links() }}
</div>

{{-- BLOQUE DE NAVEGACIÓN ENTRE MÓDULOS --}}
    <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-6">
        {{-- Información de contexto --}}
        <div class="text-slate-400 text-sm font-medium bg-slate-800/30 px-4 py-2 rounded-lg border border-slate-700/50">
            Navegación de Módulos: <span class="text-blue-400 font-bold uppercase ml-1">Inventario</span>
        </div>

        {{-- Botones de flujo --}}
        <div class="flex items-center gap-4">
            {{-- Anterior: Listado de Categorías --}}
            <a href="{{ route('categorias.index') }}" 
               class="group px-6 py-3 bg-slate-800 text-slate-200 rounded-2xl border border-slate-600 hover:bg-slate-700 hover:border-amber-500/50 hover:text-amber-400 text-sm font-bold flex items-center gap-3 transition-all shadow-lg active:scale-95">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                <div class="flex flex-col items-start leading-tight">
                    <span class="text-[10px] text-slate-500 uppercase font-extrabold tracking-tighter">Módulo Anterior</span>
                    <span>Listado de Categorías</span>
                </div>
            </a>

            <div class="hidden md:block h-10 w-[1px] bg-slate-700/50 mx-2"></div>

            {{-- Siguiente: Entradas --}}
            <a href="{{ route('entradas.index') }}" 
               class="group px-6 py-3 bg-slate-800 text-slate-200 rounded-2xl border border-slate-600 hover:bg-slate-700 hover:border-emerald-500/50 hover:text-emerald-400 text-sm font-bold flex items-center gap-3 transition-all shadow-lg active:scale-95 text-right">
                <div class="flex flex-col items-end leading-tight">
                    <span class="text-[10px] text-slate-500 uppercase font-extrabold tracking-tighter">Siguiente Módulo</span>
                    <span>Gestión de Entradas</span>
                </div>
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>


{{-- SCRIPT DE CONFIRMACIÓN DE ELIMINACIÓN --}}
<script>
    function confirmDelete(event, productName) {
        event.preventDefault();                                                             
        if (confirm(`¿Estás seguro de que deseas eliminar el producto "${productName}"? Esta acción no se puede deshacer.`)) {
            event.target.submit();
        }                                   

    }
</script>

@endsection



