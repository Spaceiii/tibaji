<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\Weapon;
use App\Models\Accessory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationItem>
 */
class ReservationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Randomly choose between Weapon and Accessory
        $isWeapon = fake()->boolean();
        
        if ($isWeapon) {
            $product = Weapon::inRandomOrder()->first() ?? Weapon::factory()->create();
            $type = Weapon::class;
        } else {
            $product = Accessory::inRandomOrder()->first() ?? Accessory::factory()->create();
            $type = Accessory::class;
        }

        $quantity = fake()->numberBetween(1, 3);
        $unitPrice = $product->price;
        $subtotal = $quantity * $unitPrice;

        return [
            'reservation_id' => Reservation::factory(),
            'reservationable_id' => $product->id,
            'reservationable_type' => $type,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ];
    }

    /**
     * Indicate that the item is a weapon.
     */
    public function weapon(): static
    {
        return $this->state(function (array $attributes) {
            $weapon = Weapon::inRandomOrder()->first() ?? Weapon::factory()->create();
            $quantity = fake()->numberBetween(1, 2);
            
            return [
                'reservationable_id' => $weapon->id,
                'reservationable_type' => Weapon::class,
                'quantity' => $quantity,
                'unit_price' => $weapon->price,
                'subtotal' => $quantity * $weapon->price,
            ];
        });
    }

    /**
     * Indicate that the item is an accessory.
     */
    public function accessory(): static
    {
        return $this->state(function (array $attributes) {
            $accessory = Accessory::inRandomOrder()->first() ?? Accessory::factory()->create();
            $quantity = fake()->numberBetween(1, 5);
            
            return [
                'reservationable_id' => $accessory->id,
                'reservationable_type' => Accessory::class,
                'quantity' => $quantity,
                'unit_price' => $accessory->price,
                'subtotal' => $quantity * $accessory->price,
            ];
        });
    }
}
