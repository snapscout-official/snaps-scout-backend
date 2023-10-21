<?php

namespace Database\Factories;

use App\Models\Spec;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SpecNameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Spec::class;
    public function definition(): array
    {
        return [
            'specs_name' => fake()->name(),
        ];
    }
}
