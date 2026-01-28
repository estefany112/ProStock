<x-app-layout>
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow">

    <h1 class="text-2xl font-semibold mb-6">👥 Gestión de usuarios</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border">
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
            <tr class="border-t">
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>

                <td class="p-3">
                    <form method="POST" action="{{ route('admin.users.roles', $user) }}">
                        @csrf
                        <div class="flex gap-3 flex-wrap">
                            @foreach($roles as $role)
                                <label class="flex items-center gap-1 text-sm">
                                    <input type="checkbox"
                                           name="roles[]"
                                           value="{{ $role->id }}"
                                           {{ $user->roles->contains($role) ? 'checked' : '' }}>
                                    {{ $role->label }}
                                </label>
                            @endforeach
                        </div>
                </td>

                <td class="p-3 text-center">
                        <button class="bg-blue-600 text-white px-4 py-1 rounded">
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
