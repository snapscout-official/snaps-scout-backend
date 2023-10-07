<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TestImport implements WithHeadingRow, SkipsEmptyRows, WithStartRow
{
    public const HEADINGROW = 4;
    // public function
    public function startRow(): int
    {
        return 2;
    }
    
}
