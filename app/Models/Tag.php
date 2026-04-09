<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Relasi many-to-many dengan Article
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tag');
    }

    // Accessor untuk URL tag
    public function getUrlAttribute()
    {
        return route('article.tag', $this->slug);
    }
}