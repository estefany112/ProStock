<aside x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col h-screen overflow-y-auto shadow-2xl">

    <nav class="flex-1 px-4 py-6 space-y-2">
        
        <a href="{{ route('dashboard') }}"
           class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
           {{ request()->routeIs('dashboard') ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-emerald-400 hover:bg-slate-900' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        @if(auth()->user()->hasAnyRole(['admin','almacen']))
            <div x-data="{ open: {{ request()->routeIs('solicitudes.*') || request()->routeIs('prostock.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-400 hover:text-blue-400 hover:bg-slate-900 transition-all">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span class="font-medium">Operaciones</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="open" x-collapse class="pl-4 space-y-1">
                    <a href="{{ route('solicitudes.index') }}" class="block px-4 py-2 text-sm rounded-lg border-l-2 {{ request()->routeIs('solicitudes.*') ? 'border-blue-500 text-white bg-slate-900' : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">Gestión Solicitudes</a>
                    <a href="{{ route('prostock.index') }}" class="block px-4 py-2 text-sm rounded-lg border-l-2 {{ request()->routeIs('prostock.*') ? 'border-blue-500 text-white bg-slate-900' : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">Inventario</a>
                </div>
            </div>
        @endif

        @if(auth()->user()->hasPermission('employee.view'))
            <div x-data="{ openEmp: {{ request()->routeIs('employees.*') || request()->routeIs('planillas.*') || request()->routeIs('horas-extras.*') || request()->routeIs('anticipos.*') ? 'true' : 'false' }} }" class="space-y-1">
                
                <button @click="openEmp = !openEmp"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-400 hover:text-violet-400 hover:bg-slate-900 transition-all duration-300">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="font-medium">Talento Humano</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="openEmp ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openEmp" x-collapse class="pl-4 space-y-1">
                    <a href="{{ route('employees.index') }}" 
                    class="block px-4 py-2 text-sm rounded-lg border-l-2 {{ request()->routeIs('employees.*') ? 'border-violet-500 text-white bg-slate-900' : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">
                    Personal
                    </a>

                    <div class="pt-2">
                        <p class="text-[10px] font-bold text-slate-700 uppercase tracking-widest pl-2 mb-1">Gestión de Planillas</p>
                        
                        <a href="{{ route('planillas.index') }}" 
                        class="block px-4 py-2 text-sm rounded-lg border-l-2 {{ request()->routeIs('planillas.*') ? 'border-violet-500 text-white bg-slate-900' : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">
                        Ver Planillas
                        </a>
                        
                        <div class="mt-2">
                            <p class="text-[9px] text-slate-600 uppercase pl-4 font-semibold mb-0.5">Horas Extras</p>
                            <a href="{{ route('horas-extras.quincena') }}" class="block px-4 py-1.5 text-sm text-slate-500 hover:text-slate-300 pl-6 hover:bg-slate-900/50 rounded-r-lg {{ request()->routeIs('horas-extras.quincena') ? 'text-white' : '' }}">Registrar</a>
                            <a href="{{ route('horas-extras.historial') }}" class="block px-4 py-1.5 text-sm text-slate-500 hover:text-slate-300 pl-6 hover:bg-slate-900/50 rounded-r-lg {{ request()->routeIs('horas-extras.historial') ? 'text-white' : '' }}">Historial</a>
                        </div>
                        
                        <div class="mt-2">
                            <p class="text-[9px] text-slate-600 uppercase pl-4 font-semibold mb-0.5">Anticipos</p>
                            <a href="{{ route('anticipos.quincena') }}" class="block px-4 py-1.5 text-sm text-slate-500 hover:text-slate-300 pl-6 hover:bg-slate-900/50 rounded-r-lg {{ request()->routeIs('anticipos.quincena') ? 'text-white' : '' }}">Registrar</a>
                            <a href="{{ route('anticipos.historial') }}" class="block px-4 py-2 text-sm text-slate-500 hover:text-slate-300 pl-6 hover:bg-slate-900/50 rounded-r-lg {{ request()->routeIs('anticipos.historial') ? 'text-white' : '' }}">Historial</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(auth()->user()->hasAnyRole(['admin','auditor']))
            <a href="{{ route('caja.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('caja.*') ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-emerald-400 hover:bg-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium">Finanzas</span>
            </a>
        @endif
    </nav>
</aside>