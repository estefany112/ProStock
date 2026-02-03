<form method="GET" action="{{ $action }}" class="mb-4 flex gap-2">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="{{ $placeholder }}"
        class="border rounded-lg px-3 py-2 w-64"
    >

    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        Buscar
    </button>

    @if(request('search'))
        <a href="{{ $action }}" class="px-4 py-2 border rounded-lg">
            Limpiar
        </a>
    @endif
</form>