@extends('layouts.principal')

@section('content')
<div class="max-w-4xl mx-auto py-8">

<div class="bg-white p-6 rounded-xl shadow">

<h2 class="mb-4 font-semibold">Detalle - {{ $empleado->name }}</h2>

<table class="w-full text-sm">
<thead>
<tr class="border-b bg-gray-50">
<th>Fecha</th>
<th>Horas</th>
<th>Total</th>
</tr>
</thead>
<tbody>
@foreach($registros as $r)
<tr class="border-b">
<td>{{ $r->fecha }}</td>
<td>{{ $r->horas }}</td>
<td>Q {{ number_format($r->total,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>
</div>
@endsection