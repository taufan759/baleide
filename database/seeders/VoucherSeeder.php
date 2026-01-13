<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [
            [
                'name' => 'Diskon Tahun Baru',
                'code' => 'NEWYEAR2025',
                'discount_percent' => 15,
                'status' => 'active'
            ],
            [
                'name' => 'Diskon Member Baru',
                'code' => 'WELCOME10',
                'discount_percent' => 10,
                'status' => 'active'
            ],
            [
                'name' => 'Flash Sale',
                'code' => 'FLASH20',
                'discount_percent' => 20,
                'status' => 'active'
            ],
            [
                'name' => 'Diskon Weekend',
                'code' => 'WEEKEND5',
                'discount_percent' => 5,
                'status' => 'active'
            ]
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}