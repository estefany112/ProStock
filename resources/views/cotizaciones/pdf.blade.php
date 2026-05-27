<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización - {{ $cotizacion->codigo ?? 'COT.INDE.05146.2026' }}</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
        }
        
        /* Encabezado Principal */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .logo-text {
            font-size: 10px;
            font-weight: bold;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .doc-meta {
            text-align: right;
            font-size: 11px;
        }
        .doc-title {
            font-size: 16px;
            font-weight: 900;
            color: #0f172a;
            margin: 0 0 5px 0;
            letter-spacing: -0.025em;
        }
        .doc-code {
            font-family: monospace;
            font-size: 12px;
            font-weight: bold;
            color: #2563eb;
        }

        /* Bloques de Datos e Información */
        .info-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-section td {
            vertical-align: top;
            padding: 4px 0;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Tablas de Datos Estructurados (Oferente y Oferta Económica) */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            vertical-align: top;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-mono { font-family: monospace; font-size: 11px; }

        /* Contenedores de Texto y Listas */
        .saludo {
            margin-bottom: 15px;
            font-size: 11px;
        }
        .detail-list {
            margin: 0;
            padding-left: 20px;
        }
        .detail-list li {
            margin-bottom: 4px;
        }
        .text-block {
            padding: 4px 0 4px 10px;
            color: #334155;
        }

        /* Firmas y Cierre */
        .closure-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-container {
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            width: 45%;
            border-top: 1px solid #94a3b8;
            text-align: center;
            padding-top: 6px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="logo-text">
                    MANTENIMIENTO ELÉCTRICO<br>
                    REFRIGERACIÓN Y A/C COMERCIAL E INDUSTRIAL.<br>
                    PROYECTOS DE ELECTRIFICACIÓN.<br>
                    ESTRUCTURAS METÁLICAS Y REMODELACIONES
                </div>
            </td>
            <td class="doc-meta">
                <h1 class="doc-title">COTIZACIÓN</h1>
                <div class="doc-code">{{ $cotizacion->codigo ?? 'COT.INDE.05146.2026' }}</div>
                <div style="margin-top: 5px; color: #64748b;">
                    Guatemala, {{ \Carbon\Carbon::parse($cotizacion->fecha_emision ?? now())->format('d/m/Y') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="info-section">
        <tr>
            <td style="width: 12%; font-weight: bold;">Nombre:</td>
            <td style="width: 53%;">{{ $cliente->empresa ?? 'INDE / PLANTA HIDROELÉCTRICA JURUN MARINALÁ' }}</td>
            <td style="width: 8%; font-weight: bold; text-align: right;">Nit:</td>
            <td style="width: 27%; padding-left: 10px;" class="font-mono">{{ $cliente->nit ?? '245540-4' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Dirección:</td>
            <td colspan="3">{{ $cliente->direccion ?? '7A. AVENIDA 2-29 ZONA 9 GUATEMALA' }}</td>
        </tr>
    </table>

    <div class="saludo">
        Estimados Sres., estamos presentando para su respectivo análisis, lo solicitado y detallado a continuación:
    </div>

    <div class="section-title">1. DATOS DEL OFERENTE</div>
    <table class="data-table">
        <tr>
            <td style="width: 30%; font-weight: bold; background-color: #f8fafc;">Nombre de la Empresa</td>
            <td style="width: 70%;">{{ $empresa->nombre ?? 'PROSERVE' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f8fafc;">Nit</td>
            <td class="font-mono">{{ $empresa->nit ?? '2651092-8' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f8fafc;">Dirección</td>
            <td>{{ $empresa->direccion ?? 'Ciudad de Guatemala' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f8fafc;">Teléfonos</td>
            <td class="font-mono">{{ $empresa->telefono ?? '34564545' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f8fafc;">Correo Electrónico</td>
            <td>{{ $empresa->correo ?? 'correo@proserve.com' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f8fafc;">Régimen del ISR</td>
            <td>{{ $empresa->regimen_isr ?? 'Régimen Opcional Simplificado Sobre Ingresos de Actividades Lucrativas' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f8fafc;">No. Cuenta Bancaria</td>
            <td class="font-mono" style="white-space: pre-line;">{{ $empresa->cuenta_bancaria ?? 'Monetaria Banco Industrial: 000-000000-0' }}</td>
        </tr>
    </table>

    <div class="section-title">2. OFERTA ECONÓMICA</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 7%; text-align: center;">No.</th>
                <th style="width: 10%; text-align: center;">Cantidad</th>
                <th style="width: 15%; text-align: center;">Unidad de Medida</th>
                <th style="width: 38%;">Descripción</th>
                <th style="width: 15%; text-align: right;">Precio Unitario</th>
                <th style="width: 15%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items ?? [1] as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item['cantidad'] ?? '1' }}</td>
                <td class="text-center">{{ $item['unidad_medida'] ?? 'Servicio' }}</td>
                <td>{{ $item['descripcion'] ?? 'MANTENIMIENTO Y REPARACIÓN DE MOTORES ELÉCTRICOS' }}</td>
                <td class="text-right font-mono">Q {{ number_format($item['precio_unitario'] ?? 9000, 2) }}</td>
                <td class="text-right font-mono">Q {{ number_format($item['total'] ?? 9000, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" border="0" style="border-left: none; border-bottom: none; border-right: none;"></td>
                <td style="font-weight: bold; background-color: #f8fafc;" class="text-right">Total IVA Incluido</td>
                <td class="text-right font-mono" style="font-weight: bold; background-color: #f8fafc;">
                    Q {{ number_format($total ?? 9000, 2) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; background-color: #f8fafc;">Total en Letras</td>
                <td colspan="5">{{ $total_letras ?? 'Diecisiete mil quetzales exactos con 00/100' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">2. DETALLE DEL SERVICIO / MATERIAL</div>
    <ol class="detail-list" type="a">
        @if(isset($detalles) && count($detalles) > 0)
            @foreach($detalles as $detalle)
                <li>{{ $detalle['descripcion'] }}</li>
            @endforeach
        @else
            <li>Mantenimiento completo a motor eléctrico</li>
            <li>Cambio de cojinetes</li>
            <li>Rebobinado de motor completo</li>
            <li>Pintura general</li>
            <li>Entrega de informe fotográfico</li>
        @endif
    </ol>

    <div class="section-title">3. LUGAR DE ENTREGA</div>
    <div class="text-block">{{ $lugar_entrega ?? 'Instalaciones del cliente o planta central.' }}</div>

    <div class="section-title">4. TIEMPO DE ENTREGA</div>
    <div class="text-block">{{ $tiempo_entrega ?? '10 días hábiles, después de recibir OCP.' }}</div>

    <div class="section-title">5. GARANTÍA</div>
    <div class="text-block">{{ $garantia ?? '6 meses por mantenimiento y reparación.' }}</div>

    <div class="section-title">6. FORMA DE PAGO</div>
    <div class="text-block">{{ $forma_pago ?? 'Orden de compra y pago.' }}</div>

    <div class="section-title">7. VALIDEZ DE LA OFERTA</div>
    <div class="text-block">{{ $validez_oferta ?? '15 días calendario a partir de su emisión.' }}</div>

    <div class="closure-section">
        <p style="margin-bottom: 25px;">
            {{ $clausula_despedida ?? 'Esperando poder servirles de la mejor manera, me suscribo de ustedes. Atentamente,' }}
        </p>

        <table class="signature-container">
            <tr>
                <td class="signature-box">
                    <strong>{{ $nombre_firmante ?? 'Ing. Wuilmar Velásquez' }}</strong><br>
                    <span style="color: #64748b; font-size: 10px;">PROSERVE</span><br>
                    <span style="color: #64748b; font-size: 10px;">NIT: {{ $empresa->nit ?? '2651092-8' }}</span>
                </td>
                <td style="width: 10%;"></td>
                <td style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 9px; color: #94a3b8; border: 1px dashed #cbd5e1; padding: 10px; inline-block; width: 120px;">
                        VALIDACIÓN:<br>PROSERVE-GERENCIA
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>