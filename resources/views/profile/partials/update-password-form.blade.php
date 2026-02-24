<section class="bg-white p-6 rounded-xl shadow-sm">

    {{-- Encabezado --}}
    <header class="mb-6 border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            Seguridad
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Actualiza tu contraseña para mantener tu cuenta segura.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Contraseña actual --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Contraseña Actual
            </label>

            <input
                type="password"
                name="current_password"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2
                       focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                       transition duration-150 bg-white text-gray-800 shadow-sm"
            >

            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nueva contraseña --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nueva Contraseña
            </label>

            <input
                type="password"
                name="password"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2
                       focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                       transition duration-150 bg-white text-gray-800 shadow-sm"
            >

            @error('password', 'updatePassword')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Confirmar Nueva Contraseña
            </label>

            <input
                type="password"
                name="password_confirmation"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2
                       focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                       transition duration-150 bg-white text-gray-800 shadow-sm"
            >
        </div>

        {{-- Botón --}}
        <div class="flex items-center justify-between pt-4 border-t">

            @if (session('status') === 'password-updated')
                <span class="text-sm text-green-600 font-medium">
                    ✔ Contraseña actualizada correctamente
                </span>
            @endif

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white
                       px-6 py-2 rounded-lg shadow-sm
                       transition duration-200 font-medium">
                Actualizar Contraseña
            </button>

        </div>

    </form>

</section>