<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarType>
 */
class CarTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'length' => $this->faker->randomNumber(4, true),
            'width' => $this->faker->randomDigit(4, true),
            'height' => $this->faker->randomDigit(4, true),
        ];
    }
}
