@extends($operational ?? false ? 'layouts.operational' : 'layouts.principal')

@section('content')

<div class="max-w-4xl mx-auto pt-20 pb-12 px-4">

    {{-- TARJETA PRINCIPAL --}}
    <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-slate-900/40 p-8 border-b border-slate-700">
            <div class="flex items-center gap-4">

                <span class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-500">
                    <svg class="w-8 h-8"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7h8m-8 4h8m-8 4h5m-9 6h14a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </span>

                <div>
                    <h1 class="text-2xl font-bold text-white">
                        Registrar Salida de Vehículo
                    </h1>

                    <p class="text-slate-400 text-sm mt-1">
                        Registra la salida, conductor y acompañantes de la unidad.
                    </p>
                </div>

            </div>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('vehicle-trips.departure.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-8 space-y-8">

            @csrf

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500 rounded-xl p-4 mb-6">
                    <p class="text-red-400 font-bold mb-2">
                        No se pudo registrar la salida:
                    </p>

                    <ul class="text-red-300 text-sm list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- VEHÍCULO Y CONDUCTOR --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- VEHÍCULO --}}
                <div>
                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Vehículo
                    </label>

                    <select name="vehicle_id"
                            class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                   focus:border-emerald-500 transition-all duration-300"
                            required>

                        <option value="">Seleccionar vehículo</option>

                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}"
                                {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>

                                {{ $vehicle->numero_interno }}
                                - {{ $vehicle->marca }}
                                - {{ strtoupper($vehicle->placa) }}

                            </option>
                        @endforeach

                    </select>

                    @error('vehicle_id')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- CONDUCTOR --}}
                <div>
                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Conductor
                    </label>

                    <select name="driver_id"
                            class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                   focus:border-emerald-500 transition-all duration-300"
                            required>

                        <option value="">Seleccionar conductor</option>

                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}"
                                {{ old('driver_id') == $driver->id ? 'selected' : '' }}>

                                {{ $driver->name }}
                                - {{ $driver->codigo_personal }}

                            </option>
                        @endforeach

                    </select>

                    @error('driver_id')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- FECHA Y KILOMETRAJE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- FECHA/HORA --}}
                <div>
                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Fecha y hora de salida
                    </label>

                    <input type="datetime-local"
                           name="departure_at"
                           value="{{ old('departure_at', now()->format('Y-m-d\TH:i')) }}"
                           class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                  focus:border-emerald-500 transition-all duration-300"
                           required>

                    @error('departure_at')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- KILOMETRAJE --}}
                <div>
                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Kilometraje de salida
                    </label>

                    <input type="number"
                           name="departure_mileage"
                           value="{{ old('departure_mileage') }}"
                           min="0"
                           placeholder="Ej. 52300"
                           class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                  placeholder-slate-500 focus:outline-none focus:ring-2
                                  focus:ring-emerald-500/50 focus:border-emerald-500
                                  transition-all duration-300"
                           required>

                    @error('departure_mileage')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            {{-- EMPLEADO QUE REALIZA EL REGISTRO --}}
            <div>
                <label class="block text-slate-300 font-semibold mb-2 ml-1">
                    Registrado por
                </label>

                <select name="registered_by_employee_id"
                        class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                            focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                            focus:border-emerald-500 transition-all duration-300"
                        required>

                    <option value="">Seleccionar empleado</option>

                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ old('registered_by_employee_id') == $employee->id ? 'selected' : '' }}>

                            {{ $employee->name }}
                            - {{ $employee->codigo_personal }}

                        </option>
                    @endforeach

                </select>

                <p class="text-slate-500 text-xs mt-2 ml-1">
                    Empleado que está realizando este registro.
                </p>

                @error('registered_by_employee_id')
                    <p class="text-red-400 text-xs mt-2 ml-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            </div>


            {{-- COMBUSTIBLE Y DESTINO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- COMBUSTIBLE --}}
                <div>
                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Nivel de combustible
                    </label>

                    <select name="departure_fuel"
                            class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                   focus:border-emerald-500 transition-all duration-300"
                            required>

                        <option value="">Seleccionar nivel</option>

                        <option value="1/4"
                            {{ old('departure_fuel') == '1/4' ? 'selected' : '' }}>
                            1/4
                        </option>

                        <option value="1/2"
                            {{ old('departure_fuel') == '1/2' ? 'selected' : '' }}>
                            1/2
                        </option>

                        <option value="3/4"
                            {{ old('departure_fuel') == '3/4' ? 'selected' : '' }}>
                            3/4
                        </option>

                        <option value="Lleno"
                            {{ old('departure_fuel') == 'Lleno' ? 'selected' : '' }}>
                            Lleno
                        </option>

                    </select>

                    @error('departure_fuel')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- DESTINO --}}
                <div>
                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Destino
                    </label>

                    <input type="text"
                           name="destination"
                           value="{{ old('destination') }}"
                           placeholder="Ej. Zona 10, Guatemala"
                           class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                  placeholder-slate-500 focus:outline-none focus:ring-2
                                  focus:ring-emerald-500/50 focus:border-emerald-500
                                  transition-all duration-300"
                           required>

                    @error('destination')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- ACOMPAÑANTES --}}
            <div>

                <label class="block text-slate-300 font-semibold mb-3 ml-1">
                    Acompañantes
                </label>

                <p class="text-slate-500 text-sm mb-4 ml-1">
                    Selecciona únicamente a los empleados que acompañarán al conductor.
                </p>

                <div class="bg-slate-900/40 border border-slate-700 rounded-2xl p-5">

                    @forelse($employees as $employee)

                        <label class="flex items-center gap-3 py-3 border-b border-slate-700/50 last:border-0 cursor-pointer">

                            <input type="checkbox"
                                   name="passengers[]"
                                   value="{{ $employee->id }}"
                                   {{ in_array($employee->id, old('passengers', [])) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-slate-600 bg-slate-800
                                          text-emerald-600 focus:ring-emerald-500">

                            <div>
                                <p class="text-slate-200 font-medium">
                                    {{ $employee->name }}
                                </p>

                                <p class="text-slate-500 text-xs">
                                    {{ $employee->codigo_personal }}
                                </p>
                            </div>

                        </label>

                    @empty

                        <p class="text-slate-500 text-sm">
                            No hay empleados disponibles.
                        </p>

                    @endforelse

                </div>

                @error('passengers')
                    <p class="text-red-400 text-xs mt-2 ml-1">
                        {{ $message }}
                    </p>
                @enderror

                @error('passengers.*')
                    <p class="text-red-400 text-xs mt-2 ml-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- ============================================================
    INSPECCIÓN PREVIA DEL VEHÍCULO
============================================================ --}}

