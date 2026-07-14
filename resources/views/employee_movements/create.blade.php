@extends('layouts.principal')

@section('content')
<div class="py-10 max-w-2xl mx-auto px-4 sm:px-6">

    {{-- HEADER DEL FORMULARIO --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">Registrar nuevo movimiento</h2>
        <p class="text-slate-500 text-sm mt-1">
            Estás registrando un cambio para: <span class="font-semibold text-indigo-600">{{ $employee->name }}</span>
        </p>
    </div>

    {{-- FORMULARIO EN TARJETA --}}
    <form method="POST" action="{{ route('employee.movements.store', $employee) }}" class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
        @csrf

        <div class="space-y-6">
            
            {{-- TIPO DE MOVIMIENTO --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tipo de movimiento</label>
                <select name="type" class="w-full rounded-lg border-slate-300 text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="RENUNCIA">Renuncia</option>
                    <option value="DESPIDO">Despido</option>
                    <option value="CAMBIO_PUESTO">Cambio de puesto</option>
                    <option value="AUMENTO_SALARIO">Aumento salarial</option>
                </select>
            </div>

            {{-- FECHA --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha del evento</label>
                <input type="date" 
                       name="date" 
                       value="{{ date('Y-m-d') }}"
                       class="w-full rounded-lg border-slate-300 text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" 
                       required>
            </div>

            {{-- MOTIVO --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Motivo o detalles</label>
                <textarea name="reason" 
                          rows="4"
                          class="w-full rounded-lg border-slate-300 text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                          placeholder="Describe brevemente el motivo..."></textarea>
            </div>

            {{-- BOTONES DE ACCIÓN --}}
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" 
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm transition-all">
                    Guardar registro
                </button>
                <a href="{{ route('employee.movements.index', $employee) }}"
                   class="flex-1 text-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-4 rounded-lg transition-all">
                    Cancelar
                </a>
            </div>

        </div>
    </form>

</div>
@endsection