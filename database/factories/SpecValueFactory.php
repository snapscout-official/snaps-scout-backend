<?php

namespace Database\Factories;

use App\Models\SpecValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecValue>
 */
class SpecValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SpecValue::class;
    public function definition(): array
    {
        return [
            'spec_value' => fake()->name(),
        ];
    }
}
