@extends('layouts.principal')

@section('content')

<div class="container">
    <h2 class="mb-4">Nueva Solicitud</h2>

    <form action="{{ route('solicitudes.store') }}" method="POST">
        @csrf

        {{-- EMPLEADO --}}
        <div class="mb-3">
            <label class="form-label">Empleado</label>
            <select name="empleado_id" class="form-control" required>
                <option value="">Seleccione empleado</option>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}">
                        {{ $empleado->name }} - {{ $empleado->position }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- OBSERVACION --}}
        <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea name="observacion" class="form-control" rows="3"></textarea>
        </div>

        <hr>

        <h5>Materiales</h5>

        <div id="materiales">
            <div class="row mb-2">
                <div class="col-md-6">
                    <input type="text" name="descripcion[]" class="form-control" placeholder="Descripción del material" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-row">Eliminar</button>
                </div>
            </div>
        </div>

        <button type="button" id="addRow" class="btn btn-secondary mb-3">
            Agregar otro material
        </button>

        <br>

        <button type="submit" class="btn btn-primary">
            Enviar Solicitud
        </button>
    </form>
</div>

{{-- SCRIPT PARA AGREGAR FILAS --}}
<script>
document.getElementById('addRow').addEventListener('click', function() {
    let row = `
        <div class="row mb-2">
            <div class="col-md-6">
                <input type="text" name="descripcion[]" class="form-control" placeholder="Descripción del material" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" min="1" required>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-row">Eliminar</button>
            </div>
        </div>
    `;
    document.getElementById('materiales').insertAdjacentHTML('beforeend', row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('.row').remove();
    }
});
</script>

@endsection