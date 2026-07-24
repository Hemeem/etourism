<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Menampilkan galeri foto pariwisata berdasarkan filter kategori.
    public function index(Request $request)
    {
        $allowedCategories = ['Semua', 'Wisata Bahari', 'Budaya & Sejarah', 'Kuliner', 'Alam'];
        $category = $request->query('category', 'Semua');
        if (!in_array($category, $allowedCategories)) {
            $category = 'Semua';
        }

        $galleryQuery = Gallery::query();

        if ($category !== 'Semua') {
            $galleryQuery->where('filter_category', $category);
        }
        
        $photos = $galleryQuery->latest()->paginate(12)->appends($request->all());

        return view('gallery', compact('photos', 'category', 'allowedCategories'));
    }
}