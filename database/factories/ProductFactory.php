<?php

namespace Database\Factories;

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
            'supplier' => fake()->randomElement(['Dostawca1', 'Dostawca2', 'Dostawca3', 'Dostawca4']),
            'code'     => fake()->randomNumber(9),
            'price'    => fake()->randomNumber(5),
            'currency' => fake()->randomElement(['PLN', 'EUR']),
            'brand'    => fake()->randomElement(['bosch', 'valeo', 'brembo'])
        ];
    }
}
