<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'balance' => fake()->randomFloat(2, 1000, 50000), // Random balance between 1000 and 5000
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'active' => fake()->boolean(),
        ];
    }
}
