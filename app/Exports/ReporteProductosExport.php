<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReporteProductosExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $tipo;

    public function __construct($tipo)
    {
        $this->tipo = $tipo;
    }

    public function query()
    {
        $query = Producto::query()->with('categoria')->orderBy('descripcion');

        switch ($this->tipo) {
            case 'sin_precio':
                $query->where(function ($q) {
                    $q->whereNull('precio_unitario')
                      ->orWhere('precio_unitario', 0);
                });
                break;

            case 'sin_imagen':
                $query->where(function ($q) {
                    $q->whereNull('image')
                      ->orWhere('image', '');
                });
                break;
        }

        return $query;
    }

    public function map($producto): array
    {
        return [
            $producto->codigo,
            $producto->descripcion,
            $producto->categoria->nombre ?? 'N/A',
            (int) $producto->stock_actual,
            $producto->precio_unitario ?? 'SIN PRECIO',
            $producto->image ? 'SI' : 'NO',
        ];
    }

    public function headings(): array
    {
        return [
            'Código',
            'Producto',
            'Categoría',
            'Stock',
            'Precio',
            'Imagen',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 35,
            'C' => 20,
            'D' => 12,
            'E' => 15,
            'F' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $ultimaFila = $sheet->getHighestRow();

        return [
            // 1. Estilo para la Cabecera
            1 => [
                'font' => [
                    'bold' => true, 
                    'color' => ['argb' => 'FFFFFF'],
                    'size' => 11
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '2563EB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // 2. Bordes para toda la tabla
            'A1:F' . $ultimaFila => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'D1D5DB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // 3. Alineación corregida usando los valores correctos
            'A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'D' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
            'E' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
            'F' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }
}