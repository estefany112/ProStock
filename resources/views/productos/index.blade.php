@extends('layouts.principal')

@section('content')

<style>
    /* Animación de entrada */
    @keyframes reveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-reveal { animation: reveal 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }

    /* Resplandor que "respira" suavemente */
    @keyframes glow {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.2); }
    }
    .animate-glow { animation: glow 4s ease-in-out infinite; }

    /* Línea de escaneo sutil */
    @keyframes scan {
        0%, 100% { opacity: 0.2; transform: translateY(-2px); }
        50% { opacity: 1; transform: translateY(2px); }
    }
    .animate-scan { animation: scan 3s ease-in-out infinite; }

    /* Efecto Hover en filas */
    .table-row-hover:hover {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(8px);
    }

    .bg-mesh {
        background-color: #0f172a;
        background-image: 
            radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
    }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    {{-- Decoración de fondo --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        {{-- HEADER ESTILO CATEGORÍAS --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Catálogo Maestro de Inventario
                </span>
                <h1 class="text-5xl font-black text-white tracking-tighter flex items-center gap-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-500/40 blur-2xl rounded-full animate-glow"></div>
                        <div class="relative z-10 p-4 bg-slate-900 border border-blue-500/30 rounded-2xl text-blue-400 shadow-2xl shadow-blue-500/20">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                <path d="M7 13h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="animate-scan opacity-50"></path>
                            </svg>
                        </div>
                    </div>
                    Productos
                    <span class="text-slate-700 font-light">—</span>
                    <span class="text-xl text-slate-400 font-medium tracking-normal mt-2">{{ $productos->total() }} registros</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('prostock.index') }}"
                   class="group bg-white/5 text-slate-300 px-6 py-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Dashboard
                </a>
                @if(auth()->user()->hasPermission('create_products'))
                    <a href="{{ route('productos.create') }}"
                       class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-blue-900/40 transition-all transform hover:-translate-y-1 flex items-center gap-2 font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nuevo Producto
                    </a>
                @endif
            </div>
        </header>

        {{-- BARRA DE BÚSQUEDA REDISEÑADA ESTILO PRO --}}
        <div class="mb-10 animate-reveal" style="animation-delay: 0.1s">
            <div class="relative group">
                {{-- Efecto de resplandor sutil detrás de la barra al enfocar --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500/20 to-emerald-500/20 rounded-[2.5rem] blur opacity-25 group-focus-within:opacity-100 transition duration-1000"></div>
                
                <div class="relative bg-slate-900/50 backdrop-blur-2xl border border-white/10 p-3 rounded-[2.2rem] shadow-2xl flex items-center gap-4">
                    
                    {{-- Icono Indicador Izquierdo --}}
                    <div class="pl-4 flex items-center justify-center text-blue-400/50 group-focus-within:text-blue-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- El componente original con estilos inyectados --}}
                    <div class="flex-1">
                        <x-search-bar 
                            action="{{ route('productos.index') }}" 
                            placeholder="Escribe código, marca o descripción para filtrar..." 
                            class="bg-transparent border-none text-white placeholder-slate-500 focus:ring-0 w-full text-lg font-medium tracking-tight"
                        />
                    </div>

                    {{-- Etiquetas de ayuda visual (Badge de atajo o estado) --}}
                    <div class="hidden md:flex items-center gap-2 pr-4">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest border border-white/5 px-2 py-1 rounded-md bg-white/5">
                            Filtro Inteligente
                        </span>
                        <div class="h-4 w-[1px] bg-white/10"></div>
                        <span class="text-[9px] font-black text-blue-500/60 uppercase tracking-widest">
                            Live Mode
                        </span>
                    </div>
                </div>
            </div>
            
            {{-- Sugerencias rápidas debajo del buscador (Opcional) --}}
            <div class="mt-3 ml-6 flex gap-4">
                <span class="text-[10px] text-slate-600 font-bold uppercase tracking-tight">Sugerencias:</span>
                <button onclick="document.querySelector('input[name=\'search\']').value='Insumos'; document.querySelector('form').submit();" class="text-[10px] text-slate-400 hover:text-blue-400 transition-colors">#Insumos</button>
                <button onclick="document.querySelector('input[name=\'search\']').value='Stock Bajo'; document.querySelector('form').submit();" class="text-[10px] text-slate-400 hover:text-rose-400 transition-colors">#Stock_Bajo</button>
            </div>
        </div>

        {{-- TABLA DE DATOS ESTILO CATEGORÍAS --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl animate-reveal" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/10 text-center">
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Item</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Producto</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Imagen</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Stock</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Categoría</th>
                            @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen']))
                                <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Precio</th>
                            @endif
                            <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse ($productos as $producto)
                            <tr class="table-row-hover transition-all group">
                                <td class="px-6 py-6 text-center">
                                    <span class="text-slate-500 font-mono text-xs">#{{ $productos->total() - (($productos->currentPage() - 1) * $productos->perPage() + $loop->index) }}</span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-blue-400 font-mono font-bold text-xs tracking-wider mb-1">{{ $producto->codigo }}</span>
                                        <span class="text-slate-200 font-bold text-lg tracking-tight group-hover:text-white transition-colors">{{ $producto->descripcion }}</span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] px-2 py-0.5 bg-slate-800 text-slate-400 rounded-md font-bold uppercase">{{ $producto->marca }}</span>
                                            <span class="text-[10px] text-slate-600 italic">{{ $producto->ubicacion ?? 'Sin ubicación' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex justify-center">
                                        <img src="{{ $producto->image && file_exists(public_path('storage/' . $producto->image)) ? asset('storage/' . $producto->image) : asset('images/no-image.jpg') }}"
                                             class="w-12 h-12 rounded-xl object-cover border border-white/10 group-hover:border-blue-500/50 transition-all shadow-lg">
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black {{ $producto->stock_actual <= 5 ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' }}">
                                        {{ $producto->stock_actual }} {{ $producto->unidad_medida }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-slate-400 font-medium">
                                    {{ $producto->categoria->nombre ?? 'N/A' }}
                                </td>
                                @if(auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen']))
                                    <td class="px-6 py-6">
                                        {{-- Verificamos que el precio sea numérico y mayor a cero --}}
                                        @if(isset($producto->precio_unitario) && $producto->precio_unitario > 0)
                                            <div class="flex flex-col">
                                                <span class="text-white font-mono font-bold tracking-tighter text-lg">
                                                    <span class="text-blue-500/50 text-xs mr-0.5">Q</span>{{ number_format($producto->precio_unitario, 2) }}
                                                </span>
                                                <span class="text-[9px] text-slate-500 uppercase tracking-widest font-bold">Precio Unitario</span>
                                            </div>
                                        @else
                                            {{-- Diseño de Alerta en ROJO cuando es 0 o null --}}
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex h-3 w-3">
                                                    {{-- El puntito que parpadea --}}
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-40"></span>
                                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.4)]"></span>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-rose-500 font-black text-[11px] uppercase tracking-[0.15em] leading-none">
                                                        Sin Precio
                                                    </span>
                                                    <span class="text-[9px] text-rose-500/40 font-medium uppercase tracking-tighter mt-1">
                                                        Dato requerido
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endif
                                <td class="px-6 py-6 text-right">
                                    <div class="flex justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('productos.show', $producto->id) }}" class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                        @if(auth()->user()->hasPermission('edit_products'))
                                            <a href="{{ route('productos.edit', $producto->id) }}" class="p-2 text-amber-400 hover:bg-amber-400/10 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_products'))
                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline" onsubmit="confirmDelete(event, '{{ $producto->descripcion }}')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-20 text-center">
                                    <p class="text-slate-500 font-medium italic">No se encontraron productos en el sistema.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($productos->hasPages())
                <div class="px-8 py-6 border-t border-white/10 bg-white/[0.01]">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>

        {{-- NAVEGACIÓN MODULAR --}}
        <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-8 animate-reveal" style="animation-delay: 0.4s">
            <div class="flex items-center gap-4">
                <div class="h-px w-12 bg-white/10"></div>
                <span class="text-slate-500 text-xs font-black uppercase tracking-[0.3em]">Gestión de Flujo</span>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('categorias.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-white/5 rounded-3xl border border-white/10 text-slate-300 hover:bg-white/10 transition-all text-center">
                    <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Anterior</span>
                    <span class="font-bold tracking-tight italic">Categorías</span>
                </a>

                <a href="{{ route('entradas.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-emerald-600 text-white rounded-3xl hover:bg-emerald-500 transition-all text-center shadow-xl shadow-emerald-900/20">
                    <span class="block text-[10px] text-emerald-300 font-bold uppercase tracking-widest mb-1">Siguiente</span>
                    <span class="font-black tracking-tight italic">Entradas de Stock</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
function confirmDelete(event, nombre) {
    event.preventDefault();
    Swal.fire({
        title: 'AUTORIZACIÓN REQUERIDA',
        html: `<p style="color: #94a3b8">¿Confirmas la eliminación del producto: <br><strong style="color: #fff; font-size: 1.2rem">${nombre}</strong>?</p>`,
        icon: 'warning',
        background: '#0f172a',
        color: '#fff',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#334155',
        confirmButtonText: 'ELIMINAR REGISTRO',
        cancelButtonText: 'ABORTAR',
        customClass: {
            popup: 'rounded-[2rem] border border-white/10 backdrop-blur-xl'
        }
    }).then((result) => { if (result.isConfirmed) event.target.submit(); });
}
</script>

@endsection