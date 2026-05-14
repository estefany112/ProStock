@extends('layouts.principal')

@section('content')

<style>
    
    @keyframes reveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-reveal { animation: reveal 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
    
    /* Estilo para filas de tabla al pasar el mouse */
    .table-row-hover:hover {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(8px);
    }
</style>

<div class="min-h-screen bg-mesh py-12 px-6 relative overflow-hidden">
    {{-- Decoración de fondo --}}
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-emerald-500/5 blur-[100px] rounded-full"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        
        {{-- HEADER --}}
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-reveal">
            <div>
                <span class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block">
                    Base de Datos de Inventario
                </span>
                <h1 class="text-5xl font-black text-white tracking-tighter flex items-center gap-6">
                    <div class="relative">
                        {{-- Resplandor de fondo (Luz ambiental sutil) --}}
                        <div class="absolute inset-0 bg-emerald-500/40 blur-2xl rounded-full animate-glow"></div>
                        
                        {{-- Contenedor del Icono --}}
                        <div class="relative z-10 p-4 bg-slate-900 border border-emerald-500/30 rounded-2xl text-emerald-400 shadow-2xl shadow-emerald-500/20">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                {{-- Línea de escaneo sutil --}}
                                <path d="M7 13h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="animate-scan opacity-50"></path>
                            </svg>
                        </div>
                    </div>
                    Categorías
                    <span class="text-slate-700 font-light">—</span>
                    <span class="text-xl text-slate-400 font-medium tracking-normal mt-2">{{ $categorias->total() }} registros</span>
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
                <a href="{{ route('categorias.create') }}"
                   class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-emerald-900/40 transition-all transform hover:-translate-y-1 flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Categoría
                </a>
            </div>
        </header>

        {{-- ALERTAS --}}
        @if(session('success'))
            <div class="mb-6 animate-reveal">
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl flex items-center gap-3 backdrop-blur-xl">
                    <div class="p-1.5 bg-emerald-500/20 rounded-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- TABLA DE DATOS --}}
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl animate-reveal" style="animation-delay: 0.2s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/10">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Referencia</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Nombre de Categoría</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Acciones de Control</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse($categorias as $categoria)
                            <tr class="table-row-hover transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500/40 group-hover:bg-emerald-400 transition-colors"></span>
                                        <span class="text-slate-500 font-mono text-sm tracking-tighter">ID_{{ sprintf('%03d', $categoria->id) }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-slate-200 font-bold text-lg tracking-tight group-hover:text-white transition-colors">
                                        {{ $categoria->nombre }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('categorias.edit', $categoria->id) }}"
                                           class="p-2.5 text-blue-400 hover:bg-blue-400/10 rounded-xl border border-transparent hover:border-blue-400/20 transition-all" 
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        @if(auth()->user()->hasPermission('delete_categorias'))
                                            <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                                method="POST"
                                                onsubmit="confirmDelete(event, '{{ $categoria->nombre }}')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2.5 text-rose-400 hover:bg-rose-400/10 rounded-xl border border-transparent hover:border-rose-400/20 transition-all">
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
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="p-6 bg-white/5 rounded-full text-slate-600">
                                            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-medium italic">El archivo de categorías está vacío.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($categorias->hasPages())
            <div class="px-8 py-6 border-t border-white/10 bg-white/[0.01]">
                {{ $categorias->links() }}
            </div>
            @endif
        </div>

        {{-- NAVEGACIÓN --}}
        <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-8 animate-reveal" style="animation-delay: 0.4s">
            <div class="flex items-center gap-4">
                <div class="h-px w-12 bg-white/10"></div>
                <span class="text-slate-500 text-xs font-black uppercase tracking-[0.3em]">Continuar Flujo</span>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('prostock.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-white/5 rounded-3xl border border-white/10 text-slate-300 hover:bg-white/10 transition-all text-center">
                    <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Volver</span>
                    <span class="font-bold tracking-tight italic">Menú Principal</span>
                </a>

                <a href="{{ route('productos.index') }}" 
                   class="flex-1 md:flex-none group px-8 py-4 bg-white text-slate-900 rounded-3xl hover:bg-blue-50 transition-all text-center shadow-xl shadow-white/5">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Siguiente</span>
                    <span class="font-black tracking-tight italic">Gestión de Productos</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(event, nombre) {
    event.preventDefault();
    Swal.fire({
        title: 'AUTORIZACIÓN REQUERIDA',
        html: `<p style="color: #94a3b8">¿Confirmas la eliminación permanente de la categoría: <br><strong style="color: #fff; font-size: 1.2rem">${nombre}</strong>?</p>`,
        icon: 'warning',
        background: '#0f172a',
        color: '#fff',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#334155',
        confirmButtonText: 'ELIMINAR REGISTRO',
        cancelButtonText: 'ABORTAR',
        buttonsStyling: true,
        customClass: {
            popup: 'rounded-[2rem] border border-white/10 backdrop-blur-xl',
            confirmButton: 'rounded-xl font-bold px-6 py-3',
            cancelButton: 'rounded-xl font-bold px-6 py-3'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
}
</script>

@endsection