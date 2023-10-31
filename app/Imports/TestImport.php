<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TestImport implements WithHeadingRow, SkipsEmptyRows, WithStartRow
{
    public const HEADINGROW = 4;
    public const GENERAL = 0;
    public const MEASURE = 1;
    public const QUANTITY = 2;
    // public function
    public function startRow(): int
    {
        return 2;
    }
}
