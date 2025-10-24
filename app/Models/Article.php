<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'content',
        'image_path',
        'status',
        'views'
    ];

    // Relasi ke penulis
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
