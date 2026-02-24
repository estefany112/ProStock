<section class="bg-white p-6 rounded-xl shadow-sm">

    {{-- Encabezado --}}
    <header class="mb-6 border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            Información Personal
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Actualiza tu información de perfil y correo electrónico.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nombre
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                class="w-full border border-gray-300 rounded-lg px-4 py-2
                       focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                       transition duration-150 bg-white text-gray-800 shadow-sm"
            >

            @error('name')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Correo Electrónico
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2
                       focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                       transition duration-150 bg-white text-gray-800 shadow-sm"
            >

            @error('email')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Avátar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Foto de Perfil
            </label>

            <input
                type="file"
                name="avatar"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
            >

            @error('avatar')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Teléfono
            </label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone', $user->phone) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2
                    focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
            >

            @error('phone')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex items-center justify-between pt-4 border-t">

            <div>
                @if (session('status') === 'profile-updated')
                    <span class="inline-flex items-center text-sm text-green-600 font-medium">
                        ✔ Información actualizada correctamente
                    </span>
                @endif
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white
                       px-6 py-2 rounded-lg shadow-sm
                       transition duration-200 font-medium">
                Guardar Cambios
            </button>

        </div>

    </form>

</section>