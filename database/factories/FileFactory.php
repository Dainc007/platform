<?php

namespace Database\Factories;

use App\Models\Contractor;
use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => $this->faker->filePath(),
            'fileable_id' => Contractor::factory(),
            'fileable_type' => function () {
                return File::class;
            }
        ];
    }
}
