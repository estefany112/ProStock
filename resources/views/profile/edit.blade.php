@extends('layouts.principal')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    {{-- Resumen Usuario --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8">
    <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        {{-- Lado izquierdo --}}
        <div class="flex items-center gap-5">

            {{-- Avatar Profesional --}}
            <div class="relative group">

                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}"
                         class="w-24 h-24 rounded-full object-cover
                                border-4 border-white shadow-lg
                                ring-2 ring-slate-200
                                transition duration-300
                                group-hover:ring-blue-500">
                @else
                    <div class="w-24 h-24 rounded-full
                                bg-gradient-to-br from-slate-700 to-slate-900
                                flex items-center justify-center
                                text-white text-3xl font-semibold
                                shadow-lg ring-2 ring-slate-200
                                transition duration-300
                                group-hover:ring-blue-500">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                @endif

                {{-- Badge Activo --}}
                <span class="absolute bottom-2 right-2
                             w-5 h-5 bg-green-500
                             border-2 border-white
                             rounded-full shadow">
                </span>

            </div>

            {{-- Datos --}}
            <div class="space-y-1">
                <h3 class="text-xl font-semibold text-slate-800">
                    {{ auth()->user()->name }}
                </h3>

                <p class="text-sm text-slate-500">
                    {{ auth()->user()->email }}
                </p>

                <div class="flex flex-wrap gap-4 mt-2 text-sm text-slate-600">
                    <span>
                        <span class="font-medium">Rol:</span>
                        {{ auth()->user()->roles->first()->name ?? 'Usuario' }}
                    </span>

                    @if(auth()->user()->phone)
                        <span>
                            <span class="font-medium">Tel:</span>
                            {{ auth()->user()->phone }}
                        </span>
                    @endif

                    <span>
                        <span class="font-medium">Miembro desde:</span>
                        {{ auth()->user()->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>

        </div>

        {{-- Estado lado derecho --}}
        <div>
            <span class="inline-flex items-center gap-2
                         bg-green-50 text-green-700
                         px-4 py-2 rounded-full
                         text-sm font-medium border border-green-200">

                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                Cuenta Activa

            </span>
        </div>

    </div>
</div>

    <div class="space-y-6">

        {{-- Información Perfil --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Seguridad --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            @include('profile.partials.update-password-form')
        </div>

        {{-- Zona de Riesgo --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-red-100">
            @include('profile.partials.delete-user-form')
        </div>

    </div>

</div>
@endsection