<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $title = fake()->sentence(4);
        return [
            'author_id' => User::inRandomOrder()->first()?->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraph(5),
            'image_path' => null,
            'status' => fake()->randomElement(['Draf', 'Terbit', 'Arsip']),
            'views' => fake()->numberBetween(0, 1000),
        ];
    }
}
