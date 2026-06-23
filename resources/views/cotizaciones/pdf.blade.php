@php
$comerciales = $cotizacion->items->where('tipo','comercial');
$servicios = $cotizacion->items->where('tipo','servicio');
$materiales = $cotizacion->items->where('tipo','material');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 200px 1.5cm 90px 1.5cm; }
        body { font-family: DejaVu Sans, sans-serif; color: #292524; font-size: 10px; line-height: 1.3; background-color: #fafaf9; }
        
        /* Línea azul eliminada del header */
        header { position: fixed; top: -180px; left: 0; right: 0; height: 180px; }
        
        /* Línea azul eliminada del título de sección y ajustado color */
        .section-title { 
            font-size: 9px; 
            font-weight: 900; text-transform: uppercase; color: #292524; 
            margin: 25px 0 8px 0; border-bottom: 1px solid #d6d3d1; 
            padding-bottom: 5px;
            display: block;
        }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .data-table th { background: #44403c; color: white; padding: 6px; font-size: 8px; text-transform: uppercase; }
        .data-table td { border-bottom: 1px solid #e7e5e4; padding: 6px; }
        
        .box { border: 1px solid #d6d3d1; padding: 10px; margin-bottom: 10px; background: white; }
        footer { 
            position: fixed; bottom: -100px; left: 0; right: 0; height: 90px; 
            border-top: 1px solid #e7e5e4; padding-top: 10px;
        }
        .data-table th { 
            background: #0c4a6e; 
            color: white; 
            padding: 6px; 
            font-size: 8px; 
            text-transform: uppercase; 
        }
        .data-table thead {
            display: table-row-group !important;
        }
        tr, td {
    page-break-inside: avoid;
}
    </style>
</head>
<body>

    <header>
        <table width="100%">
            <tr>
                <td width="25%"><img src="{{ public_path('images/logo.jpg') }}" style="width:110px;"></td>
                <td width="40%" style="font-size:8px; color:#334155;">
                    <strong>{{ $empresa->nombre ?? 'PROSERVE' }}</strong><br>
                    MANTENIMIENTO ELÉCTRICO Y REFRIGERACIÓN<br>
                    A/C COMERCIAL E INDUSTRIAL<br>
                    PROYECTOS DE ELECTRIFICACIÓN Y ESTRUCTURAS
                </td>
                <td width="35%" style="font-size:8px; text-align:right;">
                    {{ $empresa->direccion }}<br>
                    Tel: {{ $empresa->telefono }}<br>
                    Correo: {{ $empresa->correo }}<br>
                    <strong>NIT: {{ $empresa->nit }}</strong>
                </td>
            </tr>
        </table>
    </header>

   <div style="text-align: right; font-family: sans-serif; margin-bottom: 25px;">
    <!-- Folio: Sencillo y directo -->
    <div style="text-align: right; font-weight: bold; font-size: 18px; color: #0c4a6e; margin-bottom: 20px;">

    CTZ_{{ $cotizacion->folio }}

    </div>
    
    <!-- Fecha: Formato estándar profesional -->
    <div style="font-size: 15px; color: #475569;">
        Escuintla, {{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}
    </div>
</div>

    <table width="100%" style="margin-bottom: 20px;">
        <tr>
            <td width="50%" style="vertical-align: top;">
                <div class="section-title">Datos del Cliente</div>
                <div class="box">
                    <table width="100%">
                        <tr><td width="30%"><strong>Empresa:</strong></td><td>{{ $cotizacion->cliente->empresa }}</td></tr>
                        <tr><td><strong>NIT:</strong></td><td>{{ $cotizacion->cliente->nit ?? 'C/F' }}</td></tr>
                        <tr><td><strong>Dirección:</strong></td><td>{{ $cotizacion->cliente->direccion ?? 'No especificada' }}</td></tr>
                        <tr><td><strong>Teléfono:</strong></td><td>{{ $cotizacion->cliente->telefono ?? 'N/A' }}</td></tr>
                        <tr><td><strong>Correo:</strong></td><td>{{ $cotizacion->cliente->email ?? 'N/A' }}</td></tr>
                    </table>
                </div>
            </td>
            <td width="50%" style="vertical-align: top; padding-left: 10px;">
                <div class="section-title">Datos del Oferente</div>
                <div class="box">
                    <table width="100%">
                        <tr><td width="30%"><strong>Empresa:</strong></td><td>{{ $empresa->nombre }}</td></tr>
                        <tr><td><strong>NIT:</strong></td><td>{{ $empresa->nit }}</td></tr>
                        <tr><td><strong>Dirección:</strong></td><td>{{ $empresa->direccion }}</td></tr>
                        <tr><td><strong>Teléfono:</strong></td><td>{{ $empresa->telefono }}</td></tr>
                        <tr><td><strong>Cuenta:</strong></td><td>{{ $empresa->cuenta_bancaria }}</td></tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    @if(
    in_array($cotizacion->cliente->tipo_cliente, ['Empresa Pública', 'Estatal'])
    && !empty($cotizacion->nog)
)

    {{-- Con NOG --}}
    <div style="margin-bottom:20px; text-align:center; font-size:12px;">
        Estimados Señores, presentamos para su consideración la oferta correspondiente al evento identificado con número de

        <span style="color:#dc2626; font-size:18px; font-weight:bold;">
            NOG {{ $cotizacion->nog }}
        </span>.
    </div>
@else

    {{-- Sin NOG --}}
    <div style="margin-bottom:20px; text-align:justify; font-size:12px;">
        Estimados Señores, por este medio presentamos para su consideración y evaluación la presente oferta económica, elaborada conforme a los requerimientos solicitados.
    </div>
@endif

    <div class="section-title">Oferta Económica</div>
    <table class="data-table">
        <thead>
            <tr style="background-color: #0c4a6e; color: white;">
                <th style="padding: 6px; font-size: 8px; text-transform: uppercase;">Item.</th>
                <th style="padding: 6px; font-size: 8px; text-transform: uppercase;">Cant.</th>
                <th style="padding: 6px; font-size: 8px; text-transform: uppercase;">Unidad de Medida</th>
                <th style="padding: 6px; font-size: 8px; text-transform: uppercase;">Descripción</th>
                <th style="padding: 6px; font-size: 8px; text-transform: uppercase;">Precio Unitario    </th>
                <th style="padding: 6px; font-size: 8px; text-transform: uppercase;">Total</th>
            </tr>
        </thead>
    <tbody>
        @foreach($comerciales as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}
                </td>
                <td align="center">{{ $item->cantidad }}</td>
                <td align="center">{{ $item->unidad_medida }}</td>
                <td align="center">{{ $item->descripcion }}</td>
                <td align="center">Q {{ number_format($item->precio_unitario, 2) }}</td>
                <td align="center" style="font-weight:bold;">Q{{ number_format($item->total, 2) }}</td>
            </tr>
        @endforeach
        <!-- Fila del TOTAL -->
        <tr>
            <td colspan="5"
                style="
                    background:#0c4a6e;
                    color:white;
                    font-weight:bold;
                    text-align:right;
                    padding:12px;
                    font-size:12px;
                ">
                TOTAL IVA INCLUIDO
            </td>

            <td
                style="
                    background:#0c4a6e;
                    color:white;
                    font-weight:bold;
                    text-align:center;
                    padding:12px;
                    font-size:12px;
                    white-space:nowrap;
                ">
                Q {{ number_format($cotizacion->total, 2) }}
            </td>
        </tr>
      
            <!-- Fila de TOTAL EN LETRAS -->
            <tr>
                <td colspan="5"
                    style="
                        border:1px solid #d6d3d1;
                        padding:12px;
                        background:#f8fafc;
                    ">
                    <strong style="color:#0c4a6e;">
                        TOTAL EN LETRAS:
                    </strong>
                    {{ strtoupper($cotizacion->total_letras) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Alcance Técnico</div>
    <ul style="list-style: none; padding: 0;margin:0;">
        @foreach($servicios->merge($materiales) as $index => $item)
            <li style="margin:0; padding:0; line-height:1.2;">
                {{ chr(97 + $index) }}) {{ $item->descripcion }}
            </li>
        @endforeach
    </ul>

<div style="page-break-inside: avoid;">
    <div class="section-title">Condiciones Comerciales</div>
    <table width="100%" class="box">
        <tr><td width="30%"><strong>1. Lugar:</strong></td><td>{{ $cotizacion->lugar_entrega }}</td></tr>
        <tr><td><strong>2. Tiempo:</strong></td><td>{{ $cotizacion->tiempo_entrega }}</td></tr>
        <tr><td><strong>3. Garantía:</strong></td><td>{{ $cotizacion->garantia }}</td></tr>
        <tr><td><strong>4. Pago:</strong></td><td>{{ $cotizacion->forma_pago }}</td></tr>
        <tr><td><strong>5. Validez:</strong></td><td>{{ $cotizacion->validez_oferta }}</td></tr>
    </table>

    <div style="margin-top: 30px; margin-bottom: 25px; font-size: 12px; line-height: 1.5; color: #334155; text-align: justify;">
        {!! nl2br(e($cotizacion->clausula_despedida)) !!}
    </div>

    <table width="100%" style="border-collapse: collapse; margin-top: 40px;">
        <tr>
            <td style="width: 50%; vertical-align: bottom; text-align: center; padding-bottom: 20px;">
                <div style="margin-bottom: 10px;">
                    @if(file_exists(public_path('images/firma_patrono.png')))
                        <img src="{{ public_path('images/firma_patrono.png') }}" style="max-height: 75px; width: auto; display: block; margin: 0 auto;">
                    @endif
                </div>
                <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
                    <div style="font-weight: bold; font-size: 11px;">{{ $cotizacion->nombre_firmante }}</div>
                    <div style="font-size: 9px; color: #475569;">Representante Autorizado</div>
                </div>
            </td>
            <td style="width: 50%; vertical-align: bottom; text-align: center; padding-bottom: 20px;">
                <div style="margin-bottom: 10px;">
                    @if(file_exists(public_path('images/sello.png')))
                        <img src="{{ public_path('images/sello.png') }}" style="max-height: 115px; width: auto; display: block; margin: 0 auto;">
                    @endif
                </div>
                <div style="border-top: 1px dashed #94a3b8; width: 200px; margin: 0 auto; padding-top: 5px;">
                    <div style="font-size: 9px; color: #94a3b8; text-transform: uppercase;">Sello de la Empresa</div>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>