<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'content',
        'image_path',
        'status',
        'views'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ],
        ];
    }

    // Relasi ke penulis
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
