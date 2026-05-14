@extends('layouts.principal')

@section('content')

{{-- Fondo oscuro del sistema para que la tarjeta blanca resalte --}}
<div class="py-10 min-h-screen bg-[#0f172a]">
    <div class="max-w-5xl mx-auto px-4">
        
        {{-- Tarjeta Principal: Ahora con fondo blanco --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl border border-slate-200">
            
            {{-- HEADER: Se mantiene oscuro como el sistema (Slate-800) --}}
            <div class="bg-slate-800 px-8 py-8 border-b border-slate-700">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-600 p-3 rounded-xl shadow-lg shadow-blue-900/20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight">Registro de Producto</h1>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Gestión de Activos — PROSERVE</p>
                    </div>
                </div>
            </div>

            {{-- FORMULARIO: Fondo blanco con textos oscuros para máxima claridad --}}
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10 text-slate-700">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    {{-- LADO IZQUIERDO: FICHA TÉCNICA --}}
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Código SKU</label>
                                <input type="text" name="codigo" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none transition-all" placeholder="Ej: SKU-1002" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Categoría</label>
                                <select name="categoria_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none">
                                    <option value="">Seleccionar...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Descripción / Nombre</label>
                            <input type="text" name="descripcion" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Marca</label>
                                <input type="text" name="marca" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Unidad</label>
                                <input type="text" name="unidad_medida" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-600 outline-none" placeholder="PZA, KG..." required>
                            </div>
                        </div>
                    </div>

                    {{-- LADO DERECHO: STOCK Y PREVIEW IMAGEN --}}
                    <div class="space-y-6 text-slate-700">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Stock Inicial</label>
                                <input type="number" name="stock_actual" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-xl font-mono font-bold focus:ring-2 focus:ring-emerald-600 outline-none shadow-sm" required>
                            </div>

                            @if(auth()->user()->hasAnyRole(['admin','compras', 'almacen']))
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Precio Unitario (Q)</label>
                                <input type="number" step="0.01" name="precio_unitario" class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-slate-900 text-xl font-mono font-bold focus:ring-2 focus:ring-emerald-600 outline-none shadow-sm">
                            </div>
                            @endif
                        </div>

                        {{-- SECCIÓN IMAGEN CON PREVISUALIZACIÓN --}}
                        <div id="image-container" class="border-2 border-dashed border-slate-300 rounded-2xl p-4 bg-slate-50 flex flex-col items-center justify-center min-h-[160px] hover:border-blue-600 transition-all cursor-pointer relative group overflow-hidden">
                            <input type="file" name="image" id="image-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            
                            <div id="preview-placeholder" class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 mb-2 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Añadir Imagen Referencial</span>
                            </div>

                            <div id="preview-wrapper" class="hidden w-full">
                                <img id="image-preview" src="#" class="w-full h-32 object-contain rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- UBICACIÓN LOGÍSTICA (FCN) --}}
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 shadow-inner">
                    <h2 class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                        📍 Localización Logística (FCN)
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(['fila_id' => 'Fila', 'columna_id' => 'Columna', 'nivel_id' => 'Nivel'] as $id => $label)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase">{{ $label }}</label>
                                <button type="button" onclick="openModal('modal{{ ucfirst(explode('_', $id)[0]) }}')" class="text-blue-600 hover:text-blue-800 transition text-[10px] font-black uppercase">+ Añadir</button>
                            </div>
                            <select id="{{ $id }}" name="{{ $id }}" class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-sm">
                                <option value="">No asignada</option>
                                @php 
                                    $data = ($id == 'fila_id') ? $filas : (($id == 'columna_id') ? $columnas : $niveles); 
                                    $key = ($id == 'fila_id') ? 'nombre' : 'numero';
                                @endphp
                                @foreach($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->$key }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex flex-col items-center border-t border-slate-200 pt-6">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 text-center">Código de Ubicación Generado</span>
                        <div class="bg-white px-10 py-3 rounded-lg border border-slate-200 shadow-lg">
                            <strong id="ubic_preview" class="text-3xl font-mono tracking-[0.2em] text-slate-800">---</strong>
                        </div>
                        <input type="hidden" name="ubicacion" id="ubicacion_hidden">
                    </div>
                </div>

                {{-- ACCIONES --}}
                <div class="flex items-center justify-end gap-6 pt-6">
                    <a href="{{ route('productos.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">
                        Descartar
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-3 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-blue-900/20 transition-all active:scale-95">
                        Registrar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODALES MANUALES (Estilo blanco) --}}

<div id="modalFila" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all">
    <div class="bg-white rounded-2xl w-full max-w-xs overflow-hidden shadow-2xl">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-800 tracking-tighter">Añadir Nueva Fila</h3>
        </div>
        <form action="{{ route('filas.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6 text-slate-800">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Nombre/Identificador</label>
                <input type="text" name="nombre" class="w-full border-slate-300 rounded-xl py-2 px-3 focus:ring-1 focus:ring-blue-600 outline-none" required autofocus>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeModal('modalFila')" class="text-[10px] font-bold text-slate-400 uppercase hover:text-slate-800 transition">Cerrar</button>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition shadow-md">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<div id="modalColumna" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all">
    <div class="bg-white rounded-2xl w-full max-w-xs overflow-hidden shadow-2xl">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-800 tracking-tighter">Añadir Nueva Columna</h3>
        </div>
        <form action="{{ route('columnas.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6 text-slate-800">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Número de Columna</label>
                <input type="text" name="numero" class="w-full border-slate-300 rounded-xl py-2 px-3 focus:ring-1 focus:ring-blue-600 outline-none" required autofocus>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeModal('modalColumna')" class="text-[10px] font-bold text-slate-400 uppercase hover:text-slate-800 transition">Cerrar</button>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition shadow-md">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<div id="modalNivel" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all">
    <div class="bg-white rounded-2xl w-full max-w-xs overflow-hidden shadow-2xl">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-800 tracking-tighter">Añadir Nuevo Nivel</h3>
        </div>
        <form action="{{ route('niveles.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6 text-slate-800">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Número de Nivel</label>
                <input type="text" name="numero" class="w-full border-slate-300 rounded-xl py-2 px-3 focus:ring-1 focus:ring-blue-600 outline-none" required autofocus>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeModal('modalNivel')" class="text-[10px] font-bold text-slate-400 uppercase hover:text-slate-800 transition">Cerrar</button>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition shadow-md">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Lógica Modales
    function openModal(id) { document.getElementById(id).classList.replace('hidden', 'flex'); }
    function closeModal(id) { document.getElementById(id).classList.replace('flex', 'hidden'); }

    // Lógica Ubicación FCN
    const sFila = document.getElementById('fila_id');
    const sCol  = document.getElementById('columna_id');
    const sNiv  = document.getElementById('nivel_id');

    function updateUbic() {
        const f = sFila.selectedOptions[0]?.text || "";
        const c = sCol.selectedOptions[0]?.text || "";
        const n = sNiv.selectedOptions[0]?.text || "";

        if (f && c && n && !f.includes('asignada') && !n.includes('asignado')) {
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