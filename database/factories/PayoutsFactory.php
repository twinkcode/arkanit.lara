<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payouts>
 */
class PayoutsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'details' => fake()->text(random_int(100,1000)),
//                json_encode([
//                'card' => fake('ru')->creditCardDetails(),
//                'text' => fake('ru')->text(1000)
//            ],JSON_UNESCAPED_UNICODE),
            'amount'=>fake()->randomFloat(2),
            'currency'=>fake()->currencyCode(),

        ];
    }
}
