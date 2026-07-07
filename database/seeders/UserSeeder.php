<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin Utama
        User::create([
            'name' => 'Admin',
            'email' => 'admin@belitungbegaye.com',
            'password' => Hash::make('admin123'), // Silakan ganti password ini demi keamanan
            'no_hp' => '081234567890',
            'role' => 'admin', // Menandakan bahwa user ini adalah admin
        ]);
    }
}