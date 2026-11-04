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
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReporteProductosExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $tipo;

    public function __construct($tipo)
    {
        $this->tipo = $tipo;
    }

    public function query()
    {
        $query = Producto::query()
            ->with('categoria')
            ->orderBy('descripcion');

        switch ($this->tipo) {

            case 'sin_precio':
                $query->where(function ($q) {
                    $q->whereNull('precio_unitario')
                      ->orWhere('precio_unitario', '<=', 0);
                });
                break;

            case 'sin_imagen':
                $query->where(function ($q) {
                    $q->whereNull('image')
                      ->orWhere('image', '');
                });
                break;

            case 'todos':
            default:
                // Incluye todos los productos, incluso los que tienen stock en cero.
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
            $producto->marca ?? 'N/A',
            $producto->unidad_medida ?? 'N/A',
            $producto->stock_actual ?? 0,
            $producto->precio_unitario > 0
                ? $producto->precio_unitario
                : 'SIN PRECIO',
            $producto->ubicacion ?? 'SIN UBICACIÓN',
        ];
    }

    public function headings(): array
    {
        return [
            'Código',
            'Descripción',
            'Categoría',
            'Marca',
            'Unidad de medida',
            'Stock actual',
            'Precio unitario',
            'Ubicación',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 40,
            'C' => 22,
            'D' => 20,
            'E' => 20,
            'F' => 15,
            'G' => 18,
            'H' => 22,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $ultimaFila = $sheet->getHighestRow();

        return [
            // Cabecera
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '2563EB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // Bordes de toda la tabla
            'A1:H' . $ultimaFila => [
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

            // Alineación de columnas
            'A' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],

            'F' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],
            ],

            'G' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],
            ],

            'H' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