<div class="space-y-6">

    {{-- ENCABEZADO --}}
    <div class="border-t border-slate-700/50 pt-8">

        <div class="flex items-start gap-4">

            <span class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-500">

                <svg class="w-7 h-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </span>

            <div>

                <h2 class="text-xl font-bold text-white">
                    Inspección previa del vehículo
                </h2>

                <p class="text-slate-400 text-sm mt-1">
                    Completa todos los puntos antes de registrar la salida.
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================
        CATEGORÍAS DEL CHECKLIST
    ========================================================= --}}

    @foreach($checklistItems->groupBy('category') as $category => $items)

        <div class="bg-slate-900/30 border border-slate-700 rounded-2xl overflow-hidden">

            {{-- CATEGORÍA --}}
            <div class="bg-slate-900/60 px-5 py-4 border-b border-slate-700">

                <h3 class="text-emerald-400 font-bold">
                    {{ $category }}
                </h3>

            </div>


            <div class="divide-y divide-slate-700/60">

                @foreach($items as $item)

                    @php
                        $oldResponse = old(
                            "checklist.{$item->id}.response"
                        );
                    @endphp


                    {{-- ==================================================
                        PUNTO DEL CHECKLIST
                    =================================================== --}}

                    <div class="p-5 space-y-4 checklist-item"
                         data-photo-requirement="{{ $item->photo_requirement }}">


                        {{-- NOMBRE DEL PUNTO --}}
                        <div>

                            <div class="flex items-center gap-2">

                                <p class="text-white font-semibold">

                                    {{ $item->sort_order }}.
                                    {{ $item->name }}

                                </p>


                                @if($item->is_critical)

                                    <span class="text-xs bg-red-500/10
                                                 text-red-400 border
                                                 border-red-500/20
                                                 rounded-full px-2 py-1">

                                        Crítico

                                    </span>

                                @endif

                            </div>


                            @if($item->description)

                                <p class="text-slate-500 text-sm mt-1">
                                    {{ $item->description }}
                                </p>

                            @endif

                        </div>


                        {{-- ==================================================
                            RESPUESTA
                        =================================================== --}}

                        @if($item->response_type === 'FUEL')

                            {{-- COMBUSTIBLE --}}
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                                @foreach([
                                    '1/4' => '1/4',
                                    '1/2' => '1/2',
                                    '3/4' => '3/4',
                                    'LLENO' => 'Lleno'
                                ] as $value => $label)

                                    <label class="cursor-pointer">

                                        <input type="radio"
                                               name="checklist[{{ $item->id }}][response]"
                                               value="{{ $value }}"
                                               class="peer sr-only checklist-response"
                                               {{ $oldResponse === $value ? 'checked' : '' }}
                                               required>

                                        <div class="text-center p-3 rounded-xl
                                                    border border-slate-600
                                                    bg-slate-800
                                                    text-slate-300
                                                    peer-checked:border-emerald-500
                                                    peer-checked:bg-emerald-500/10
                                                    peer-checked:text-emerald-400
                                                    transition">

                                            {{ $label }}

                                        </div>

                                    </label>

                                @endforeach

                            </div>

                        @else

                            {{-- ESTADO NORMAL --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                                @foreach([
                                    'OK' => 'OK',
                                    'MAL_FUNCIONAMIENTO' => 'Mal funcionamiento',
                                    'FALLA' => 'Falla'
                                ] as $value => $label)

                                    <label class="cursor-pointer">

                                        <input type="radio"
                                               name="checklist[{{ $item->id }}][response]"
                                               value="{{ $value }}"
                                               class="peer sr-only checklist-response"
                                               {{ $oldResponse === $value ? 'checked' : '' }}
                                               required>

                                        <div class="text-center p-3 rounded-xl
                                                    border border-slate-600
                                                    bg-slate-800
                                                    text-slate-300
                                                    peer-checked:border-emerald-500
                                                    peer-checked:bg-emerald-500/10
                                                    peer-checked:text-emerald-400
                                                    transition">

                                            {{ $label }}

                                        </div>

                                    </label>

                                @endforeach

                            </div>

                        @endif


                        {{-- ==================================================
                            OBSERVACIÓN
                        =================================================== --}}

                        <div>

                            <label class="block text-slate-400 text-sm mb-2">

                                Observación

                                <span class="observation-required-label
                                             text-red-400 hidden">
                                    *
                                </span>

                            </label>


                            <textarea
                                name="checklist[{{ $item->id }}][observation]"
                                rows="2"
                                placeholder="Escribe una observación si es necesario..."
                                class="checklist-observation
                                       w-full bg-slate-900/50
                                       border border-slate-600
                                       rounded-xl p-3 text-white
                                       placeholder-slate-600
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-emerald-500/50
                                       focus:border-emerald-500">{{ old("checklist.{$item->id}.observation") }}</textarea>

                        </div>


                        {{-- ==================================================
                            FOTOGRAFÍA
                        =================================================== --}}

                        <div>

                            <label class="block text-slate-400 text-sm mb-2">

                                Fotografía

                                @if($item->photo_requirement === 'REQUIRED')

                                    <span class="text-red-400">
                                        *
                                    </span>

                                    <span class="text-slate-500">
                                        (obligatoria)
                                    </span>

                                @elseif($item->photo_requirement === 'ON_ISSUE')

                                    <span class="photo-required-star
                                                 text-red-400 hidden">
                                        *
                                    </span>

                                    <span class="photo-requirement-text
                                                 text-slate-500">
                                        (obligatoria si existe problema)
                                    </span>

                                @else

                                    <span class="text-slate-500">
                                        (opcional)
                                    </span>

                                @endif

                            </label>


                            <input type="file"
                                   name="checklist[{{ $item->id }}][photos][]"
                                   accept="image/jpeg,image/png,image/webp"
                                   capture="environment"

                                   @if($item->photo_requirement === 'REQUIRED')
                                       required
                                   @endif

                                   class="checklist-photo
                                          block w-full text-sm
                                          text-slate-400
                                          file:mr-4
                                          file:py-3
                                          file:px-4
                                          file:rounded-xl
                                          file:border-0
                                          file:bg-emerald-600
                                          file:text-white
                                          file:font-semibold
                                          hover:file:bg-emerald-500
                                          cursor-pointer">

                        </div>


                        {{-- ==================================================
                            ERRORES
                        =================================================== --}}

                        @error("checklist.{$item->id}.response")

                            <p class="text-red-400 text-xs">
                                {{ $message }}
                            </p>

                        @enderror


                        @error("checklist.{$item->id}.observation")

                            <p class="text-red-400 text-xs">
                                {{ $message }}
                            </p>

                        @enderror


                        @error("checklist.{$item->id}.photos")

                            <p class="text-red-400 text-xs">
                                {{ $message }}
                            </p>

                        @enderror


                        @error("checklist.{$item->id}.photos.*")

                            <p class="text-red-400 text-xs">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                @endforeach

            </div>

        </div>

    @endforeach

</div>


{{-- ============================================================
    BOTÓN
============================================================ --}}

<div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-700/50">

    <button type="submit"
            class="bg-emerald-600 hover:bg-emerald-500
                   text-white px-8 py-3
                   rounded-xl font-bold
                   shadow-lg shadow-emerald-900/30
                   transition-all
                   hover:-translate-y-0.5
                   active:scale-95">

        Registrar Salida

    </button>

</div>

</form>

</div>


{{-- ============================================================
    REGRESAR
============================================================ --}}

<div class="mt-8 flex justify-start">

    <a href="{{ route('vehiculos.index') }}"
       class="bg-blue-600 hover:bg-blue-500
              text-white px-6 py-3 rounded-xl
              shadow-lg shadow-blue-900/20
              transition flex items-center
              gap-3 font-bold">

        <svg class="w-5 h-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

        </svg>

        Regresar a Vehículos

    </a>

</div>

</div>


{{-- ============================================================
    JAVASCRIPT DEL CHECKLIST
============================================================ --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checklistItems =
        document.querySelectorAll('.checklist-item');


    /**
     * Actualiza las reglas visuales y HTML de un punto
     * dependiendo de la respuesta seleccionada.
     */
    function updateChecklistItem(item) {

        const selectedResponse =
            item.querySelector('.checklist-response:checked');

        const observation =
            item.querySelector('.checklist-observation');

        const photo =
            item.querySelector('.checklist-photo');

        const observationRequiredLabel =
            item.querySelector('.observation-required-label');

        const photoRequiredStar =
            item.querySelector('.photo-required-star');

        const photoRequirementText =
            item.querySelector('.photo-requirement-text');

        const photoRequirement =
            item.dataset.photoRequirement;


        if (!selectedResponse) {

            observation.required = false;

            if (observationRequiredLabel) {
                observationRequiredLabel.classList.add('hidden');
            }

            /*
             * Las fotografías REQUIRED permanecen
             * obligatorias incluso sin respuesta seleccionada.
             */
            photo.required =
                photoRequirement === 'REQUIRED';

            return;
        }


        const response = selectedResponse.value;

        const hasProblem =
            response === 'MAL_FUNCIONAMIENTO'
            || response === 'FALLA';


        // =================================================
        // OBSERVACIÓN
        // =================================================

        if (hasProblem) {

            observation.required = true;

            if (observationRequiredLabel) {
                observationRequiredLabel.classList.remove('hidden');
            }

        } else {

            observation.required = false;

            if (observationRequiredLabel) {
                observationRequiredLabel.classList.add('hidden');
            }

        }


        // =================================================
        // FOTOGRAFÍA
        // =================================================

        if (photoRequirement === 'REQUIRED') {

            /*
             * Siempre obligatoria:
             * aceite, refrigerante, tablero, etc.
             */
            photo.required = true;

        } else if (photoRequirement === 'ON_ISSUE') {

            /*
             * Solo obligatoria cuando existe
             * mal funcionamiento o falla.
             */
            photo.required = hasProblem;

            if (photoRequiredStar) {

                if (hasProblem) {
                    photoRequiredStar.classList.remove('hidden');
                } else {
                    photoRequiredStar.classList.add('hidden');
                }

            }


            if (photoRequirementText) {

                if (hasProblem) {

                    photoRequirementText.textContent =
                        '(obligatoria por problema reportado)';

                    photoRequirementText.classList.remove(
                        'text-slate-500'
                    );

                    photoRequirementText.classList.add(
                        'text-red-400'
                    );

                } else {

                    photoRequirementText.textContent =
                        '(obligatoria si existe problema)';

                    photoRequirementText.classList.remove(
                        'text-red-400'
                    );

                    photoRequirementText.classList.add(
                        'text-slate-500'
                    );

                }

            }

        } else {

            /*
             * OPTIONAL
             */
            photo.required = false;

        }

    }


    // =====================================================
    // CONFIGURAR CADA PUNTO
    // =====================================================

    checklistItems.forEach(function (item) {

        const responses =
            item.querySelectorAll('.checklist-response');


        responses.forEach(function (response) {

            response.addEventListener(
                'change',
                function () {
                    updateChecklistItem(item);
                }
            );

        });


        /*
         * Importante cuando Laravel devuelve el formulario
         * mediante old() después de una validación fallida.
         */
        updateChecklistItem(item);

    });

});
</script>

@endsection