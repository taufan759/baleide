<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // Relasi many-to-many dengan Article
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_article_category');
    }

    // Accessor untuk URL kategori
    public function getUrlAttribute()
    {
        return route('article.category', $this->slug);
    }
}