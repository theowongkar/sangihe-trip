<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'description',
        'facility',
        'price',
        'owner_name',
        'owner_phone',
        'address',
        'gmaps_link',
        'status',
    ];

    protected $casts = [
        'facility' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ],
        ];
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // Relasi ke gambar
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relasi ke jam operasional
    public function operatingHours()
    {
        return $this->hasMany(ProductOperatingHour::class);
    }

    // Relasi ke review
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Hitung rata-rata rating
    public function averageRating()
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    // Ambil gambar utama
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}
