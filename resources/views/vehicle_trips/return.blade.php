@extends('layouts.operational')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | MODO DEL FORMULARIO
    |--------------------------------------------------------------------------
    | true  = módulo operacional
    | false = módulo administrativo / auth
    */
    $isOperational = isset($operational) && $operational;
@endphp

<div class="max-w-4xl mx-auto pt-20 pb-12 px-4">

    <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-slate-900/40 p-8 border-b border-slate-700">

            <div class="flex items-center gap-4">

                <span class="p-3 bg-blue-500/10 rounded-2xl text-blue-500">

                    <svg class="w-8 h-8"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 14l6-6m0 0H9m6 0v6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />

                    </svg>

                </span>

                <div>

                    <h1 class="text-2xl font-bold text-white">
                        Registrar Retorno de Vehículo
                    </h1>

                    <p class="text-slate-400 text-sm mt-1">

                        @if($isOperational)
                            Registro operacional del retorno de la unidad.
                        @else
                            Completa los datos del retorno de la unidad.
                        @endif

                    </p>

                </div>

            </div>

        </div>


        {{-- INFORMACIÓN DE LA SALIDA --}}
        <div class="p-8 border-b border-slate-700">

            <h2 class="text-lg font-bold text-white mb-5">
                Información de la salida
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- VEHÍCULO --}}
                <div class="bg-slate-900/40 border border-slate-700 rounded-xl p-4">

                    <p class="text-slate-500 text-xs uppercase font-semibold">
                        Vehículo
                    </p>

                    <p class="text-white font-semibold mt-1">
                        {{ $trip->vehicle->numero_interno }}
                        - {{ $trip->vehicle->marca }}
                    </p>

                    <p class="text-slate-400 text-sm">
                        {{ strtoupper($trip->vehicle->placa) }}
                    </p>

                </div>


                {{-- CONDUCTOR --}}
                <div class="bg-slate-900/40 border border-slate-700 rounded-xl p-4">

                    <p class="text-slate-500 text-xs uppercase font-semibold">
                        Conductor
                    </p>

                    <p class="text-white font-semibold mt-1">
                        {{ $trip->driver->name }}
                    </p>

                    <p class="text-slate-400 text-sm">
                        {{ $trip->driver->codigo_personal }}
                    </p>

                </div>


                {{-- FECHA SALIDA --}}
                <div class="bg-slate-900/40 border border-slate-700 rounded-xl p-4">

                    <p class="text-slate-500 text-xs uppercase font-semibold">
                        Fecha y hora de salida
                    </p>

                    <p class="text-white font-semibold mt-1">
                        {{ $trip->departure_at->format('d/m/Y H:i') }}
                    </p>

                </div>


                {{-- KILOMETRAJE SALIDA --}}
                <div class="bg-slate-900/40 border border-slate-700 rounded-xl p-4">

                    <p class="text-slate-500 text-xs uppercase font-semibold">
                        Kilometraje de salida
                    </p>

                    <p class="text-white font-semibold mt-1">
                        {{ number_format($trip->departure_mileage) }} km
                    </p>

                </div>


                {{-- DESTINO --}}
                <div class="bg-slate-900/40 border border-slate-700 rounded-xl p-4 md:col-span-2">

                    <p class="text-slate-500 text-xs uppercase font-semibold">
                        Destino
                    </p>

                    <p class="text-white font-semibold mt-1">
                        {{ $trip->destination }}
                    </p>

                </div>

            </div>

        </div>


        {{-- FORMULARIO DE RETORNO --}}
        <form method="POST"
              action="{{ $isOperational
                    ? route('vehicle-trips.operational.return.store', $trip)
                    : route('vehicle-trips.return.store', $trip) }}">

            @csrf
            @method('PUT')

            {{--
                Este campo permite que storeReturn() también conozca
                de qué módulo provino la solicitud.
            --}}
            @if($isOperational)
                <input type="hidden" name="operational" value="1">
            @endif


            <div class="p-8 space-y-6">

                {{-- FECHA Y KILOMETRAJE --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- FECHA RETORNO --}}
                    <div>

                        <label class="block text-slate-300 font-semibold mb-2 ml-1">
                            Fecha y hora de retorno
                        </label>

                        <input type="datetime-local"
                               name="return_at"
                               value="{{ old('return_at', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                      focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                      focus:border-emerald-500 transition-all duration-300"
                               required>

                        @error('return_at')
                            <p class="text-red-400 text-xs mt-2 ml-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- KILOMETRAJE RETORNO --}}
                    <div>

                        <label class="block text-slate-300 font-semibold mb-2 ml-1">
                            Kilometraje de retorno
                        </label>

                        <input type="number"
                               name="return_mileage"
                               value="{{ old('return_mileage') }}"
                               min="{{ $trip->departure_mileage }}"
                               placeholder="Mínimo {{ $trip->departure_mileage }} km"
                               class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                      placeholder-slate-500 focus:outline-none focus:ring-2
                                      focus:ring-emerald-500/50 focus:border-emerald-500
                                      transition-all duration-300"
                               required>

                        <p class="text-slate-500 text-xs mt-2 ml-1">
                            Debe ser igual o mayor a
                            {{ number_format($trip->departure_mileage) }} km.
                        </p>

                        @error('return_mileage')
                            <p class="text-red-400 text-xs mt-2 ml-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- EMPLEADO QUE REGISTRA --}}
                <div>

                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Retorno registrado por
                    </label>

                    <select name="returned_by_employee_id"
                            class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                   focus:border-emerald-500 transition-all duration-300"
                            required>

                        <option value="">Seleccionar empleado</option>

                        @foreach($employees as $employee)

                            <option value="{{ $employee->id }}"
                                {{ old('returned_by_employee_id') == $employee->id ? 'selected' : '' }}>

                                {{ $employee->name }}
                                - {{ $employee->codigo_personal }}

                            </option>

                        @endforeach

                    </select>

                    <p class="text-slate-500 text-xs mt-2 ml-1">
                        Empleado que está realizando el registro del retorno.
                    </p>

                    @error('returned_by_employee_id')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- COMBUSTIBLE --}}
                <div>

                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Nivel de combustible al retornar
                    </label>

                    <select name="return_fuel"
                            class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                                   focus:border-emerald-500 transition-all duration-300"
                            required>

                        <option value="">Seleccionar nivel</option>

                        <option value="1/4"
                            {{ old('return_fuel') == '1/4' ? 'selected' : '' }}>
                            1/4
                        </option>

                        <option value="1/2"
                            {{ old('return_fuel') == '1/2' ? 'selected' : '' }}>
                            1/2
                        </option>

                        <option value="3/4"
                            {{ old('return_fuel') == '3/4' ? 'selected' : '' }}>
                            3/4
                        </option>

                        <option value="Lleno"
                            {{ old('return_fuel') == 'Lleno' ? 'selected' : '' }}>
                            Lleno
                        </option>

                    </select>

                    @error('return_fuel')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- OBSERVACIONES --}}
                <div>

                    <label class="block text-slate-300 font-semibold mb-2 ml-1">
                        Observaciones del retorno
                    </label>

                    <textarea name="return_observations"
                              rows="4"
                              maxlength="2000"
                              placeholder="Escribe cualquier novedad u observación del vehículo al retornar..."
                              class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                     placeholder-slate-500 focus:outline-none focus:ring-2
                                     focus:ring-emerald-500/50 focus:border-emerald-500
                                     transition-all duration-300 resize-none">{{ old('return_observations') }}</textarea>

                    @error('return_observations')
                        <p class="text-red-400 text-xs mt-2 ml-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ACCIONES --}}
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-700/50">

                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-3
                                   rounded-xl font-bold shadow-lg shadow-emerald-900/30
                                   transition-all hover:-translate-y-0.5 active:scale-95">

                        Registrar Retorno

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- REGRESAR --}}
    <div class="mt-8 flex justify-start">

        <a href="{{ $isOperational
                ? route('vehicle-trips.operational.index')
                : route('vehiculos.index') }}"
           class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl
                  shadow-lg shadow-blue-900/20 transition flex items-center gap-3 font-bold">

            <svg class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

            </svg>

            {{ $isOperational
                ? 'Regresar a Control de Viajes'
                : 'Regresar a Vehículos' }}

        </a>

    </div>

</div>

@endsection