<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('news')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil satu user pertama di database (misal admin atau user seeder) sebagai fallback
        $user = User::first() ?? User::create([
            'name' => 'Admin Travel',
            'email' => 'admin@belitungbegaye.com',
            'password' => bcrypt('password'),
            'no_hp' => '08123456789',
            'role' => 'admin'
        ]);

        DB::table('news')->insert([
            [
                'user_id' => $user->id, // Memenuhi kriteria Foreign Key di ERD Anda
                'title' => '5 Tips Penting Liburan Pertama Kali ke Pulau Belitung',
                'content' => '<p>Pulau Belitung menawarkan pesona alam yang luar biasa dengan pantai pasir putih...</p>',
                'image' => 'tips_belitung.jpg',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id, // Memenuhi kriteria Foreign Key di ERD Anda
                'title' => 'Pesona Pulau Lengkuas dan Sejarah Mercusuar Tua 1882',
                'content' => '<p>Pulau Lengkuas tidak hanya terkenal dengan keindahan bawah lautnya...</p>',
                'image' => 'lengkuas_news.jpg',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}