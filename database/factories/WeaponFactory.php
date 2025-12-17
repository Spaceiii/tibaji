<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WeaponType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weapon>
 */
class WeaponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => fake()->word(),
            'weapon_type_id' => WeaponType::all()->random()->id,
            'caliber' => fake()->randomElement(['9mm', '5.56mm', '7.62mm', '12 gauge', '45 ACP', '22 LR', '308 Win']),
            'serial_number' => fake()->unique()->bothify('SN-#####??'),
            'brand' => fake()->company(),
            'category' => fake()->randomElement(['B', 'C', 'D']),
            'price' => fake()->randomFloat(2, 100, 5000),
            'quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
