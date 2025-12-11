<x-app-layout>
  <x-slot name="header"><h2>Crear Columna</h2></x-slot>
  <div class="max-w-md mx-auto p-6 bg-white rounded">
    <form action="{{ route('columnas.store') }}" method="POST">
      @csrf
      <label>Número (ej: 1, 2, 3)</label>
      <input name="numero" class="w-full border p-2 mb-3" required>
      <button class="bg-green-600 text-white px-4 py-2 rounded">Crear</button>
      <a href="{{ route('columnas.index') }}" class="ml-2">Cancelar</a>
    </form>
  </div>
</x-app-layout>
