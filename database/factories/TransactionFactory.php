<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['deposite', 'withdrawal'];
        $type = Arr::random($types);

        $partnerIds = Partner::pluck('id')->toArray();
        $partnerId = Arr::random($partnerIds);

        return [
            "amount" => fake()->randomFloat(2, 1000, 5000),
            "type" => $type,
            "date" => fake()->dateTimeBetween('-1 year', 'now'),
            "partner_id" => $partnerId,
            "note" => fake()->text(),
        ];
    }
}
