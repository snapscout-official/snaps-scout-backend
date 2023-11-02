<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoryExport implements FromView, WithCustomStartCell, WithColumnWidths, WithStyles
{

    public function __construct(public array $categories)
    {
    }
    public function collection()
    {
        return new Collection([
            [1, 2, 3],
            [4, 5, 6]
        ]);
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function view(): View
    {
        return view('categoryexport', ['categories' => $this->categories]);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 100,
            'C' => 55,
            'D' => 70
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        //center align the codes 
        for ($row = 4; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell("A{$row}")->getValue();
            if (is_numeric($cellValue)) {
                $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }
        $sheet->getStyle('1:1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('1:1')->getFont()->setBold(true);
        $sheet->getStyle('2:2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('1:1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('1:1')->getFill()->getStartColor()->setARGB('FFFF0000');
    }
}
