<?php

namespace App\Imports;

use App\Models\CategoryTest;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Row;

class CategoryTestImport implements WithMultipleSheets
{
    use Importable, WithConditionalSheets;

    public function sheets(): array
    {
        return [
            1 => new SecondSheetImport()
        ];
    }
    public function conditionalSheets(): array
    {
        return [
            'sheet2' => new SecondSheetImport(),
        ];
    }
}
