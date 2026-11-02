@extends('layouts.principal')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- ENCABEZADO --}}
    <div class="mb-6">

        <a href="{{ route('employees.index') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4">
            ← Regresar a empleados
        </a>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Licencia de conducir
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ $employee->name }}
                </p>
            </div>


            {{-- ESTADO --}}
            @if($license)

                @if(\Carbon\Carbon::parse($license->expires_at)->isPast())

                    <span class="inline-flex self-start items-center
                                 px-3 py-1.5 rounded-full
                                 text-sm font-semibold
                                 bg-red-100 text-red-700">
                        Vencida
                    </span>

                @else

                    <span class="inline-flex self-start items-center
                                 px-3 py-1.5 rounded-full
                                 text-sm font-semibold
                                 bg-green-100 text-green-700">
                        Vigente
                    </span>

                @endif

            @else

                <span class="inline-flex self-start items-center
                             px-3 py-1.5 rounded-full
                             text-sm font-semibold
                             bg-gray-100 text-gray-600">
                    Sin licencia
                </span>

            @endif

        </div>

    </div>


    {{-- ERRORES --}}
    @if ($errors->any())

        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">

            <p class="font-semibold text-red-700 mb-2">
                Revisa la información ingresada:
            </p>

            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORMULARIO --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-5 sm:px-6 py-5 border-b border-gray-200">

            <h2 class="font-semibold text-gray-900">

                @if($license)
                    Información de la licencia
                @else
                    Registrar licencia
                @endif

            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Esta información determinará si el empleado puede ser seleccionado como conductor.
            </p>

        </div>


        <form method="POST"
              action="{{ $license
                    ? route('employees.license.update', [$employee, $license])
                    : route('employees.license.store', $employee) }}">

            @csrf

            @if($license)
                @method('PUT')
            @endif


            <div class="p-5 sm:p-6 space-y-6">


                {{-- NÚMERO DE LICENCIA --}}
                <div>

                    <label for="license_number"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Número de licencia
                    </label>

                    <input
                        type="text"
                        id="license_number"
                        name="license_number"
                        value="{{ old('license_number', $license?->license_number) }}"
                        required
                        maxlength="50"
                        autocomplete="off"
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500"
                        placeholder="Ej. TEST-001">

                    @error('license_number')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- TIPO DE LICENCIA --}}
                <div>

                    <label for="license_type"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipo de licencia
                    </label>

                    <select
                        id="license_type"
                        name="license_type"
                        required
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                        <option value="">
                            Seleccione el tipo de licencia
                        </option>

                        @foreach(['A', 'B', 'C', 'M', 'E'] as $type)

                            <option value="{{ $type }}"
                                @selected(old('license_type', $license?->license_type) === $type)>

                                Tipo {{ $type }}

                            </option>

                        @endforeach

                    </select>

                    @error('license_type')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- FECHA DE VENCIMIENTO --}}
                <div>

                    <label for="expires_at"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha de vencimiento
                    </label>

                    <input
                        type="date"
                        id="expires_at"
                        name="expires_at"
                        value="{{ old(
                            'expires_at',
                            $license?->expires_at
                                ? \Carbon\Carbon::parse($license->expires_at)->format('Y-m-d')
                                : ''
                        ) }}"
                        required
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                    @error('expires_at')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- INFORMACIÓN DE ESTADO --}}
                @if($license)

                    <div class="rounded-xl
                                {{ \Carbon\Carbon::parse($license->expires_at)->isPast()
                                    ? 'bg-red-50 border-red-200'
                                    : 'bg-green-50 border-green-200' }}
                                border p-4">

                        @if(\Carbon\Carbon::parse($license->expires_at)->isPast())

                            <p class="font-semibold text-red-700">
                                Licencia vencida
                            </p>

                            <p class="text-sm text-red-600 mt-1">
                                Este empleado no debe aparecer como conductor
                                hasta que se actualice la fecha de vencimiento.
                            </p>

                        @else

                            <p class="font-semibold text-green-700">
                                Licencia vigente
                            </p>

                            <p class="text-sm text-green-600 mt-1">
                                El empleado puede ser seleccionado como conductor
                                mientras su licencia permanezca vigente.
                            </p>

                        @endif

                    </div>

                @endif


            </div>


            {{-- BOTONES --}}
            <div class="px-5 sm:px-6 py-4
                        bg-gray-50 border-t border-gray-200
                        flex flex-col-reverse sm:flex-row
                        sm:justify-end gap-3">

                <a href="{{ route('employees.index') }}"
                   class="w-full sm:w-auto
                          inline-flex justify-center items-center
                          px-5 py-2.5
                          rounded-xl
                          border border-gray-300
                          text-gray-700
                          font-semibold
                          hover:bg-gray-100
                          transition">

                    Cancelar

                </a>


                <button
                    type="submit"
                    class="w-full sm:w-auto
                           inline-flex justify-center items-center
                           px-5 py-2.5
                           rounded-xl
                           bg-blue-600 hover:bg-blue-700
                           text-white
                           font-semibold
                           shadow-sm
                           transition">

                    @if($license)
                        Actualizar licencia
                    @else
                        Registrar licencia
                    @endif

                </button>

            </div>

        </form>

    </div>

</div>


@if(session('success'))

<script>
    document.addEventListener('DOMContentLoaded', function () {

        Swal.fire({
            icon: 'success',
            title: '¡Correcto!',
            text: @json(session('success')),
            confirmButtonText: 'Aceptar'
        });

    });
</script>

@endif

@endsection