<form method="GET" action="{{ $action }}" class="flex items-center w-full gap-3">
    {{-- Input de Búsqueda --}}
    <div class="relative flex-1">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            x-model.debounce.400ms="query"
            placeholder="{{ $placeholder }}"
            {{-- Clases mejoradas: fondo transparente, sin bordes, texto blanco --}}
            class="w-full bg-transparent border-none focus:ring-0 text-white placeholder-slate-500 text-lg font-medium tracking-tight py-2"
        >
    </div>

    {{-- Botones de Acción --}}
    <div class="flex items-center gap-2">
        @if(request('search'))
            <a href="{{ $action }}" 
               class="p-2 text-slate-500 hover:text-rose-400 transition-colors"
               title="Limpiar búsqueda">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            <div class="h-6 w-[1px] bg-white/10 mx-1"></div>
        @endif

        <button type="submit" 
                class="bg-blue-600/80 hover:bg-blue-500 text-white px-6 py-2 rounded-2xl font-bold transition-all shadow-lg shadow-blue-900/20 active:scale-95">
            Filtrar
        </button>
    </div>
</form>