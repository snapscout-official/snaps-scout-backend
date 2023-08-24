<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    
    public function run(): void
    {
        Product::create([
            'product_name' => 'Printer',
            'parent_code' => 1,
            'sub_code' => 1,
            'description' => fake()->sentence(),
        ]);
    }
}
