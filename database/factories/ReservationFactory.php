<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']);
        
        return [
            'user_id' => User::where('role', 'client')->inRandomOrder()->first()->id ?? User::factory(),
            'status' => $status,
            'total_amount' => fake()->randomFloat(2, 50, 5000),
            'confirmed_at' => $status !== 'pending' ? fake()->dateTimeBetween('-30 days', 'now') : null,
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-30 days', 'now') : null,
            'admin_notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the reservation is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'confirmed_at' => null,
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the reservation is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'confirmed_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the reservation is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'confirmed_at' => fake()->dateTimeBetween('-60 days', '-30 days'),
            'completed_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }
}
