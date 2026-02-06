<x-app-layout>

    <div class="py-8 max-w-6xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border">

            {{-- HEADER DE LA VISTA --}}
            <div class="mb-6">

                {{-- FILA SUPERIOR: TÍTULO + MENÚ --}}
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        💵 CAJA CHICA
                    </h1>

                    <a href="{{ route('caja.history') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                              hover:bg-blue-700 transition whitespace-nowrap">
                        💵 Historial de Caja Chica
                    </a>

                </div>

                {{-- DESCRIPCIÓN --}}
                <p class="text-sm text-gray-500 mt-1">
                    Control de caja chica – PROSERVE
                </p>

                {{-- ACCIÓN PRINCIPAL: ABRIR CAJA --}}
                @if(!$cash && auth()->user()->hasPermission('caja.open'))
                    <div class="mt-4">
                        <form action="{{ url('/caja/open') }}" method="POST" class="flex gap-2 items-center">
                            @csrf
                            <input
                                type="number"
                                name="amount"
                                step="0.01"
                                min="1"
                                required
                                placeholder="Monto inicial"
                                class="border rounded-lg px-3 py-2 w-40"
                            >
                            <button
                                class="bg-green-600 text-white px-4 py-2 rounded-lg shadow
                                       hover:bg-green-700 transition">
                                ➕ Abrir Caja
                            </button>
                        </form>
                    </div>
                @endif

            </div>

            {{-- MENSAJES --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- CUANDO HAY CAJA ABIERTA --}}
            @if($cash)

                {{-- RESUMEN --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Saldo actual</p>
                        <p class="text-2xl font-bold text-green-600">
                            Q {{ number_format($cash->current_balance, 2) }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Monto inicial</p>
                        <p class="text-xl font-semibold">
                            Q {{ number_format($cash->initial_amount, 2) }}
                        </p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Estado</p>
                        <span class="inline-block mt-1 px-3 py-1 text-sm rounded
                                     bg-green-100 text-green-700">
                            Caja Abierta
                        </span>
                    </div>

                    <div class="border rounded-lg p-4">
                        @if($cash)
                        <p class="text-sm text-gray-500">
                            Semana:
                            {{ optional($cash->period_start)->format('d/m/Y') ?? '—' }}
                            –
                            {{ optional($cash->period_end)->format('d/m/Y') ?? '—' }}
                        </p>
                        @else
                            <span class="text-red-500">No hay caja chica activa</span>
                        @endif
                    </div>

                </div>

                {{-- FORMULARIO DE MOVIMIENTO --}}
                @if(auth()->user()->hasPermission('caja.move'))
                    <div class="border rounded-lg p-4 mb-6">

                        <h2 class="text-lg font-semibold mb-4">
                            ➕ Registrar movimiento
                        </h2>

                        <form action="{{ url('/caja/movement') }}" method="POST"
                              class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            @csrf

                            <select name="movement_category" required class="border rounded-lg px-3 py-2">
                                <option value="">Tipo</option>
                                <option value="income">Ingreso</option>
                                <option value="expense">Egreso</option>
                                <option value="advance">Anticipo</option>
                            </select>

                            <input type="hidden" name="type" value="expense">

                            <input
                                type="number"
                                name="amount"
                                step="0.01"
                                min="1"
                                required
                                placeholder="Monto"
                                class="border rounded-lg px-3 py-2"
                            >

                            <input
                                type="text"
                                name="concept"
                                required
                                placeholder="Concepto"
                                class="border rounded-lg px-3 py-2 md:col-span-2"
                            >

                            <input
                                type="text"
                                name="responsible"
                                placeholder="Responsable (a quien se entrega el efectivo)"
                                class="border rounded-lg px-3 py-2 md:col-span-2"
                            />

                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow
                                       hover:bg-blue-700 transition md:col-span-5">
                                Guardar movimiento
                            </button>

                        </form>
                    </div>
                @endif

                {{-- HISTORIAL --}}
                <div class="overflow-x-auto text-center">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2">Fecha</th>
                                <th class="p-2">Tipo</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Responsable</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cash->movements()->latest()->get() as $mov)
                                <tr class="border-t">
                                    <td class="p-2">
                                        {{ $mov->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        @switch($mov->movement_category)
                                            @case('income')
                                                <span class="text-green-600 font-semibold">Ingreso</span>
                                                @break
                                            @case('expense')
                                                <span class="text-red-600 font-semibold">Egreso</span>
                                                @break
                                            @case('advance')
                                                <span class="text-blue-600 font-semibold">Anticipo</span>
                                                @break
                                        @endswitch
                                        @if($mov->movement_category === 'advance')
                                            <div class="text-xs text-gray-500">
                                                {{ $mov->status === 'pending' ? 'Pendiente' : 'Liquidado' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $mov->concept }}</td>
                                    <td>
                                        Q {{ number_format($mov->amount, 2) }}
                                    </td>
                                    <td>
                                        {{ $mov->responsible ?? '—' }}
                                    </td>
                                    <td>
                                        {{ $mov->user->name }}
                                    </td>
                                </tr>
                            @endforeach

                            @if($cash->movements()->count() === 0)
                                <tr>
                                    <td colspan="6" class="p-4 text-gray-600">
                                        No hay movimientos registrados.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            {{-- BOTÓN CERRAR SEMANA (solo admin) --}}
            @if(auth()->user()->hasPermission('caja.close'))
                <div class="mt-4">
                    <form id="formCerrarCaja" action="{{ route('caja.close') }}" method="POST">
                        @csrf
                        <button type="button"
                            onclick="confirmarCierre()"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg shadow
                                hover:bg-red-700 transition">
                            🔒 Cerrar Semana
                        </button>
                    </form>
                </div>
            @endif

            {{-- CUANDO NO HAY CAJA --}}
            @else
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-lg">
                    No hay una caja chica abierta actualmente.
                </div>
            @endif

        </div>
    </div>

<script>
    function confirmarCierre() {
        Swal.fire({
            title: '¿Cerrar caja semanal?',
            text: 'No podrás registrar más movimientos en esta semana.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formCerrarCaja').submit();
            }
        });
    }
</script>

</x-app-layout>