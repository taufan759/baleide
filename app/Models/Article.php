<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'content_format',
        'thumbnail',
        'author',
        'excerpt',
        'post_type',
    ];

    // Relasi many-to-many dengan ArticleCategory
    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_article_category');
    }

    // Relasi many-to-many dengan Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    // Accessor untuk URL artikel
    public function getUrlAttribute()
    {
        return route('article.show', $this->slug);
    }
}