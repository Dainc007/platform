<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arr = ['4.jpg', '1.png', '2.jpeg', '3.jpg'];
     return [
            'user_id' => 1,
            'title' => $title = fake()->title,
            'content' => fake()->realText(1000),
            'slug' => Str::slug(Str::words(5)),
            'img'  => '/dummy/' . $arr[rand(0,3)]
        ];
    }
}
