<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'code', 
        'discount_percent', 
        'status'
    ];

    public static function getCode($code)
    {
        $voucher = self::where('code', $code)
                       ->where('status', 'active')
                       ->first();

        if ($voucher) {
            return $voucher->discount_percent;
        }

        return 0;
    }
}