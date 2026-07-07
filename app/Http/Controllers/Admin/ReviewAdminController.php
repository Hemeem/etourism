<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Controllers\Controller;

class ReviewAdminController extends Controller
{
    // 1. Menampilkan Semua Data Ulasan Pelanggan
    public function index()
    {
        // Mengambil semua ulasan, diurutkan dari yang terbaru, beserta relasi user dan package
        $reviews = Review::with(['user', 'package'])->orderBy('created_at', 'desc')->get();
        
        return view('admin.reviews.index', compact('reviews'));
    }

    // 2. Memproses Moderasi Setuju / Tolak dari Admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            // Izinkan status: published, archived, atau pending
            'status' => 'required|in:published,archived,pending'
        ]);

        $review = Review::findOrFail($id);
        $review->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status visibilitas ulasan berhasil diperbarui!');
    }
}