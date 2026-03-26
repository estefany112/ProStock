@extends('layouts.principal')

@section('content')

<style>
@media print {

    header, nav, aside, footer,
    .sidebar, .navbar, .header, .footer {
        display: none !important;
    }

    body * {
        visibility: hidden;
    }

    .print-area, .print-area * {
        visibility: visible;
    }

    .print-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    body {
        background: white;
    }
}
</style>

<div class="max-w-4xl mx-auto py-6">

    <div class="flex justify-between mb-4 no-print">
        <h2 class="text-lg font-semibold">Vista previa de boleta</h2>

        <button onclick="window.print()" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
            🖨️ Descargar PDF
        </button>

        <div class="no-print" style="text-align:right; margin-bottom:10px;">
            <button onclick="window.print()" style="
                background:#111;
                color:#fff;
                border:none;
                padding:8px 15px;
                cursor:pointer;
                font-size:12px;
                border-radius:4px;">
                🖨 Imprimir
            </button>
        </div>
    </div>

    {{-- 🔥 ESTE ES EL CAMBIO IMPORTANTE --}}
    <div class="print-area">
        <div class="bg-white shadow p-4">
            @include('planillas.boleta')
        </div>
    </div>

</div>

@endsection