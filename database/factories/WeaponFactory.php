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
            'caliber' => fake()->randomElement(['9mm PARA', '.223 Rem', '.308 Win', '12/76', '.45 ACP', '.22 LR', '6.5 Creedmoor', '.44 Mag']),
            'serial_number' => fake()->unique()->bothify('SN-#####??'),
            'brand' => fake()->company(),
            'category' => fake()->randomElement(['B', 'C', 'D']),
            'price' => fake()->randomFloat(2, 100, 5000),
            'quantity' => fake()->numberBetween(1, 100),
            'image' => fake()->randomElement([
                'weapons/default.png',
                'weapons/fusil.jpg',
                'weapons/pistolet.jpg'
            ]),
        ];
    }
}
