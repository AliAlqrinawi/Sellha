<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'type' => 'ADMIN',
            'email' => 'admin@admin.net',
            'name' => 'admin',
            'phone' => '0594148741',
            'otp' => '123456789',
            'password' => Hash::make('12345678'),
        ]);
    }
}
