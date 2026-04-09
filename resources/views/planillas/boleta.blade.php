<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    @media print {
        @page {
            size: letter portrait;
            margin: 12mm 15mm;
        }
        html, body { margin: 0; padding: 0; }
    }
</style>
</head>
<body style="font-family: Arial, sans-serif; font-size:10px; color:#1a1a1a; background:#fff; margin:0; padding:0;">

{{--
    Área útil: 279.4 - 24 = 255.4mm alto | 215.9 - 30 = 185.9mm ancho
    Separador: 5mm
    Cada recibo: (255.4 - 5) / 2 = 125.2mm
--}}
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width:100%; height:255.4mm;">

@for($i = 0; $i < 2; $i++)

<tr style="height:125.2mm;">
<td style="vertical-align:top; padding:0; height:125.2mm;">

    <!-- COPY TAG -->
    <div style="text-align:right; font-size:7px; letter-spacing:1.5px; text-transform:uppercase; color:#aaa; margin-bottom:3px;">
        {{ $i === 0 ? 'COPIA — EMPRESA' : 'COPIA — EMPLEADO' }}
    </div>

    <!-- ENCABEZADO -->
    <table width="100%" cellspacing="0" cellpadding="0" style="border:1.5px solid #1a1a1a; margin-bottom:0;">
    <tr>
        <td width="100" style="border-right:1.5px solid #1a1a1a; background:#f5f5f5; padding:6px 8px; text-align:center; vertical-align:middle;">
            @php
                $path = public_path('images/logo.jpg');
                $type = pathinfo($path, PATHINFO_EXTENSION);
            @endphp
            <img src="data:image/{{ $type }};base64,{{ base64_encode(file_get_contents($path)) }}" style="width:80px;">
        </td>
        <td style="padding:6px 10px; vertical-align:top;">
            <div style="font-size:12px; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase; border-bottom:1px solid #ccc; padding-bottom:3px; margin-bottom:4px;">
                Recibo de Pago
            </div>
            <div style="font-size:9px; color:#444; line-height:1.45; text-align:justify;">
                Por medio del presente documento se deja constancia de que, en la fecha indicada,
                la empresa <b style="color:#1a1a1a;">PROSERVE</b> realiza el pago de la cantidad detallada a continuación,
                en concepto de salario por los servicios laborales desempeñados en el puesto de:
                <b style="color:#1a1a1a;">{{ $empleado->position }}</b>.
            </div>
        </td>
    </tr>
    </table>

    <!-- DATOS -->
    <table width="100%" cellspacing="0" cellpadding="0" style="border:1.5px solid #1a1a1a; border-top:none; margin-bottom:0;">
    <tr>
        <td width="50%" style="padding:4px 10px; border-bottom:1px solid #e0e0e0; border-right:1px solid #e0e0e0; vertical-align:top;">
            <div style="font-size:7px; text-transform:uppercase; letter-spacing:0.5px; color:#777; margin-bottom:1px;">Empleado</div>
            <div style="font-size:10px; color:#1a1a1a;">{{ $empleado->name }}</div>
        </td>
        <td width="50%" style="padding:4px 10px; border-bottom:1px solid #e0e0e0; vertical-align:top;">
            <div style="font-size:7px; text-transform:uppercase; letter-spacing:0.5px; color:#777; margin-bottom:1px;">
                No. Boleta
            </div>
            <div style="font-size:11px; color:#1a1a1a; font-weight:bold;">
                {{ $empleado->pivot->correlativo ?? '-' }}
            </div>
        </td>
    </tr>
    <tr>
        <td style="padding:4px 10px; border-bottom:1px solid #e0e0e0; border-right:1px solid #e0e0e0; vertical-align:top;">
            <div style="font-size:7px; text-transform:uppercase; letter-spacing:0.5px; color:#777; margin-bottom:1px;">DPI</div>
            <div style="font-size:10px; color:#1a1a1a;">{{ $empleado->dpi }}</div>
        </td>
        <td style="padding:4px 10px; border-bottom:1px solid #e0e0e0; vertical-align:top;">
            <div style="font-size:7px; text-transform:uppercase; letter-spacing:0.5px; color:#777; margin-bottom:1px;">Año</div>
            <div style="font-size:10px; color:#1a1a1a;">{{ \Carbon\Carbon::parse($planilla->fecha_inicio)->year }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding:4px 10px; vertical-align:top;">
            <div style="font-size:7px; text-transform:uppercase; letter-spacing:0.5px; color:#777; margin-bottom:1px;">Período</div>
            <div style="font-size:10px; color:#1a1a1a;">{{ $planilla->fecha_inicio }} al {{ $planilla->fecha_fin }}</div>
        </td>
    </tr>
    </table>

    <!-- TABLA DE PAGOS -->
    <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border:1.5px solid #1a1a1a; border-top:none;">
    <thead>
    <tr style="background:#1a1a1a; color:#fff;">
        <th style="padding:4px 10px; text-align:left; font-size:8px; letter-spacing:0.8px; text-transform:uppercase; font-weight:600;">Concepto</th>
        <th style="padding:4px 10px; text-align:right; font-size:8px; letter-spacing:0.8px; text-transform:uppercase; font-weight:600; width:110px;">Monto (Q)</th>
    </tr>
    </thead>
    <tbody>
    <tr style="background:#fff;">
        <td style="padding:3px 10px; border-bottom:1px solid #e8e8e8;">Salario Base</td>
        <td style="padding:3px 10px; text-align:right; border-bottom:1px solid #e8e8e8;">{{ number_format($empleado->pivot->salary_base_quincenal, 2) }}</td>
    </tr>
    <tr style="background:#fafafa;">
        <td style="padding:3px 10px; border-bottom:1px solid #e8e8e8;">Bonificación</td>
        <td style="padding:3px 10px; text-align:right; border-bottom:1px solid #e8e8e8;">{{ number_format($empleado->pivot->bonificacion, 2) }}</td>
    </tr>
    <tr style="background:#fff;">
        <td style="padding:3px 10px; border-bottom:1px solid #e8e8e8;">Horas Extras</td>
        <td style="padding:3px 10px; text-align:right; border-bottom:1px solid #e8e8e8;">{{ number_format($empleado->pivot->horas_extras, 2) }}</td>
    </tr>
    <tr style="background:#fafafa;">
        <td style="padding:3px 10px; border-bottom:1px solid #e8e8e8;">IGSS</td>
        <td style="padding:3px 10px; text-align:right; border-bottom:1px solid #e8e8e8; color:#c0392b;">-{{ number_format($empleado->pivot->igss, 2) }}</td>
    </tr>
    <tr style="background:#fafafa;">
        <td style="padding:3px 10px;">ISR</td>
        <td style="padding:3px 10px; text-align:right; color:#c0392b;">-{{ number_format($empleado->pivot->isr, 2) }}</td>
    </tr>
    </tbody>
    </table>

    <!-- TOTAL -->
    <table width="100%" cellspacing="0" cellpadding="0" style="border:1.5px solid #1a1a1a; border-top:none; background:#1a1a1a; margin-bottom:10px;">
    <tr>
        <td style="padding:5px 10px; color:#ccc; font-size:8px; letter-spacing:1.2px; text-transform:uppercase;">Total a Recibir</td>
        <td style="padding:5px 10px; text-align:right; color:#fff; font-size:12px; font-weight:bold;">
            Q {{ number_format($empleado->pivot->liquido_recibir, 2) }}
        </td>
        <tr style="background:#fff;">
            <td colspan="2" style="padding:5px 10px; text-align:left; font-size:11px;">
                <strong>Fecha de emisión de pago:</strong> 
               {{ \Carbon\Carbon::parse($planilla->fecha_fin)
                    ->locale('es')
                    ->translatedFormat('d \\d\\e F \\d\\e Y') }}
        </tr>
    </tr>
    </table>

    <!-- PIE -->
    <table width="100%" cellspacing="0" cellpadding="0">
        <br>
    <tr>
        <td width="60%" style="vertical-align:bottom; font-size:8.5px; color:#555; line-height:1.4; text-align:justify; padding-right:15px;">
            El trabajador hace constar que ha recibido de conformidad el monto indicado,
            correspondiente al período laboral descrito anteriormente.
        </td>
        <td width="40%" style="text-align:center; vertical-align:bottom;">
            <div style="border-top:1px solid #1a1a1a; width:160px; margin:0 auto 3px;"></div>
            <div style="font-size:8px; letter-spacing:0.5px; text-transform:uppercase; color:#777;">Firma de Recibido</div>
        </td>
    </tr>
    </table>

</td>
</tr>

@if($i === 0)
<tr style="height:5mm;">
    <td></td>
</tr>
@endif

@endfor

</table>

</body>
</html>