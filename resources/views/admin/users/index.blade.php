<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow">

        <h1 class="text-2xl font-semibold mb-6">👥 Gestión de usuarios</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border border-gray-200 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Usuario</th>
                    <th class="p-3 text-left">Correo</th>
                    <th class="p-3 text-left">Roles</th>
                    <th class="p-3 text-center">Acción</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr class="border-t align-top">
                        <td class="p-3 font-medium">
                            {{ $user->name }}
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $user->email }}
                        </td>

                        {{-- FORMULARIO ÚNICO POR USUARIO --}}
                        <td class="p-3">
                            <form method="POST" action="{{ route('admin.users.roles', $user) }}">
                                @csrf
                                @method('POST')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($roles as $role)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input
                                                type="checkbox"
                                                name="roles[]"
                                                value="{{ $role->id }}"
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                            >
                                            <span>{{ $role->label ?? $role->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                        </td>

                        <td class="p-3 text-center">
                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm"
                                >
                                    Guardar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
