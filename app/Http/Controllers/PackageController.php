<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\News;
use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Http\Request;

class PackageController extends Controller 
{
    // 1. FUNGSI Halaman Beranda (Landing Page)
    public function index()
    {
        // Mengambil top 3 paket paling banyak dipesan
        $packages = Package::withCount(['reservations' => function ($query) {
                $query->where('status', 'success');
            }])
            ->orderBy('reservations_count', 'desc')
            ->take(3)
            ->get();

        $posts = News::latest()->take(3)->get();
        $reviews = Review::where('status', 'published')->latest()->take(3)->get();
        $averageRating = number_format(Review::where('status', 'published')->avg('rating') ?? 0.0, 1);
        $totalReviews = Review::where('status', 'published')->count();

        // 2. Tambahkan Query untuk mengambil 5 data galeri foto terbaru
        $photos = Gallery::latest()->take(5)->get();

        return view('welcome', compact(
            'packages', 
            'posts', 
            'reviews', 
            'averageRating', 
            'totalReviews',
            'photos'
        ));
    }

    // 2. FUNGSI Halaman Daftar Paket Tour
    public function tour(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $packages = Package::query()
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        return view('paket_tour', compact('packages', 'category', 'search'));
    }

    // 3. FUNGSI Halaman Detail Paket
    public function show($slug)
    {
        $package = Package::with([
            'reviews' => function ($query) {
                $query->where('status', 'published')->latest();
            },
            'reviews.user'
        ])->where('slug', $slug)->firstOrFail();

        return view('paket_detail', compact('package'));
    }
}