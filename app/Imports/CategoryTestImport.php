<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

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
