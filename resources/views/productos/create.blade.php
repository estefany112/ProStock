<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Producto – Proserve S.A.
        </h2>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto">
        <div class="bg-white p-8 rounded-xl shadow-md">

            <form action="{{ route('productos.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Código -->
                <div>
                    <label class="block font-medium">Código</label>
                    <input type="text" name="codigo"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <!-- Nombre del artículo -->
                <div>
                    <label class="block font-medium">Nombre del artículo</label>
                    <input type="text" name="descripcion"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block font-medium">Categoría</label>
                    <select name="categoria_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Marca -->
                <div>
                    <label class="block font-medium">Marca</label>
                    <input type="text" name="marca"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <!-- Unidad de medida -->
                <div>
                    <label class="block font-medium">Unidad de medida</label>
                    <input type="text" name="unidad_medida"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block font-medium">Stock Actual</label>
                    <input type="number" name="stock_actual"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
                </div>

                <!-- Precio -->
                @php
                    $puedeEditarPrecio = auth()->user()->hasRole('admin')
                        || auth()->user()->hasRole('compras');
                @endphp

                @if($puedeEditarPrecio)
                <div>
                    <label class="block font-medium">Precio Unitario</label>
                    <input type="number" step="0.01" name="precio_unitario"
                        class="w-full border rounded-lg px-3 py-2">
                </div>
                @endif

                <!-- UBICACIÓN -->
                <div class="space-y-2">
                    <label class="block font-semibold text-lg">Ubicación (FCN)</label>

                    <!-- FILA -->
                    <div>
                        <label class="font-medium">Fila</label>
                        <div class="flex gap-2">
                            <select id="fila_id" name="fila_id" class="border rounded-lg px-3 py-2 flex-1">
                                <option value="">No tiene ubicación</option>
                                @foreach($filas as $fila)
                                    <option value="{{ $fila->id }}">{{ $fila->nombre }}</option>
                                @endforeach
                            </select>

                            <button type="button" onclick="openModal('modalFila')"
                                class="px-4 bg-green-600 text-white rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- COLUMNA -->
                    <div>
                        <label class="font-medium">Columna</label>
                        <div class="flex gap-2">
                            <select id="columna_id" name="columna_id" class="border rounded-lg px-3 py-2 flex-1">
                                <option value="">No tiene ubicación</option>
                                @foreach($columnas as $col)
                                    <option value="{{ $col->id }}">{{ $col->numero }}</option>
                                @endforeach
                            </select>

                            <button type="button" onclick="openModal('modalColumna')"
                                class="px-4 bg-green-600 text-white rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- NIVEL -->
                    <div>
                        <label class="font-medium">Nivel</label>
                        <div class="flex gap-2">
                            <select id="nivel_id" name="nivel_id" class="border rounded-lg px-3 py-2 flex-1">
                                <option value="">No tiene ubicación</option>
                                @foreach($niveles as $niv)
                                    <option value="{{ $niv->id }}">{{ $niv->numero }}</option>
                                @endforeach
                            </select>

                            <button type="button" onclick="openModal('modalNivel')"
                                class="px-4 bg-green-600 text-white rounded-lg">+</button>
                        </div>
                    </div>

                    <p class="text-sm text-gray-700 mt-2">
                        Vista previa: <strong id="ubic_preview"></strong>
                    </p>

                    <input type="hidden" name="ubicacion" id="ubicacion_hidden">
                </div>

                <!-- BOTÓN -->
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-lg">
                    Crear Producto
                </button>
            </form>
        </div>
    </div>

    <!-- Fila -->
    <div id="modalFila" class="fixed inset-0 bg-black/60 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-xl w-96">
            <h3 class="text-lg font-semibold mb-4">Crear Fila</h3>
            <form action="{{ route('filas.store') }}" method="POST">
                @csrf
                <input type="text" name="nombre" placeholder="Nombre de la fila"
                    class="w-full border rounded-lg px-3 py-2 mb-4">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalFila')" class="px-3 py-2">Cancelar</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Columna -->
    <div id="modalColumna" class="fixed inset-0 bg-black/60 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-xl w-96">
            <h3 class="text-lg font-semibold mb-4">Crear Columna</h3>
            <form action="{{ route('columnas.store') }}" method="POST">
                @csrf
                <input type="text" name="numero" placeholder="Número de la fila"
                    class="w-full border rounded-lg px-3 py-2 mb-4">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalColumna')" class="px-3 py-2">Cancelar</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Nivel -->
    <div id="modalNivel" class="fixed inset-0 bg-black/60 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-xl w-96">
            <h3 class="text-lg font-semibold mb-4">Crear Nivel</h3>
            <form action="{{ route('niveles.store') }}" method="POST">
                @csrf
                <input type="text" name="numero" placeholder="Número del nivel"
                    class="w-full border rounded-lg px-3 py-2 mb-4">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalNivel')" class="px-3 py-2">Cancelar</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        const filaSel = document.getElementById('fila_id');
        const colSel = document.getElementById('columna_id');
        const nivSel = document.getElementById('nivel_id');

        function updateUbic() {
            const fila = filaSel?.selectedOptions[0]?.text || "";
            const col = colSel?.selectedOptions[0]?.text || "";
            const niv = nivSel?.selectedOptions[0]?.text || "";

            if (fila && col && niv) {
                const ubic = fila + col + niv;
                document.getElementById('ubic_preview').textContent = ubic;
                document.getElementById('ubicacion_hidden').value = ubic;
            }
        }

        filaSel.onchange = updateUbic;
        colSel.onchange = updateUbic;
        nivSel.onchange = updateUbic;
    </script>

</x-app-layout>
