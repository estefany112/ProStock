<aside class="w-64 bg-slate-900 text-white flex flex-col justify-between min-h-screen">

    <!-- LOGO -->
    <div>
        <div class="p-5 text-xl font-bold border-b border-gray-700">
            PROSERVE
        </div>

        <!-- MENU -->
        <nav class="mt-4 space-y-1 px-3">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->routeIs('dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                🏠 <span>Dashboard</span>
            </a>

            <!-- Inventario (submenu) -->
            <div x-data="{ open: {{ request()->routeIs('prostock.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700">
                    <span class="flex items-center gap-3">
                        📦 <span>Inventario</span>
                    </span>
                    <span x-text="open ? '▾' : '▸'"></span>
                </button>

                <div x-show="open" x-collapse class="ml-6 mt-1 space-y-1">
                    <a href="{{ route('prostock.index') }}"
                       class="block px-3 py-1.5 rounded hover:bg-gray-700
                       {{ request()->routeIs('prostock.index') ? 'bg-blue-600' : '' }}">
                        ProStock
                    </a>
                </div>
            </div>

             <!-- Empleados -->
            @if(auth()->user()->hasPermission('employee.view'))
            <div x-data="{ openEmployees: {{ request()->routeIs('employees.*') ? 'true' : 'false' }} }">

                <button @click="openEmployees = !openEmployees"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700">
                    <span class="flex items-center gap-3">
                        👥 <span>RRHH</span>
                    </span>
                    <span x-text="openEmployees ? '▾' : '▸'"></span>
                </button>

                <div x-show="openEmployees" x-collapse class="ml-6 mt-1 space-y-1">

                    {{-- Opción 1: Listado --}}
                    <a href="{{ route('employees.index') }}"
                    class="block px-3 py-1.5 rounded hover:bg-gray-700
                    {{ request()->routeIs('employees.index') ? 'bg-blue-600' : '' }}">
                        Empleados
                    </a>

                    {{-- Opción 2: Crear --}}
                    <a href="{{ route('planillas.index') }}"
                    class="block px-3 py-1.5 rounded hover:bg-gray-700
                    {{ request()->routeIs('employees.create') ? 'bg-blue-600' : '' }}">
                        Planillas
                    </a>

                </div>
            </div>
        @endif

            <!-- Administración -->
            @if(auth()->user()->hasAnyRole(['admin','rrhh']))
                <div x-data="{ openAdmin: {{ request()->routeIs('admin.*') ? 'true' : 'false' }} }">

                    <button @click="openAdmin = !openAdmin"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700">
                        <span class="flex items-center gap-3">
                            ⚙️ <span>Administración</span>
                        </span>
                        <span x-text="openAdmin ? '▾' : '▸'"></span>
                    </button>

                    <div x-show="openAdmin" x-collapse class="ml-6 mt-1 space-y-1">
                        <a href="{{ route('admin.users') }}"
                           class="block px-3 py-1.5 rounded hover:bg-gray-700
                           {{ request()->routeIs('admin.users') ? 'bg-blue-600' : '' }}">
                            Usuarios
                        </a>
                    </div>

                </div>
            @endif

            <!-- Finanzas -->
            @if(auth()->user()->hasAnyRole(['admin','auditor']))
                <div x-data="{ openFinance: {{ request()->routeIs('caja.*') ? 'true' : 'false' }} }">

                    <button @click="openFinance = !openFinance"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-700">
                        <span class="flex items-center gap-3">
                            💵 <span>Finanzas</span>
                        </span>
                        <span x-text="openFinance ? '▾' : '▸'"></span>
                    </button>

                    <div x-show="openFinance" x-collapse class="ml-6 mt-1 space-y-1">
                        <a href="{{ route('caja.index') }}"
                           class="block px-3 py-1.5 rounded hover:bg-gray-700
                           {{ request()->routeIs('caja.*') ? 'bg-blue-600' : '' }}">
                            Caja Chica
                        </a>
                    </div>

                </div>
            @endif

        </nav>
    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-gray-700">
        <div class="flex items-start gap-3">

            <div class="w-9 h-9 rounded-full bg-gray-600 flex items-center justify-center font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="flex-1">
                <p class="text-sm font-semibold">
                    {{ auth()->user()->name }}
                </p>

                <div class="flex flex-wrap gap-1 mt-1">
                    @forelse(auth()->user()->roles as $role)
                        <span class="px-2 py-0.5 text-xs rounded bg-slate-100 text-slate-700">
                            {{ $role->label }}
                        </span>
                    @empty
                        <span class="text-xs text-gray-400">
                            Sin rol asignado
                        </span>
                    @endforelse
                </div>

                <a href="{{ route('profile.edit') }}"
                   class="text-xs text-gray-400 hover:underline mt-1 inline-block">
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
