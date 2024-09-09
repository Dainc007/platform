<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Contractor;
use App\Models\Currency;
use App\Models\File;
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
            'contractor_id' => fake()->randomElement(Contractor::pluck('id')->toArray()),
            'code'     => fake()->randomNumber(9),
            'price'    => fake()->randomNumber(5),
            'currency_id' => fake()->randomElement(Currency::pluck('id')->toArray()),
            'brand_id'    => fake()->randomElement(Brand::pluck('id')->toArray()),
            'file_id'   => fake()->randomElement(File::pluck('id')->toArray()),
        ];
    }
}
