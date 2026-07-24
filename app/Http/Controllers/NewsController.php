<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class NewsController extends Controller
{
    // Menampilkan daftar artikel/cerita blog dengan fitur search dan filter kategori.
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        
        $query = News::query();
        
        if ($search) {
            $escapedSearch = addcslashes($search, '%_');

            $query->where(function($q) use ($escapedSearch) {
                $q->where('title', 'like', '%' . $escapedSearch . '%')
                  ->orWhere('content', 'like', '%' . $escapedSearch . '%');
            });
        }
        
        if ($category) {
            if (Schema::hasColumn('news', 'category')) {
                $query->where('category', $category);
            } elseif (Schema::hasColumn('news', 'kategori')) {
                $query->where('kategori', $category);
            }
        }
        /** @var \Illuminate\Pagination\LengthAwarePaginator $posts */
        $posts = $query->latest()->paginate(7)->appends($request->all());
        
        $featuredPost = $posts->first();
        $regularPosts = $posts->slice(1);

        return view('news', compact('posts', 'featuredPost', 'regularPosts', 'search', 'category'));
    }

    // Menampilkan detail isi satu artikel berita berdasarkan slug atau ID.
    public function show($slug)
    {
        $query = News::query();
        
        if (Schema::hasColumn('news', 'slug')) {
            $query->where('slug', $slug);
        } else {
            $query->where('id', $slug);
        }

        $post = $query->firstOrFail();
        
        $relatedPosts = News::where('id', '!=', $post->id)
                            ->latest()
                            ->take(3)
                            ->get();

        return view('news_detail', compact('post', 'relatedPosts'));
    }
}