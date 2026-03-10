<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reporte Caja Chica</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" bgcolor="#f4f6f9" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; margin-top:30px; border-radius:6px; overflow:hidden;">

<!-- Encabezado -->
<tr>
<td style="background:#1f4e79; color:white; padding:20px; text-align:center;">

<img src="{{ $message->embed(public_path('images/icono.png')) }}" 
     alt="PROSERVE"
     style="width:120px; margin-bottom:10px;">

<h2 style="margin:0;">Reporte de Caja Chica</h2>
<p style="margin:5px 0 0 0;">Sistema PROSERVE</p>

</td>
</tr>

<!-- Contenido -->
<tr>
<td style="padding:30px; color:#333; font-size:15px; line-height:1.6;">

<p><strong>Estimado usuario,</strong></p>

<p>
Se adjunta el <strong>reporte de movimientos de Caja Chica</strong> correspondiente a la semana actual.
</p>

<p>
En el archivo PDF encontrará el detalle completo de:
</p>

<ul>
<li>Ingresos registrados</li>
<li>Egresos realizados</li>
<li>Saldo final de la semana</li>
</ul>

<p>
Le recomendamos revisar el documento adjunto para validar la información registrada en el sistema.
</p>

<br>

<p>Saludos cordiales,</p>

<strong>Equipo del Sistema PROSERVE</strong>

</td>
</tr>

<!-- Footer -->
<tr>
<td style="background:#f0f0f0; text-align:center; padding:15px; font-size:12px; color:#777;">
Este correo fue generado automáticamente por el sistema PROSERVE.
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>