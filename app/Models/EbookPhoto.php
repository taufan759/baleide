<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookPhoto extends Model
{
    use HasFactory;

    protected $table = 'ebook_photos';

    protected $fillable = [
        'ebook_id',
        'photo'
    ];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
}