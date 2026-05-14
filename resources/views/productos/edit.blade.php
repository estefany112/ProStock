@extends('layouts.principal')

@section('content')

{{-- Contenedor con fondo oscuro para resaltar la tarjeta blanca --}}
<div class="py-10 min-h-screen bg-[#0f172a]">
    <div class="max-w-5xl mx-auto px-4">
        
        {{-- Tarjeta Principal --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl border border-slate-200">
            
            {{-- HEADER: Mismo estilo oscuro del sistema --}}
            <div class="bg-slate-800 px-8 py-8 border-b border-slate-700">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-600 p-3 rounded-xl shadow-lg shadow-blue-900/20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight">Editar Producto</h1>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Actualización de Registro — PROSERVE</p>
                    </div>
                </div>
            </div>

            {{-- FORMULARIO --}}
            <form action="{{ route('productos.update', $producto) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="p-8 space-y-10 text-slate-700">
                @csrf
                @method('PUT')

                {{-- Persistencia de búsqueda/página --}}
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="page" value="{{ request('page') }}">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    {{-- LADO IZQUIERDO: DATOS GENERALES --}}
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Código SKU</label>
                                <input type="text" name="codigo" value="{{ $producto->codigo }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none transition-all" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Categoría</label>
                                <select name="categoria_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none">
                                    <option value="">Sin categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" @selected($producto->categoria_id == $categoria->id)>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Descripción del Artículo</label>
                            <input type="text" name="descripcion" value="{{ $producto->descripcion }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Marca</label>
                                <input type="text" name="marca" value="{{ $producto->marca }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Unidad</label>
                                <input type="text" name="unidad_medida" value="{{ $producto->unidad_medida }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none" required>
                            </div>
                        </div>
                    </div>

                    {{-- LADO DERECHO: STOCK E IMAGEN --}}
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-6 shadow-inner">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Stock Actual (Solo lectura)</label>
                                    <input type="number" value="{{ $producto->stock_actual }}" readonly class="w-full bg-slate-200 border-slate-300 rounded-xl px-4 py-3 text-slate-600 text-xl font-mono font-bold outline-none cursor-not-allowed">
                                    <input type="hidden" name="stock_actual" value="{{ $producto->stock_actual }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Precio Unitario ($)</label>
                                    @php
                                        $puedeEditarPrecio = auth()->user()->hasAnyRole(['admin','compras', 'almacen']);
                                        $puedeVerPrecio = auth()->user()->hasAnyRole(['admin','compras','auditor','supervisor', 'almacen']);
                                    @endphp

                                    @if($puedeEditarPrecio)
                                        <input type="number" step="0.01" name="precio_unitario" value="{{ $producto->precio_unitario }}" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-xl font-mono font-bold focus:ring-2 focus:ring-emerald-600 outline-none shadow-sm" required>
                                    @else
                                        <input type="text" readonly class="w-full bg-slate-200 border-slate-300 rounded-xl px-4 py-3 text-slate-600 text-xl font-mono font-bold outline-none" 
                                               value="{{ $puedeVerPrecio && $producto->precio_unitario > 0 ? '$ ' . number_format($producto->precio_unitario, 2) : '---' }}">
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- SECCIÓN IMAGEN --}}
                        <div id="image-container" class="border-2 border-dashed border-slate-300 rounded-2xl p-4 bg-slate-50 flex flex-col items-center justify-center min-h-[160px] hover:border-blue-600 transition-all cursor-pointer relative group overflow-hidden">
                            <input type="file" name="image" id="image-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            
                            {{-- Si ya tiene imagen, mostrarla por defecto --}}
                            <div id="preview-placeholder" class="{{ $producto->image_path ? 'hidden' : '' }} text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 mb-2 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cambiar Imagen</span>
                            </div>

                            <div id="preview-wrapper" class="{{ $producto->image_path ? '' : 'hidden' }} w-full">
                                <img id="image-preview" src="{{ $producto->image_path ? asset('storage/' . $producto->image_path) : '#' }}" class="w-full h-32 object-contain rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- UBICACIÓN LOGÍSTICA (FCN) --}}
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 shadow-inner">
                    <h2 class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                        📍 Localización Logística Actual (FCN)
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Fila --}}
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Fila</label>
                            <select id="fila_id" name="fila_id" class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800 focus:ring-1 focus:ring-blue-500 outline-none shadow-sm">
                                <option value="">No tiene ubicación</option>
                                @foreach($filas as $fila)
                                    <option value="{{ $fila->id }}" @selected($producto->fila_id == $fila->id)>{{ $fila->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Columna --}}
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Columna</label>
                            <select id="columna_id" name="columna_id" class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800 focus:ring-1 focus:ring-blue-500 outline-none shadow-sm">
                                <option value="">No tiene ubicación</option>
                                @foreach($columnas as $col)
                                    <option value="{{ $col->id }}" @selected($producto->columna_id == $col->id)>{{ $col->numero }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Nivel --}}
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Nivel</label>
                            <select id="nivel_id" name="nivel_id" class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800 focus:ring-1 focus:ring-blue-500 outline-none shadow-sm">
                                <option value="">No tiene ubicación</option>
                                @foreach($niveles as $niv)
                                    <option value="{{ $niv->id }}" @selected($producto->nivel_id == $niv->id)>{{ $niv->numero }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col items-center border-t border-slate-200 pt-6">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 text-center">Código FCN Resultante</span>
                        <div class="bg-white px-10 py-3 rounded-lg border border-slate-200 shadow-lg">
                            <strong id="ubic_preview" class="text-3xl font-mono tracking-[0.2em] text-slate-800">{{ $producto->ubicacion ?? '---' }}</strong>
                        </div>
                        <input type="hidden" name="ubicacion" id="ubicacion_hidden" value="{{ $producto->ubicacion }}">
                    </div>
                </div>

                {{-- ACCIONES --}}
                <div class="flex items-center justify-end gap-6 pt-6">
                    <a href="{{ route('productos.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-3 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-blue-900/20 transition-all active:scale-95">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Lógica Ubicación FCN
    const sFila = document.getElementById('fila_id');
    const sCol  = document.getElementById('columna_id');
    const sNiv  = document.getElementById('nivel_id');

    function updateUbic() {
        const f = sFila.selectedOptions[0]?.text || "";
        const c = sCol.selectedOptions[0]?.text || "";
        const n = sNiv.selectedOptions[0]?.text || "";

        if (f && c && n && !f.includes('tiene') && !f.includes('ubicación')) {
            const code = (f.charAt(0) + c + n).toUpperCase().replace(/\s/g, '');
            document.getElementById('ubic_preview').textContent = code;
            document.getElementById('ubicacion_hidden').value = code;
        } else {
            document.getElementById('ubic_preview').textContent = "---";
        }
    }
    [sFila, sCol, sNiv].forEach(el => el.addEventListener('change', updateUbic));

    // Lógica Preview Imagen
    const imgIn = document.getElementById('image-input');
    const imgPl = document.getElementById('preview-placeholder');
    const imgWr = document.getElementById('preview-wrapper');
    const imgPr = document.getElementById('image-preview');

    imgIn.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imgPr.src = e.target.result;
                imgPl.classList.add('hidden');
                imgWr.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection