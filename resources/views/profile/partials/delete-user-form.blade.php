<section>

    <header class="mb-6">

         <h3 class="text-lg font-bold text-red">
            Zona de riesgo
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Una vez que elimines tu cuenta, toda tu información será eliminada permanentemente.
            Esta acción no se puede deshacer.
        </p>
    </header>

    <div class="bg-red-50 border border-red-200 rounded-xl p-6">

        <form method="POST"
              action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción es permanente.');">

            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="password" class="block text-sm text-gray-600 mb-1">
                    Confirma tu contraseña
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2
                           focus:ring-2 focus:ring-red-500 focus:outline-none
                           bg-white text-gray-800"
                >

                @error('password', 'userDeletion')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white
                               px-5 py-2 rounded-lg shadow-sm transition">
                    Eliminar Cuenta
                </button>

            </div>

        </form>

    </div>

</section>