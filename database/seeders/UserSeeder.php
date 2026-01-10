<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator Lunaray',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'address' => 'Kantor Pusat Lunaray, Jakarta',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pembeli Ebook',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '089988776655',
            'address' => 'Jl. Keadilan No. 10, Bandung',
            'role' => 'user',
        ]);
    }
}