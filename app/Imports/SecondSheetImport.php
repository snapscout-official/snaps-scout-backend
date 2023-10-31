<?php

namespace App\Imports;

use App\Models\CategoryTest;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SecondSheetImport implements WithHeadingRow, SkipsEmptyRows, ToModel
{
    public const HEADER = 4;
    public function model(array $row)
    {
        $categoryTest = CategoryTest::where('general_description', $row['general_description'])->first();
        if (!is_null($categoryTest)) {
            return null;
        }
        return new CategoryTest([
            'general_description' => $row['general_description'],
            'unit_of_measure' => $row['unit_of_measure'],
            'quantity' => $row['quantitysize']
        ]);
    }
    public function headingRow(): int
    {
        return self::HEADER;
    }
}
