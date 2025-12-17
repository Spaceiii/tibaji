<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AccessoryType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accessory>
 */
class AccessoryFactory extends Factory
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
            'accessory_type_id' => AccessoryType::all()->random()->id,
            'serial_number' => fake()->unique()->bothify('AC-#####??'),
            'manufacturer' => fake()->company(),
            'year_manufactured' => fake()->numberBetween(1990, 2024),
        ];
    }
}
