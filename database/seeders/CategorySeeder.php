<?php

namespace Database\Seeders;

use App\Models\ParentCategory;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ThirdCategory;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $values = [
        //     ['parent_name' => 'Computers'],
        //     ['parent_name' => 'Office Supplies'],
        // ];
        // foreach($values as $value)
        // {
        //     ParentCategory::create($value);
        // }
        // $values = [
        //     ['sub_name' => 'Computer HardWare', 'parent' => 1],
        //     ['sub_name' => 'Devices', 'parent' => 1],
        //     ['sub_name' => 'Computer Accessories', 'parent' => 1],
        //     ['sub_name' => 'Kitchen Furniture', 'parent' => 2],
        //     ['sub_name' => 'Computer Furniture', 'parent' => 2],
        // ];
        
        $values = [
            ['third_name' => 'Test1', 'sub_id' => 1],
            ['third_name' => 'Test2', 'sub_id' => 1],
            ['third_name' => 'Test3', 'sub_id' => 1],
            ['third_name' => 'Test4', 'sub_id' => 2],
            ['third_name' => 'Test5', 'sub_id' => 2],
        ];
        foreach($values as $value)
        {
            ThirdCategory::create($value);
        }
    }
}
