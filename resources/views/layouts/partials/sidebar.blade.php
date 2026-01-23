<aside class="w-64 bg-slate-900 text-white flex flex-col justify-between">

    <!-- LOGO -->
    <div>
        <div class="p-5 text-xl font-bold border-b border-gray-700">
            PROSERVE
        </div>

        <!-- MENU -->
        <nav class="mt-4 space-y-1 px-3">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                🏠 <span>Dashboard</span>
            </a>

            <a href="{{ route('prostock.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('prostock.*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                📦 <span>Inventario - ProStock</span>
            </a>

        </nav>
    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gray-600 flex items-center justify-center">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div>
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <a href="{{ route('profile.edit') }}"
                   class="text-xs text-gray-400 hover:underline">
                    Editar perfil
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button class="text-sm text-red-400 hover:underline">
                Cerrar sesión
            </button>
        </form>
    </div>

</aside>
