<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ebook extends Model
{
    use HasFactory;

    protected $table = 'ebooks';

    protected $fillable = [
        'category_id', 
        'title', 
        'slug', 
        'author', 
        'isbn', 
        'description', 
        'price', 
        'stock', 
        'total_pages', 
        'file_format', 
        'file'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(EbookPhoto::class, 'ebook_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'ebook_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'ebook_id');
    }
}