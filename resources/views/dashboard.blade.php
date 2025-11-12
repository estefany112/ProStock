<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white-800 leading-tight">
            {{ __('Panel de Inventario - Proserve') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Bienvenido, {{ Auth::user()->name }}</h3>
                <p class="text-gray-700 mb-6">Sistema empresarial de control de inventario para Proserve</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('productos.index') }}" class="bg-green-100 text-green-700 p-6 rounded-lg text-center font-semibold shadow hover:scale-105 transition">Productos</a>
                    <a href="{{ route('entradas.index') }}" class="bg-blue-100 text-blue-700 p-6 rounded-lg text-center font-semibold shadow hover:scale-105 transition">Entradas</a>
                    <a href="#" class="bg-red-100 text-red-700 p-6 rounded-lg text-center font-semibold shadow hover:scale-105 transition">Salidas</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
