<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Menampilkan galeri foto pariwisata berdasarkan filter kategori.
     */
    public function index(Request $request)
    {
        // Menangkap filter parameter kategori dari link filter Blade (?category=...)
        // Default bernilai 'Semua' jika parameter tidak ditemukan di URL
        $category = $request->query('category', 'Semua');
        
        $galleryQuery = Gallery::query();
        
        // Jika memilih kategori spesifik selain 'Semua', lakukan penyaringan kolom
        if ($category && $category !== 'Semua') {
            $galleryQuery->where('filter_category', $category);
        }
        
        // Ambil data foto diurutkan dari yang paling baru diunggah
        $photos = $galleryQuery->orderBy('created_at', 'desc')->get();
        
        return view('gallery', compact('photos', 'category'));
    }
}