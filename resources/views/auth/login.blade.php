<x-guest-layout>

    <div class="w-full max-w-md bg-white rounded-xl shadow-xl overflow-hidden">

        <!-- Imagen dentro de la tarjeta -->
        <div class="h-36 bg-cover bg-center"
             style="background-image: url('{{ asset('assets/img/img-login.png') }}');">

            <div class="flex items-center justify-center h-full bg-black/30">
                <h2 class="text-2xl font-bold text-white">
                    INICIAR SESIÓN
                </h2>
            </div>

        </div>

        <!-- Formulario -->
        <div class="p-8">

            <x-auth-session-status
                class="mb-4 text-sm text-green-600"
                :status="session('status')"
            />

            {{-- MENSAJE DE ACCESO DENEGADO --}}
            @if(session('access_denied'))
                <div class="mb-5 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">

                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-amber-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86l-7.4 12.8A2 2 0 004.62 19h14.76a2 2 0 001.73-2.34l-7.4-12.8a2 2 0 00-3.42 0z"/>
                    </svg>

                    <div>
                        <p class="font-medium">
                            Acceso no disponible
                        </p>

                        <p class="mt-0.5 text-amber-700">
                            {{ session('access_denied') }}
                        </p>
                    </div>

                </div>
            @endif

            <form method="POST"
                  action="{{ route('login') }}"
                  class="space-y-6">

                @csrf

                <div>
                    <label for="email"
                           class="block text-sm font-semibold mb-1">
                        Correo Electrónico
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           placeholder="Ingrese Correo Electrónico"
                           required
                           autofocus
                           class="w-full border-b border-gray-300 focus:outline-none focus:border-gray-600 text-sm py-1.5" />
                </div>

                <div>
                    <label for="password"
                           class="block text-sm font-semibold mb-1">
                        Contraseña
                    </label>

                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Ingrese Contraseña"
                           required
                           class="w-full border-b border-gray-300 focus:outline-none focus:border-gray-600 text-sm py-1.5" />
                </div>

                <div class="flex items-center justify-between text-sm mt-2">

                    <label class="inline-flex items-center">
                        <input type="checkbox"
                               name="remember"
                               class="mr-2 border-gray-300 rounded">

                        Recordarme
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-gray-500 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                </div>

                <div class="mt-4">
                    <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-full transition">
                        Iniciar sesión
                    </button>
                </div>

                {{-- 
                    En un sistema empresarial recomiendo quitar
                    el registro público y que los usuarios sean
                    creados por un administrador.
                --}}

            </form>
        </div>
    </div>

</x-guest-layout>