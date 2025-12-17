<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\License>
 */
class LicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'level' => fake()->randomElement(['B', 'C', 'D']),
            'expiration_date' => fake()->date(),
            'license_number' => fake()->unique()->bothify('LIC-#####??'),
            'user_id' => User::all()->random()->id,
        ];
    }
}
