@extends('layouts.principal')

@section('content')

<div class="max-w-6xl mx-auto pt-12 pb-12">
    {{-- HEADER DE LA VISTA --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight flex items-center gap-3">
                <span class="p-2 bg-emerald-500/10 rounded-lg text-emerald-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </span>
                Categorías
            </h1>
            <p class="text-slate-400 mt-2">Gestión de categorías de productos para el inventario PROSERVE.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('prostock.index') }}"
               class="bg-slate-800 text-slate-300 px-5 py-2.5 rounded-xl border border-slate-700 hover:bg-slate-700 transition flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                Menú Inventario
            </a>
            <a href="{{ route('categorias.create') }}"
               class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-900/20 transition flex items-center gap-2 font-semibold">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Categoría
            </a>
        </div>
    </div>

    {{-- CONTENEDOR DE LA TABLA --}}
    <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl overflow-hidden shadow-xl">
        
        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="m-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre de Categoría</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-700">
                    @forelse($categorias as $categoria)
                        <tr class="hover:bg-slate-700/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-slate-500 font-mono text-sm">#{{ $categoria->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-slate-200 font-medium">{{ $categoria->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('categorias.edit', $categoria->id) }}"
                                       class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition" 
                                       title="Editar">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    @if(auth()->user()->hasPermission('delete_categorias'))
                                        <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                            method="POST"
                                            onsubmit="confirmDelete(event, '{{ $categoria->nombre }}')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:bg-red-400/10 rounded-lg transition" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p>No hay categorías registradas aún.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categorias->hasPages())
        <div class="px-6 py-4 border-t border-slate-700 bg-slate-900/20">
            {{ $categorias->links() }}
        </div>
        @endif
    </div>

    <div class="mt-8 flex justify-end">
        <a href="{{ route('productos.index') }}"
           class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-900/20 transition flex items-center gap-3 font-bold">
            Ir a Productos
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</div>

<script>
function confirmDelete(event, nombre) {
    event.preventDefault();
    Swal.fire({
        title: '¿Eliminar categoría?',
        html: `<p class="text-slate-300">Estás por borrar <span class="text-white font-bold">${nombre}</span>.<br>Esta acción es permanente.</p>`,
        icon: 'warning',
        background: '#1e293b',
        color: '#fff',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#475569',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
}
</script>

@endsection