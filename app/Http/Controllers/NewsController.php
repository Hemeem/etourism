<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar artikel/cerita blog dengan fitur search dan filter kategori.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        
        // Memulai query builder dari model News
        $query = News::query();
        
        // 1. Kondisi Saringan Kata Kunci Pencarian (Search)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }
        
        // 2. Kondisi Saringan Kategori (Aman dari ketidakpastian nama kolom)
        if ($category) {
            if (Schema::hasColumn('news', 'category')) {
                $query->where('category', $category);
            } elseif (Schema::hasColumn('news', 'kategori')) {
                $query->where('kategori', $category);
            }
        }

        // Eksekusi data dari database dengan urutan terbaru
        $posts = $query->latest()->get();
        
        // Membagi data secara dinamis untuk layout halaman News Anda
        $featuredPost = $posts->first();
        $regularPosts = $posts->skip(1);

        return view('news', compact('posts', 'featuredPost', 'regularPosts', 'search', 'category'));
    }

    /**
     * Menampilkan detail isi satu artikel berita berdasarkan slug atau ID.
     */
    public function show($slug)
    {
        $query = News::query();
        
        // Cek apakah tabel news menggunakan struktur kolom slug atau ID
        if (Schema::hasColumn('news', 'slug')) {
            $query->where('slug', $slug);
        } else {
            $query->where('id', $slug);
        }

        $post = $query->firstOrFail();
        
        // Mengambil 3 artikel terkait terbaru (selain artikel yang sedang dibaca)
        $relatedPosts = News::where('id', '!=', $post->id)->latest()->take(3)->get();

        return view('news_detail', compact('post', 'relatedPosts'));
    }
}