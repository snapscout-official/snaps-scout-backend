<?php

namespace Database\Seeders;

use App\Models\ParentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentCategories = [
            'Agricultural Chemicals',
            'Agricultural Products',
            'Animal Feeds',
            'Dairy Products',
            'Fertilizers',
            'Food Stuff',
            'Live Animals',
            'Pest Control Products',
            'Pest Control Services',
            'Preserved or Processed Foods',
            'Rice Milling'
        ];
        foreach ($parentCategories as $cat)
        {
            ParentCategory::create([
                'parent_name' => $cat
            ]);
        }
    }
}
