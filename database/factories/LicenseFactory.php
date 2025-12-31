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
        $status = fake()->randomElement(['pending', 'approved', 'rejected']);
        $submittedAt = fake()->dateTimeBetween('-60 days', 'now');
        
        return [
            'level' => fake()->randomElement(['B', 'C', 'D']),
            'expiration_date' => fake()->dateTimeBetween('now', '+2 years'),
            'license_number' => fake()->unique()->bothify('LIC-#####??'),
            'user_id' => User::all()->random()->id,
            'file_path' => fake()->optional()->filePath(),
            'status' => $status,
            'submitted_at' => $submittedAt,
            'verified_at' => $status !== 'pending' ? fake()->dateTimeBetween($submittedAt, 'now') : null,
            'admin_comment' => $status === 'rejected' ? fake()->sentence() : null,
        ];
    }

    /**
     * Indicate that the license is pending validation.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'verified_at' => null,
            'admin_comment' => null,
        ]);
    }

    /**
     * Indicate that the license is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'verified_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'admin_comment' => null,
        ]);
    }

    /**
     * Indicate that the license is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'verified_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'admin_comment' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the license is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expiration_date' => fake()->dateTimeBetween('-2 years', '-1 day'),
        ]);
    }
}
