<?php

namespace Database\Factories;

use App\Models\Contractor;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contractor_id' => fake()->randomElement(Contractor::all()->toArray()),
            'code'     => fake()->randomNumber(9),
            'price'    => fake()->randomNumber(5),
            'currency_id' => fake()->randomElement(Currency::all()->toArray()),
            'brand'    => fake()->randomElement(['bosch', 'valeo', 'brembo'])
        ];
    }
}
