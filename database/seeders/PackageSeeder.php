<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('packages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil gambar fisik dan ubah menjadi data biner / Base64 String
        $leebongPath = public_path('images/leebong.jpg');
        $hoppingPath = public_path('images/hopping_island.jpg');

        // Proteksi jika file gambar fisik belum ditaruh di folder public/images
        $leebongBase64 = file_exists($leebongPath) ? base64_encode(file_get_contents($leebongPath)) : null;
        $hoppingBase64 = file_exists($hoppingPath) ? base64_encode(file_get_contents($hoppingPath)) : null;

        DB::table('packages')->insert([
            [
                'title' => 'Paket Tour Leebong Island Premium',
                'slug' => 'paket-tour-leebong-island-premium',
                'category' => 'Premium Tour',
                'duration' => '3 Hari 2 Malam',
                'min_pax' => 2,
                'price' => 1500000,
                'description' => 'Nikmati keindahan Pulau Leebong yang eksklusif dengan fasilitas sepeda pantai, kayaking, dan makan malam romantis...',
                'image' => $leebongBase64, // <-- Berisi data biner gambar mentah, bukan link teks
                'includes' => 'Tiket kapal penyeberangan, makan siang seafood, fasilitas watersport non-motor, pemandu lokal.',
                'excludes' => 'Tiket pesawat, pengeluaran pribadi, tips pemandu.',
                'itinerary' => 'Hari 1: Penjemputan di Bandara - Menuju Dermaga Pegantungan - Penyeberangan ke Pulau Leebong - Aktivitas pantai...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Paket Sailing Laskar Pelangi (Hopping Island)',
                'slug' => 'paket-sailing-laskar-pelangi',
                'category' => 'Hoping Island',
                'duration' => '1 Hari Full',
                'min_pax' => 5,
                'price' => 450000,
                'description' => 'Jelajahi gugusan pulau granit ikonik Belitung mulai dari Pulau Batu Garuda, Pulau Pasir...',
                'image' => $hoppingBase64, // <-- Berisi data biner gambar mentah, bukan link teks
                'includes' => 'Sewa Boat Tradisional, Life Jacket, Alat Snorkeling, Makan Siang di Pulau Kepayang, Tiket Masuk Mercusuar.',
                'excludes' => 'Transportasi ke dermaga, dokumentasi gopro (opsional).',
                'itinerary' => 'Hari 1: Berkumpul di Tanjung Kelayang - Berlayar ke Pulau Batu Berlayar - Singgah di Pulau Pasir...',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}