<aside x-cloak 
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    {{-- FIXED: Imprescindible para evitar el doble scroll --}}
    class="fixed left-0 top-16 z-40 w-64 bg-slate-950 border-r border-slate-800 h-[calc(100vh-4rem)] flex flex-col shadow-2xl">

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-sidebar-scroll">
        
        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
           {{ request()->routeIs('dashboard') ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-emerald-400 hover:bg-slate-900' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        {{-- GESTIÓN COMERCIAL --}}
        @if(auth()->user()->hasAnyRole(['admin','ventas']))

            <div 
                x-data="{ openComercial: false }"
                class="space-y-1"
            >

                <button 
                    @click="openComercial = !openComercial"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl 
                    text-slate-400 hover:text-cyan-400 hover:bg-slate-900 
                    transition-all duration-300"
                >

                    <span class="flex items-center gap-3">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m12 0H5m12 0h-2m-8 0H5m4-10a4 4 0 110-8 4 4 0 010 8zm8 4h.01"
                            />
                        </svg>

                        <span class="font-medium">
                            Gestión Comercial
                        </span>

                    </span>

                    <svg 
                        class="w-4 h-4 transition-transform duration-300"
                        :class="openComercial ? 'rotate-180' : ''"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >

                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />

                    </svg>

                </button>

                <div 
                    x-show="openComercial" 
                    x-collapse 
                    class="pl-4 space-y-1"
                >

                    {{-- CLIENTES --}}
                    <a href="{{ route('clientes.index') }}"
                        class="block px-4 py-2 text-sm rounded-lg border-l-2
                        {{ request()->routeIs('clientes.*')
                        ? 'border-cyan-500 text-white bg-slate-900'
                        : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">

                        Clientes

                    </a>

                    {{-- COTIZACIONES --}}
                    <a href="{{ route('cotizaciones.index') }}"
                    class="block px-4 py-2 text-sm rounded-lg border-l-2
                    {{ request()->routeIs('cotizacions.*')
                        ? 'border-cyan-500 text-white bg-slate-900'
                        : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">

                        Cotizaciones

                    </a>

                </div>

            </div>

        @endif
        
        {{-- OPERACIONES --}}
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

        {{-- TALENTO HUMANO --}}
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
                    <a href="{{ route('employees.index') }}" class="block px-4 py-2 text-sm rounded-lg border-l-2 {{ request()->routeIs('employees.*') ? 'border-violet-500 text-white bg-slate-900' : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">Personal</a>
                    <div class="pt-2">
                        <p class="text-[10px] font-bold text-slate-700 uppercase tracking-widest pl-2 mb-1">Planillas</p>
                        <a href="{{ route('planillas.index') }}" class="block px-4 py-2 text-sm rounded-lg border-l-2 {{ request()->routeIs('planillas.*') ? 'border-violet-500 text-white bg-slate-900' : 'border-slate-800 text-slate-500 hover:text-slate-300' }}">Ver Planillas</a>
                       
                        {{-- BONIFICACIÓN POR PRODUCTIVIDAD DROPDOWN --}}
                        <div x-data="{ openHE: {{ request()->routeIs('horas-extras.*') ? 'true' : 'false' }} }">

                            <button @click="openHE = !openHE"
                                class="w-full flex items-center justify-between px-4 py-1.5 text-sm pl-6 rounded-r-lg
                                text-slate-500 hover:text-slate-300 hover:bg-slate-900/50 transition">

                                <span>Boni-Productiv</span>

                                <svg class="w-3 h-3 transition-transform duration-300"
                                    :class="openHE ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="openHE" x-collapse class="ml-4 mt-1 space-y-1">
                                <a href="{{ route('horas-extras.quincena') }}"
                                class="block px-4 py-1 text-xs rounded-lg
                                {{ request()->routeIs('horas-extras.quincena') ? 'text-white bg-slate-900' : 'text-slate-500 hover:text-slate-300' }}">
                                    Quincena
                                </a>

                                <a href="{{ route('horas-extras.historial') }}"
                                class="block px-4 py-1 text-xs rounded-lg
                                {{ request()->routeIs('horas-extras.historial') ? 'text-white bg-slate-900' : 'text-slate-500 hover:text-slate-300' }}">
                                    Historial
                                </a>
                            </div>
                        </div>


                        {{-- ANTICIPOS DROPDOWN --}}
                        <div x-data="{ openAnt: {{ request()->routeIs('anticipos.*') ? 'true' : 'false' }} }">

                            <button @click="openAnt = !openAnt"
                                class="w-full flex items-center justify-between px-4 py-1.5 text-sm pl-6 rounded-r-lg
                                text-slate-500 hover:text-slate-300 hover:bg-slate-900/50 transition">

                                <span>Anticipos</span>

                                <svg class="w-3 h-3 transition-transform duration-300"
                                    :class="openAnt ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="openAnt" x-collapse class="ml-4 mt-1 space-y-1">
                                <a href="{{ route('anticipos.quincena') }}"
                                class="block px-4 py-1 text-xs rounded-lg
                                {{ request()->routeIs('anticipos.quincena') ? 'text-white bg-slate-900' : 'text-slate-500 hover:text-slate-300' }}">
                                    Quincena
                                </a>

                                <a href="{{ route('anticipos.historial') }}"
                                class="block px-4 py-1 text-xs rounded-lg
                                {{ request()->routeIs('anticipos.historial') ? 'text-white bg-slate-900' : 'text-slate-500 hover:text-slate-300' }}">
                                    Historial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- FINANZAS --}}
        @if(auth()->user()->hasAnyRole(['admin','auditor']))
            <a href="{{ route('caja.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('caja.*') ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-emerald-400 hover:bg-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium">Finanzas</span>
            </a>
        @endif

        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('empresa.edit') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
               {{ request()->routeIs('empresa.edit') 
                   ? 'bg-indigo-950/40 text-indigo-400 border border-indigo-500/20 font-bold' 
                   : 'text-slate-400 hover:text-indigo-400 hover:bg-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                </svg>
                <span class="font-medium">Configuración</span>
            </a>
        @endif
    </nav>
</aside>