<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder paket wisata kamu di sini
        $this->call([
            PackageSeeder::class, // Sesuai nama class seeder yang aktif saat ini
            NewsSeeder::class,    // Seeder untuk data berita
            UserSeeder::class,    
        ]);
    }
}