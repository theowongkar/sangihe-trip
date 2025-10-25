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
            'facility' => ['WiFi', 'Toilet', 'Parkir', 'Akses Jalan Memadai'],
            'price' => fake()->randomFloat(2, 10000, 500000),
            'owner_name' => fake()->name(),
            'owner_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gmaps_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.520371684216!2d124.82515770978824!3d1.461509361202184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x328774f1cf3a2d27%3A0x1566e000a954a226!2sFakultas%20Ilmu%20Budaya%20Universitas%20Sam%20Ratulangi!5e0!3m2!1sid!2sid!4v1761353543904!5m2!1sid!2sid',
            'status' => fake()->randomElement(['Draf', 'Terbit', 'Arsip']),
        ];
    }
}
