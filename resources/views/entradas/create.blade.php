<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Entrada de Producto') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <!-- Formulario para registrar la entrada -->
            <form action="{{ route('entradas.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Producto -->
                    <div>
                        <label for="producto_id" class="block">Producto</label>
                        <select name="producto_id" id="producto_id" class="mt-1 block w-full" required>
                            <option value="">Selecciona un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cantidad -->
                    <div>
                        <label for="cantidad" class="block">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="mt-1 block w-full" required min="1">
                    </div>

                    <!-- Motivo -->
                    <div>
                        <label for="motivo" class="block">Motivo</label>
                        <input type="text" name="motivo" id="motivo" class="mt-1 block w-full" required>
                    </div>

                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg">Registrar Entrada</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
</x-app-layout>
