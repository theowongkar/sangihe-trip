<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductCategory;
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
        $name = fake()->unique()->words(3, true);
        return [
            'product_category_id' => ProductCategory::inRandomOrder()->first()?->id,
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'description' => fake()->paragraph(5),
            'facility' => [
                'wifi' => fake()->boolean(),
                'toilet' => fake()->boolean(),
                'parkir' => fake()->boolean(),
                'makanan' => fake()->boolean(),
            ],
            'price' => fake()->randomFloat(2, 10000, 500000),
            'owner_name' => fake()->name(),
            'owner_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gmaps_link' => fake()->optional()->url(),
            'status' => fake()->randomElement(['Draf', 'Terbit', 'Arsip']),
        ];
    }
}
