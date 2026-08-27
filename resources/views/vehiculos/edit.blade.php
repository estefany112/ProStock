@extends('layouts.principal')

@section('content')

{{-- pt-20 para asegurar la gran distancia solicitada con la barra de navegación --}}
<div class="max-w-3xl mx-auto pt-20 pb-12 px-4">
    
    {{-- TARJETA DE FORMULARIO --}}
    <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">
        
        {{-- HEADER DEL FORMULARIO --}}
        <div class="bg-slate-900/40 p-8 border-b border-slate-700">
            <div class="flex items-center gap-4">
                <span class="p-3 bg-amber-500/10 rounded-2xl text-amber-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-2xl font-bold text-white">Editar Vehículo</h1>
                    <p class="text-slate-400 text-sm mt-1">Actualiza la información de la unidad en el parque automotor de PROSERVE.</p>
                </div>
            </div>
        </div>

        {{-- CUERPO DEL FORMULARIO --}}
        <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- IDENTIFICACIÓN INTERNA --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- NÚMERO INTERNO --}}
                    <div>
                        <label class="block text-slate-300 font-semibold mb-2 ml-1">
                            Número interno
                        </label>

                        <input type="text"
                            name="numero_interno"
                            value="{{ old('numero_interno', $vehiculo->numero_interno) }}"
                            placeholder="Ej. VH-01 o M-01"
                            class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white placeholder-slate-500 uppercase
                                    focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                    transition-all duration-300">

                                @error('numero_interno')
                                    <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TIPO DE VEHÍCULO --}}
                            <div>
                                <label class="block text-slate-300 font-semibold mb-2 ml-1">
                                    Tipo de vehículo
                                </label>

                                <select name="tipo"
                                        class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white
                                            focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                            transition-all duration-300">

                                    <option value="" class="bg-slate-800">
                                        Seleccionar tipo
                                    </option>

                                    <option value="pickup"
                                        class="bg-slate-800"
                                        {{ old('tipo', $vehiculo->tipo) === 'pickup' ? 'selected' : '' }}>
                                        Pickup
                                    </option>

                                    <option value="carro"
                                        class="bg-slate-800"
                                        {{ old('tipo', $vehiculo->tipo) === 'carro' ? 'selected' : '' }}>
                                        Carro
                                    </option>

                                    <option value="camion"
                                        class="bg-slate-800"
                                        {{ old('tipo', $vehiculo->tipo) === 'camion' ? 'selected' : '' }}>
                                        Camión
                                    </option>

                                    <option value="moto"
                                        class="bg-slate-800"
                                        {{ old('tipo', $vehiculo->tipo) === 'moto' ? 'selected' : '' }}>
                                        Moto
                                    </option>

                                    <option value="trimoto"
                                        class="bg-slate-800"
                                        {{ old('tipo', $vehiculo->tipo) === 'trimoto' ? 'selected' : '' }}>
                                        Trimoto
                                    </option>

                                    <option value="otro"
                                        class="bg-slate-800"
                                        {{ old('tipo', $vehiculo->tipo) === 'otro' ? 'selected' : '' }}>
                                        Otro
                                    </option>

                                </select>

                                @error('tipo')
                                    <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                                {{-- PLACA --}}
                                <div>
                                    <label class="block text-slate-300 font-semibold mb-2 ml-1">Placa</label>
                                    <input type="text"
                                        name="placa"
                                        value="{{ old('placa', $vehiculo->placa) }}"
                                        placeholder="Ej. P-123XYZ"
                                        class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white placeholder-slate-500 uppercase
                                                focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                                transition-all duration-300"
                                        required
                                        autofocus>
                                    @error('placa')
                                        <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- MARCA --}}
                                <div>
                                    <label class="block text-slate-300 font-semibold mb-2 ml-1">Marca</label>
                                    <input type="text"
                                        name="marca"
                                        value="{{ old('marca', $vehiculo->marca) }}"
                                        placeholder="Ej. Toyota, Nissan..."
                                        class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white placeholder-slate-500
                                                focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                                transition-all duration-300"
                                        required>
                                    @error('marca')
                                        <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                {{-- AÑO --}}
                                <div class="md:col-span-1">
                                    <label class="block text-slate-300 font-semibold mb-2 ml-1">Año</label>
                                    <input type="number"
                                        name="anio"
                                        value="{{ old('anio', $vehiculo->anio) }}"
                                        placeholder="Ej. 2024"
                                        class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white placeholder-slate-500
                                                focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                                transition-all duration-300"
                                        required>
                                    @error('anio')
                                        <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- COLOR --}}
                                <div class="md:col-span-1">
                                    <label class="block text-slate-300 font-semibold mb-2 ml-1">Color</label>
                                    <input type="text"
                                        name="color"
                                        value="{{ old('color', $vehiculo->color) }}"
                                        placeholder="Ej. Blanco, Gris..."
                                        class="w-full bg-slate-900/50 border border-slate-600 rounded-xl p-4 text-white placeholder-slate-500
                                                focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500
                                                transition-all duration-300"
                                        required>
                                    @error('color')
                                        <p class="text-red-400 text-xs mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- ACCIONES INTERNAS --}}
                            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-700/50">
                                <button type="submit"
                                        class="bg-amber-600 hover:bg-amber-500 text-white px-8 py-3 rounded-xl 
                                            font-bold shadow-lg shadow-amber-900/30 transition-all 
                                            hover:-translate-y-0.5 active:scale-95">
                                    Actualizar Vehículo
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- BOTÓN REGRESAR --}}
                    <div class="mt-8 flex justify-start">
                        <a href="{{ route('vehiculos.index') }}"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-900/20 transition flex items-center gap-3 font-bold">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Regresar al listado
                        </a>
                    </div>
                </div>

@endsection