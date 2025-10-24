<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOperatingHour extends Model
{
    /** @use HasFactory<\Database\Factories\ProductOperatingHourFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'day',
        'open_time',
        'close_time',
        'is_open',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
