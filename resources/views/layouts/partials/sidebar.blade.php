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

            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.users') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.users') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    👥 <span> Gestión de Usuarios</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-gray-700">
        <div class="flex items-start gap-3">

            <!-- Avatar -->
            <div class="w-9 h-9 rounded-full bg-gray-600 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <!-- Info usuario -->
            <div class="flex-1">
                <p class="text-sm font-semibold text-white">
                    {{ auth()->user()->name }}
                </p>

                <!-- Roles -->
                <div class="flex flex-wrap gap-1 mt-1">
                    @forelse(auth()->user()->roles as $role)

                        @switch($role->name)
                            @case('admin')
                                <span class="px-2 py-0.5 text-xs rounded bg-red-100 text-red-700">
                                    {{ $role->label }}
                                </span>
                                @break

                            @case('almacen')
                                <span class="px-2 py-0.5 text-xs rounded bg-green-100 text-green-700">
                                    {{ $role->label }}
                                </span>
                                @break

                            @case('operativo')
                                <span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-700">
                                    {{ $role->label }}
                                </span>
                                @break

                            @case('supervisor')
                                <span class="px-2 py-0.5 text-xs rounded bg-purple-100 text-purple-700">
                                    {{ $role->label }}
                                </span>
                                @break

                            @case('compras')
                                <span class="px-2 py-0.5 text-xs rounded bg-blue-100 text-blue-700">
                                    {{ $role->label }}
                                </span>
                                @break

                            @case('auditor')
                                <span class="px-2 py-0.5 text-xs rounded bg-gray-200 text-gray-700">
                                    {{ $role->label }}
                                </span>
                                @break

                            @default
                                <span class="px-2 py-0.5 text-xs rounded bg-slate-100 text-slate-700">
                                    {{ $role->label }}
                                </span>
                        @endswitch

                    @empty
                        <span class="text-xs text-gray-400">Sin rol asignado</span>
                    @endforelse
                </div>

                <!-- Perfil -->
                <a href="{{ route('profile.edit') }}"
                class="text-xs text-gray-400 hover:underline mt-1 inline-block">
                    Editar perfil
                </a>
            </div>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button class="text-sm text-red-400 hover:underline">
                Cerrar sesión
            </button>
        </form>
    </div>

</aside>
