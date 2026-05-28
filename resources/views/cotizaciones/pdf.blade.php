@php
$comerciales = $cotizacion->items->where('tipo','comercial');
$servicios = $cotizacion->items->where('tipo','servicio');
$materiales = $cotizacion->items->where('tipo','material');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización - {{ $cotizacion->folio }}</title>

    <style>
        @page {
            margin: 180px 1.5cm 1cm 1.5cm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
        }

        /* Encabezado fijo que se repite en todas las hojas */
        header {
            position: fixed;
            top: -140px;
            left: 0;
            right: 0;
            height: 180px;
        }

        /* Clase para forzar el salto a la siguiente página */
        .page-break {
            page-break-before: always;
        }

        table { width: 100%; border-collapse: collapse; }

        .section-title {
            font-size: 11px; font-weight: bold; text-transform: uppercase;
            letter-spacing: .05em; color: #0f172a; border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px; margin-top: 18px; margin-bottom: 10px;
        }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background: #0f172a; color: white; border: 1px solid rgb(252, 252, 253); padding: 8px; font-size: 10px; text-transform: uppercase; }
        .data-table td { border: 1px solid #cbd5e1; padding: 8px; vertical-align: top; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: monospace; }
        .card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; margin-bottom: 14px; }
        .detail-list { margin: 0; padding-left: 20px; }
        .detail-list li { margin-bottom: 5px; }
        .signature-table { width: 100%; margin-top: 60px; }
        .signature-box { width: 45%; text-align: center; vertical-align: top; }
        .signature-line { border-top: 1px solid #94a3b8; margin-top: 55px; padding-top: 8px; }
        .signature-name { font-weight: bold; font-size: 11px; color: #0f172a; }
        .signature-role { font-size: 10px; color: #64748b; }
        .text-muted { color: #64748b; }
    </style>
</head>

<body>

    {{-- ENCABEZADO REPETITIVO --}}
    <header>
    <table width="100%" style="border-bottom: 2px solid #ffffff; padding-bottom:0px;">
        <tr>
            <td width="20%" style="vertical-align:top;">
                @if(file_exists(public_path('images/logo.jpg')))
                    <img src="{{ public_path('images/logo.jpg') }}" style="width:120px;">
                @endif
            </td>

            <td width="45%" style="font-size:10px; color:#0f172a; line-height:1.1; vertical-align:top;">
                MANTENIMIENTO ELÉCTRICO
                <br>REFRIGERACIÓN Y A/C COMERCIAL E INDUSTRIAL
                <br>PROYECTOS DE ELECTRIFICACIÓN
                <br>ESTRUCTURAS METÁLICAS Y REMODELACIONES
            </td>

            <td width="35%" style="font-size:10px; line-height:1.1; vertical-align:top; color:#334155;">
                {{ $empresa->direccion ?? 'Escuintla, Guatemala' }}
               <br><strong>Teléfonos:</strong> 
                @php
                    // Separamos por comas, diagonales o guiones largos
                    $numeros = preg_split('/[\/,-]+/', $empresa->telefono ?? '0000-0000');
                @endphp

                @foreach($numeros as $index => $num)
                    @php $limpio = preg_replace('/[^0-9]/', '', $num); @endphp
                    <a href="https://wa.me/502{{ $limpio }}" style="color:#334155; text-decoration:none;" target="_blank">
                        {{ trim($num) }}
                    </a>{{ !$loop->last ? ' / ' : '' }}
                @endforeach
                <br><span style="font-size:8.5px;"><strong>Correo:</strong> {{ $empresa->correo ?? 'correo@empresa.com' }}</span>

                <div style="font-size:18px; font-weight:bold; color:#2563eb; margin-top:10px; text-align:right;">
                    NIT: {{ $empresa->nit ?? '000000-0' }}
                </div>
            </td>
        </tr>
    </table>
</header>

    {{-- CONTENIDO --}}
    <div style="text-align:right; margin-bottom:45px;">
        <div style="display:inline-block; border:1px solid #cbd5e1; padding:10px 18px; border-radius:10px; background:#f8fafc;">
            <div style="font-size:20px; font-weight:bold; color:#0f172a; margin-bottom:4px;">COTIZACIÓN</div>
            <div style="font-size:12px; font-family:monospace; color:#2563eb; font-weight:bold;">{{ $cotizacion->folio }}</div>
            <div style="font-size:10px; color:#64748b; margin-top:4px;">
                Fecha: {{ \Carbon\Carbon::parse($cotizacion->fecha_emision)->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Datos del Cliente</div>
        <table>
            <tr>
                <td width="15%"><strong>Cliente:</strong></td>
                <td width="55%">{{ $cotizacion->cliente->empresa ?? $cotizacion->cliente->nombre }}</td>
                <td width="10%"><strong>NIT:</strong></td>
                <td width="20%" class="font-mono">{{ $cotizacion->cliente->nit ?? 'CF' }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td colspan="3">{{ $cotizacion->cliente->direccion ?? 'Ciudad de Guatemala' }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom:20px;">Estimados señores, presentamos la siguiente propuesta económica para su evaluación y aprobación.</div>

    <div class="card">
        <div class="section-title">Datos del Oferente</div>
        <table class="data-table">
            <tr><td width="30%" style="background:#f8fafc;"><strong>Empresa</strong></td><td>{{ $empresa->nombre ?? 'PROSERVE' }}</td></tr>
            <tr><td style="background:#f8fafc;"><strong>NIT</strong></td><td class="font-mono">{{ $empresa->nit ?? 'CF' }}</td></tr>
            <tr><td style="background:#f8fafc;"><strong>Teléfono</strong></td><td>{{ $empresa->telefono ?? '0000-0000' }}</td></tr>
            <tr><td style="background:#f8fafc;"><strong>Correo</strong></td><td>{{ $empresa->correo ?? 'correo@empresa.com' }}</td></tr>
            <tr><td style="background:#f8fafc;"><strong>Cuenta Bancaria</strong></td><td style="white-space:pre-line;">{{ $empresa->cuenta_bancaria ?? 'No configurada' }}</td></tr>
        </table>
    </div>

    {{-- SALTO DE PÁGINA ANTES DE LA OFERTA ECONÓMICA --}}
    <div class="page-break"></div>

    <div class="card">
        <div class="section-title">Oferta Económica</div>
        <table class="data-table">
            <thead>
                <tr><th>No.</th><th>Cant.</th><th>Unidad</th><th>Descripción</th><th>P/U</th><th>Total</th></tr>
            </thead>
            <tbody>
                @forelse($cotizacion->items->where('tipo', 'comercial') as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $item->cantidad }}</td>
                        <td class="text-center">{{ $item->unidad_medida }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td class="text-right font-mono">Q {{ number_format($item->precio_unitario,2) }}</td>
                        <td class="text-right font-mono">Q {{ number_format($item->total,2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No existen items registrados.</td></tr>
                @endforelse
                <tr>
                    <td colspan="4" style="border:none;"></td>
                    <td style="background:#f8fafc; font-weight:bold;" class="text-right">TOTAL</td>
                    <td style="background:#f8fafc; font-weight:bold;" class="text-right font-mono">Q {{ number_format($cotizacion->total,2) }}</td>
                </tr>
                <tr>
                    <td style="background:#f8fafc;"><strong>Total en Letras</strong></td>
                    <td colspan="5">{{ $cotizacion->total_letras }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="section-title">Alcances del Servicio / Material</div>
        <ol class="detail-list" type="a">
            @forelse($cotizacion->items->whereIn('tipo', ['servicio', 'material']) as $item) <li>{{ $item->descripcion }}</li> @empty <li>No se registraron servicios.</li> @endforelse
        </ol>
    </div>

    <div class="card">
        <div class="section-title">Condiciones Comerciales</div>
        <table>
            <tr><td width="30%"><strong>Lugar de Entrega:</strong></td><td>{{ $cotizacion->lugar_entrega }}</td></tr>
            <tr><td><strong>Tiempo de Entrega:</strong></td><td>{{ $cotizacion->tiempo_entrega }}</td></tr>
            <tr><td><strong>Garantía:</strong></td><td>{{ $cotizacion->garantia }}</td></tr>
            <tr><td><strong>Forma de Pago:</strong></td><td>{{ $cotizacion->forma_pago }}</td></tr>
            <tr><td><strong>Validez Oferta:</strong></td><td>{{ $cotizacion->validez_oferta }}</td></tr>
        </table>
    </div>

    <table class="signature-table" style="width: 100%; border-collapse: collapse;">
    {{-- Fila para la despedida (ocupa todo el ancho) --}}
    <tr>
        <td colspan="3" style="padding-bottom: 25px; text-align: left;">
            <div>{{ $cotizacion->clausula_despedida }}</div>
        </td>
    </tr>

    <tr>
        {{-- Bloque de Firma --}}
        <td style="width: 45%; vertical-align: bottom; text-align: center;">
            <div style="margin-bottom: 5px;">
                @if(file_exists(public_path('images/firma_patrono.png')))
                    <img src="{{ public_path('images/firma_patrono.png') }}" style="max-height: 80px; width: auto; display: block; margin: 0 auto;">
                @else
                    <div style="height: 60px;"></div>
                @endif
            </div>
            
            <div style="border-top: 1px solid #000; padding-top: 5px; margin-top: 5px;">
                <div style="font-weight: bold; font-size: 12px;">{{ $cotizacion->nombre_firmante }}</div>
                <div style="font-size: 10px;">Representante Autorizado · {{ $empresa->nombre ?? 'PROSERVE' }}</div>
            </div>
        </td>
        
        {{-- Espaciador --}}
        <td style="width: 10%;"></td>
        
        {{-- Bloque de Sello (Estructura unificada) --}}
        <td style="width: 45%; vertical-align: bottom; text-align: center;">
            <div style="margin-bottom: 5px;">
                @if(file_exists(public_path('images/sello.png')))
                    <img src="{{ public_path('images/sello.png') }}" style="max-height: 150px; width: auto; display: block; margin: 0 auto;">
                @else
                    {{-- Si no hay sello, mantenemos el mismo espacio visual que la firma --}}
                    <div style="height: 60px;"></div>
                @endif
            </div>

            {{-- Línea de "sello" si la necesitas igual que la de firma --}}
            <div style="border-top: 1px dashed #cbd5e1; padding-top: 5px; margin-top: 5px;">
                <div style="font-size: 10px; color: #94a3b8;">SELLO</div>
            </div>
        </td>
    </tr>
</table>
        
</body>
</html>