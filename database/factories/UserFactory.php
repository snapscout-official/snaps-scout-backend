<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'birth_date' => fake()->date($max = '2000-01-01'),
            'gender' => fake()->randomElement(['male', 'female']),
            'phone_number' => fake()->phoneNumber(),
            'password' => Hash::make('Starmovies_12'),
            'tin_number' => fake()->unique()->numerify('#########'),
            'remember_token' => Str::random(10),
            'role_id' => Role::SUPERADMIN
        ];
    }

    
    /**
     * Indicate that the model's email address should be unverified.
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
