<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductReview;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\ProductOperatingHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 admin utama
        User::factory()->create([
            'name' => 'Admin Sangihe',
            'email' => 'admin@sangihetrip.com',
            'role' => 'Admin',
        ]);

        // Buat pengguna acak
        User::factory(10)->create();

        // Buat Subategori produk
        $productCategories = [
            "Makanan & Minuman",
            "Fashion & Aksesoris",
            "Kecantikan & Perawatan",
            "Elektronik & Gadget",
            "Kerajinan & Handmade",
            "Rumah Tangga & Properti",
            "Pertanian, Perikanan & Peternakan",
            "Jasa & Layanan",
            "Destinasi Wisata"
        ];

        foreach ($productCategories as $productCategory) {
            ProductCategory::factory()->create([
                'name' => $productCategory,
                'slug' => Str::slug($productCategory),
            ]);
        }

        // Buat produk
        Product::factory(30)->create([
            'product_category_id' => ProductCategory::inRandomOrder()->first()?->id,
        ])->each(function ($product) {

            // Jam Operasional
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            foreach ($days as $day) {
                ProductOperatingHour::factory()->create([
                    'product_id' => $product->id,
                    'day' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '17:00:00',
                    'is_open' => true,
                ]);
            }

            // Review
            ProductReview::factory(rand(3, 6))->create(['product_id' => $product->id]);
        });

        // Buat artikel
        Article::factory(10)->create();
    }
}
