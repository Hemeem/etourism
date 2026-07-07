<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Review::create([
            'user_id' => 1,
            'package_id' => 1,
            'rating' => 5,
            'comment' => 'Pelayanan sangat profesional! Kamar hotel bersih, makanan khas Belitung-nya enak banget, dan pemandu wisatanya ramah serta paham spot foto yang bagus di Pantai Tanjung Tinggi.',
            'status' => 'published' 
        ]);

        Review::create([
            'user_id' => 1,
            'package_id' => 1,
            'rating' => 5,
            'comment' => 'Hopping island-nya seru parah! Fasilitas boat dan alat snorkeling lengkap banget. Adminnya juga sangat responsif pas diajak konsultasi masalah jadwal penerbangan.',
            'status' => 'published' 
        ]);
        
        Review::create([
            'user_id' => 1,
            'package_id' => 1,
            'rating' => 5,
            'comment' => 'Liburan keluarga jadi gak ribet berkat Belitung Begaye. Semua itinerary teratur rapi, transportasinya nyaman dan bersih. Anak-anak seneng banget pas diajak ke SD Laskar Pelangi.',
            'status' => 'published' 
        ]);
    }
}