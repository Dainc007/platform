<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacation>
 */
class VacationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_at' => now(),
            'end_at' => $this->faker->dateTimeBetween('now', '+1 week'),
            'message' => '',
            'user_id' => rand(1, 10)
        ];
    }
}
