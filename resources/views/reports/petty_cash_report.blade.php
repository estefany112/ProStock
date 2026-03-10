<table width="100%" style="margin-bottom:20px;">
<tr>

<!-- Logo -->
<td width="20%" style="text-align:left;">
<img src="{{ public_path('images/logo.jpg') }}" style="width:120px;">
</td>

<!-- Descripción empresa -->
<td width="40%" style="font-size:11px; text-align:left;">
MANTENIMIENTO ELÉCTRICO
<br>REFRIGERACIÓN Y A/C COMERCIAL E INDUSTRIAL
<br>PROYECTOS DE ELECTRIFICACIÓN
<br>ESTRUCTURAS METÁLICAS Y REMODELACIONES
</td>

<!-- Información de contacto -->
<td width="30%" style="font-size:11px; text-align:left;">
5a. Calle Lote 56 “A” <br>Residencial Vistas de Cecilia zona 3 Escuintla<br>
<strong>Teléfonos:</strong> 31032136 / 55653332<br>
<strong>Correo:</strong> servicioselectricosvelasquez@gmail.com<br>
<strong>Web:</strong>
</td>

</tr>
</table>
<br>
<h2 style="text-align:center;">Reporte Caja Chica</h2>

<p>
<strong>Saldo inicial de apertura:</strong>
Q {{ number_format($cash->initial_balance, 2) }}
</p>

<p>
<strong>Semana:</strong>
{{ \Carbon\Carbon::parse($cash->period_start)->format('d/m/Y') }}
-
{{ \Carbon\Carbon::parse($cash->period_end)->format('d/m/Y') }}
</p>

<br>

<table width="100%" cellspacing="0" cellpadding="6" style="border-collapse: collapse; font-size:14px;">
<thead style="background:#1f4e79; color:white;">
<tr>
<th style="border:1px solid #ccc;">Fecha</th>
<th style="border:1px solid #ccc;">Tipo</th>
<th style="border:1px solid #ccc;">Concepto</th>
<th style="border:1px solid #ccc;">Monto</th>
<th style="border:1px solid #ccc;">Responsable</th>
</tr>
</thead>

<tbody>
@foreach($movements as $m)
<tr>
<td style="border:1px solid #ccc;">
{{ \Carbon\Carbon::parse($m->created_at)->format('d/m/Y H:i') }}
</td>

<td style="border:1px solid #ccc;">
{{ $m->type }}
</td>

<td style="border:1px solid #ccc;">
{{ $m->concept }}
</td>

<td style="border:1px solid #ccc; text-align:right;">
Q {{ number_format($m->amount,2) }}
</td>

<td style="border:1px solid #ccc;">
{{ $m->responsible }}
</td>
</tr>
@endforeach
</tbody>
</table>

<br>

<p style="font-size:16px;">
<strong>Saldo final:</strong> 
Q {{ number_format($cash->current_balance,2) }}