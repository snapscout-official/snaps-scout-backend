<?php

namespace Database\Factories;

use App\Models\SubCategory;
use App\Models\ThirdCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'product_name' => fake()->name(),
            'sub_code' => SubCategory::inRandomOrder()->first()->sub_id,
            'third_code' => Arr::random([
                ThirdCategory::inRandomOrder()->first()->third_id,
                null
            ]),
            'description' => fake()->sentence(),
        ];
    }
}
