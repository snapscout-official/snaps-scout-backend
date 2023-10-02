<?php

namespace Database\Factories;

use App\Models\ParentCategory;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sub_name' => fake()->word(),
            'parent' => ParentCategory::inRandomOrder()->first()->parent_id,
        ];
    }
}
