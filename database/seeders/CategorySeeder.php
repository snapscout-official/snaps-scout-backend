<?php

namespace Database\Seeders;

use App\Models\ParentCategory;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            ['sub_name' => 'Computer HardWare', 'parent' => 1],
            ['sub_name' => 'Devices', 'parent' => 1],
            ['sub_name' => 'Computer Accessories', 'parent' => 1],
            ['sub_name' => 'Kitchen Furniture', 'parent' => 2],
            ['sub_name' => 'Computer Furniture', 'parent' => 2],
        ];
        foreach($values as $value)
        {
            SubCategory::create($value);
        }
    }
}
