<h2>Reporte Caja Chica - PROSERVE</h2>

<p>Semana:
{{ \Carbon\Carbon::parse($cash->period_start)->format('d/m/Y') }}
–
{{ \Carbon\Carbon::parse($cash->period_end)->format('d/m/Y') }}
</p>

<table border="1" width="100%" cellspacing="0" cellpadding="5">
<thead>
<tr>
<th>Fecha</th>
<th>Tipo</th>
<th>Concepto</th>
<th>Monto</th>
<th>Responsable</th>
</tr>
</thead>

<tbody>
@foreach($movements as $m)
<tr>
<td>{{ $m->created_at }}</td>
<td>{{ $m->type }}</td>
<td>{{ $m->concept }}</td>
<td>Q {{ number_format($m->amount,2) }}</td>
<td>{{ $m->responsible }}</td>
</tr>
@endforeach
</tbody>
</table>

<p><strong>Saldo final:</strong> Q {{ number_format($cash->current_balance,2) }}</p>