<x-app-layout>
  <x-slot name="header"><h2>Niveles</h2></x-slot>
  <div class="max-w-4xl mx-auto p-6 bg-white rounded">
    <a href="{{ route('niveles.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">+ Nuevo Nivel</a>
    @if(session('success')) <div class="mt-4 p-2 bg-green-100">{{ session('success') }}</div> @endif
    <table class="w-full mt-4">
      <thead><tr><th>ID</th><th>Número</th><th>Acciones</th></tr></thead>
      <tbody>
        @foreach($niveles as $nivel)
          <tr class="border-t">
            <td class="p-2">{{ $nivel->id }}</td>
            <td class="p-2">{{ $nivel->numero }}</td>
            <td class="p-2">
              <a href="{{ route('niveles.edit', $nivel->id) }}" class="text-blue-600 mr-2">Editar</a>
              <form action="{{ route('niveles.destroy', $nivel->id) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar?')">
                @csrf @method('DELETE')
                <button class="text-red-600">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-app-layout>
